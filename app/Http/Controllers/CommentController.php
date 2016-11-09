<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Mail\CommentConfirmation;
use App\Models\Address;
use App\Models\Comment;
use App\Models\Reader;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CommentController extends Controller
{
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
                    $newUser = $request->only('email');
                    $newUser = User::firstOrCreate($newUser);
                    //If name provided then add name to the created user
                    if($request->has('name')){
                        $newUser->name = $request->get('name');
                    }
                    $newUser->reader()->create([
                        'notify' => $request->has('notify'),
                    ]);
                    $newComment['user_id'] = $newUser->id;
                }
                Comment::create($newComment);
            });
            //TODO as reader doesn't need to login, their comment need to be confirmed
            //Mail::to("name@gmail.com")->send(new CommentConfirmation());
        }catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()]);
        }
        //return response()->json(['message' => 'Article created successfully!', 'entity' => $newComment]);
        return redirect()->route('get-article', $articleId);
    }
}
