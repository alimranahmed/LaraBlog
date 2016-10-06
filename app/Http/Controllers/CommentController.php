<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

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
            $newComment = Article::create($newComment);
        }catch(\PDOException $e){
            return response()->json(['message' => $e->getMessage()]);
        }
        return response()->json(['message' => 'Article created successfully!', 'entity' => $newComment]);
    }
}
