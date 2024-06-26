<?php

namespace App\Http\Controllers;

use App\Mail\NotifyCommentThread;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CommentController extends Controller
{
    public function confirmComment(Request $request, $commentId): View|RedirectResponse
    {
        try {
            $request->validate(['token' => 'required']);

            /** @var Comment $comment */
            $comment = Comment::query()
                ->where('id', $commentId)
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
                $threadUserIDs = Comment::query()->where('parent_comment_id', $comment->parent_comment_id)
                    ->orWhere('id', $comment->parent_comment_id)
                    ->pluck('user_id');

                $threadUserEmails = User::query()->whereIn('id', $threadUserIDs)
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
