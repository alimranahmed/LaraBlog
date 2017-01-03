<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Mail\CommentConfirmation;
use App\Models\Address;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Reader;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CommentController extends Controller
{
    public function index(){
        if(Auth::user()->hasRole('author')){
            $authorsArticleIDs = Article::where('user_id', Auth::user()->id)->pluck('id');
            $comments = Comment::whereIn('article_id', $authorsArticleIDs)
                ->with('article', 'user')->orderBy('id', 'desc')
                ->get();
        }else{
            $comments = Comment::with('article', 'user')->orderBy('id', 'desc')->get();
        }
        return view('backend.commentList', compact('comments'));
    }

    public function store(CommentRequest $request, $articleId){
        $clientIP = $_SERVER['REMOTE_ADDR'];
        $newComment = $request->only('content');
        $newAddress = ['ip' => $clientIP];
        try{
            \DB::transaction(function() use($newComment, $newAddress, $articleId, $request){
                //Create new address
                $newAddress = Address::create($newAddress);
                //Create new article
                $newComment['address_id'] = $newAddress->id;
                $newComment['article_id'] = $articleId;

                //If email exist create new user
                if($request->has('email')){
                    $newUser = User::where('email', $request->get('email'))->first();
                    if(is_null($newUser)){
                        $newUser = $request->only('email');
                        $newUser = User::create($newUser);
                        $newUser->attachRole(Role::where('name', 'reader')->first());
                    }
                    //If name provided then add name to the created user
                    if($request->has('name')){
                        $newUser->name = $request->get('name');
                        $newUser->save();
                    }
                    $newUser->reader()->create([
                        'notify' => $request->has('notify'),
                    ]);
                    $newComment['user_id'] = $newUser->id;
                }
                Comment::create($newComment);
                Article::where('id', $articleId)->increment('comment_count');
            });
            //TODO as reader doesn't need to login, their comment need to be confirmed
            //Mail::to("name@gmail.com")->send(new CommentConfirmation());
        }catch(\Exception $e){
            //return redirect()->back()->with('errorMsg', $this->getMessage($e))->withInput();
            return response()->json(['errorMsg' => $this->getMessage($e)], 503);
        }
        //return response()->json(['message' => 'Article created successfully!', 'entity' => $newComment]);
        //return redirect()->route('get-article', $articleId)->with('successMsg', 'Comment posted');
        $comments = Comment::where('is_published', 1)
            ->where('article_id', $articleId)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('frontend._comments', compact('comments') );
    }

    public function update(Request $request, $commentId){
        $comment = Comment::find($commentId);
        try{
            $comment->update([
                'content' => $request->get('content'),
                'originalContent' => $comment->countEdit == 0 ? $comment->content : $comment->originalContent,
                'countEdit' => $comment->countEdit+1,
            ]);
        }catch(\PDOException $e){
            return redirect()->back()->with('errorMsg', $this->getMessage($e));
        }
        return redirect()->route('comments')->with('successMsg', 'Comment updated');
    }

    public function togglePublish(Request $request, $commentId){
        $comment = Comment::find($commentId);
        try{
            $comment->update([
                'is_published' => !$comment->is_published,
                'published_at' => new \DateTime(),
            ]);
        }catch(\PDOException $e){
            return redirect()->back()->with('errorMsg', $this->getMessage($e));
        }
        return redirect()->route('comments')->with('successMsg', 'Comment updated');
    }

    public function destroy(Request $request, $commentId){
        try{
            Comment::destroy($commentId);
        }catch (\PDOException $e){
            return redirect()->back()->with('errorMsg', $this->getMessage($e));
        }
        return redirect()->route('comments')->with('successMsg', 'Comment deleted');
    }

    public function confirmComment(Request $request, $commentId, $token){
        return "It works!";
    }
}
