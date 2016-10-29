<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $articleId){
        $clientIP = $_SERVER['REMOTE_ADDR'];

        $newComment = $request->only('content');
        $newAddress = ['ip' => $clientIP];
        try{
            //Create new address
            $newAddress = Address::create($newAddress);
            //Create new article
            $newComment['address_id'] = $newAddress->id;
            $newComment['article_id'] = $articleId;
            $newComment = Comment::create($newComment);
        }catch(\PDOException $e){
            return response()->json(['message' => $e->getMessage()]);
        }
        //return response()->json(['message' => 'Article created successfully!', 'entity' => $newComment]);
        return redirect()->route('get-article', $articleId);
    }
}
