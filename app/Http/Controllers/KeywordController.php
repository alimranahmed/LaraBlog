<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Keyword;
use Illuminate\Http\Request;

class KeywordController extends Controller
{
    public function index()
    {
        $keywords = Keyword::with('articles')->get();
        return view('backend.keywords.index', compact('keywords'));
    }

    public function getArticles(Request $request, $keywordName)
    {
        $articles = Article::getPaginated($request);

        return view("frontend.articles.index", compact('articles'));
    }
}
