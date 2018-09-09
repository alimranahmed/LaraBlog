<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Mail\CommentConfirmation;
use App\Mail\NotifyAdmin;
use App\Mail\NotifyCommentThread;
use App\Models\Address;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Config;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CommentController extends Controller
{
    public function index()
    {
        if (Auth::user()->hasRole('author')) {
            $authorsArticleIDs = Article::where('user_id', Auth::user()->id)->pluck('id');
            $comments = Comment::whereIn('article_id', $authorsArticleIDs)
                ->with('article', 'user', 'replies')
                ->latest()
                ->noReplies()
                ->get();
        } else {
            $comments = Comment::with('article', 'user', 'replies')->latest()->noReplies()->get();
        }
        return view('backend.commentList', compact('comments'));
    }

    public function store(CommentRequest $request, $articleId)
    {
        $article = Article::find($articleId);
        if (is_null($article)) {
            return response()->json(['errorMsg' => 'Article not found'], Response::HTTP_NOT_FOUND);
        }

        if (!$article->is_comment_enabled) {
            return response()->json(
                ['errorMsg' => 'Comment is not allowed for this article'],
                Response::HTTP_FORBIDDEN
            );
        }

        $clientIP = $_SERVER['REMOTE_ADDR'] ?? '';
        $newComment = $request->only('content', 'parent_comment_id');
        $newAddress = ['ip' => $clientIP];
        try {
            \DB::transaction(function () use (&$newComment, $newAddress, $articleId, $request, $clientIP) {
                //Create new address
                $newAddress = Address::create($newAddress);
                //Create new comment
                $newComment['address_id'] = $newAddress->id;
                $newComment['article_id'] = $articleId;
                $newComment['token'] = \Hash::make($newComment['content']);
                $newComment['is_published'] = 0;

                $newUser = User::where('email', $request->get('email'))->first();
                if (is_null($newUser)) {
                    $newUser = $request->only('email');
                    $newUser = User::create($newUser);
                    $newUser->attachRole(Role::where('name', 'reader')->first());

                    $newUser->reader()->create([
                        'notify' => $request->has('notify'),
                    ]);
                } elseif ($newUser->isReader()) {
                    $newUser->reader->update(['notify' => $request->has('notify')]);
                }
                if ($request->has('name')) {
                    $newUser->name = $request->get('name');
                }
                $newUser->last_ip = $clientIP;
                $newUser->token = \Hash::make($newComment['content']);
                $newUser->save();
                $newComment['user_id'] = $newUser->id;
                $newComment = Comment::create($newComment);
                Article::where('id', $articleId)->increment('comment_count');
            });
            //$this->dispatch(new SendConfirmCommentMail($newComment));
        } catch (\Exception $e) {
            Log::error($this->getLogMsg($e));
            return response()->json(['errorMsg' => $this->getMessage($e)], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $comments = Comment::where('article_id', $articleId)
            ->published()
            ->noReplies()
            ->get();

        //event(new CommentOnArticle('New comment posted!'));
        Mail::to($request->get('email'))->queue(new CommentConfirmation($newComment));

        Mail::to(Config::get('admin_email'))
            ->queue(new NotifyAdmin($newComment, route('get-article', $articleId)));

        return view('frontend._comments', compact('comments', 'article'));
    }

    public function update(Request $request, $commentId)
    {
        $comment = Comment::find($commentId);
        try {
            $comment->update([
                'content' => $request->get('content'),
                'originalContent' => $comment->countEdit == 0 ? $comment->content : $comment->originalContent,
                'countEdit' => $comment->countEdit + 1,
            ]);
        } catch (\PDOException $e) {
            Log::error($this->getLogMsg($e));
            return redirect()->back()->with('errorMsg', $this->getMessage($e));
        }
        return redirect()->route('comments')->with('successMsg', 'Comment updated');
    }

    public function togglePublish($commentId)
    {
        $comment = Comment::find($commentId);
        try {
            $comment->update([
                'is_published' => !$comment->is_published,
                'published_at' => new \DateTime(),
            ]);
        } catch (\PDOException $e) {
            Log::error($this->getLogMsg($e));
            return redirect()->back()->with('errorMsg', $this->getMessage($e));
        }
        return redirect()->route('comments')->with('successMsg', 'Comment updated');
    }

    public function destroy($commentId)
    {
        try {
            $comment = Comment::find($commentId);
            Article::where('id', $comment->article_id)->decrement('comment_count');
            Comment::destroy($commentId);
        } catch (\PDOException $e) {
            Log::error($this->getLogMsg($e));
            return redirect()->back()->with('errorMsg', $this->getMessage($e));
        }
        return redirect()->route('comments')->with('successMsg', 'Comment deleted');
    }

    public function confirmComment(Request $request, $commentId)
    {
        try {
            $this->validate($request, ['token' => 'required']);

            $comment = Comment::where('id', $commentId)
                ->where('token', $request->get('token'))
                ->with('article')
                ->first();

            if (is_null($comment)) {
                return redirect()->route('home')->with('errorMsg', 'Invalid request');
            }

            if ($comment->is_published) {
                return redirect()->route('get-article', [$comment->article->id])
                    ->with('warningMsg', 'Comment already published');
            }

            $comment->update(['is_published' => 1, 'is_confirmed' => 1, 'published_at' => now()]);
            if ($comment->user->isReader()) {
                $comment->user->reader->update(['is_verified' => 1]);
            }
            //notify all user of the comment thread about the new comment except him person who replied
            if ($comment->parent_comment_id) {
                $threadUserIDs = Comment::where('parent_comment_id', $comment->parent_comment_id)
                    ->orWhere('id', $comment->parent_comment_id)
                    ->pluck('user_id');

                $threadUserEmails = User::whereIn('id', $threadUserIDs)
                    ->where('email', '!=', $comment->user->email)
                    ->pluck('email')
                    ->unique()
                    ->toArray();

                Mail::to($threadUserEmails)->queue(new NotifyCommentThread($comment));
            }
        } catch (\Exception $e) {
            Log::error($this->getLogMsg($e));
            return redirect()->route('get-article', [$comment->article->id])
                ->with('errorMsg', $this->getMessage($e));
        }
        return redirect()->route('get-article', [$comment->article->id])
            ->with('successMsg', 'Comment confirmed successfully!');
    }
}
