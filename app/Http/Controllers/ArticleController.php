<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request){
        return Article::all();
    }

    public function show(Request $request, $articleId){
        $article = Article::where('id', $articleId)->with('comments')->first();
        return $article;
    }
}
