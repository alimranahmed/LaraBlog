<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Address;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;

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

                if($request->has('email')){
                    $newUser = $request->only('email');
                    $newUser = User::firstOrCreate($newUser);
                    if($request->has('name') && !empty($request->get('name'))){
                        $newUser->name = $request->get('name');
                        $newUser->save();
                    }
                    $newComment['user_id'] = $newUser->id;
                }

                Comment::create($newComment);
            });
        }catch(\PDOException $e){
            return response()->json(['message' => $e->getMessage()]);
        }
        //return response()->json(['message' => 'Article created successfully!', 'entity' => $newComment]);
        return redirect()->route('get-article', $articleId);
    }
}
