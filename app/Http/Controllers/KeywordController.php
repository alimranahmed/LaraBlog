<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class KeywordController extends Controller
{
    public function getArticles(Request $request, $keywordName): View
    {
        $articles = Article::getPaginated($request);

        return view('frontend.articles.index', compact('articles'));
    }
}
