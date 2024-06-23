<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Keyword;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class KeywordController extends Controller
{
    public function index(): View
    {
        $keywords = Keyword::with('articles')->get();

        return view('backend.keywords.index', compact('keywords'));
    }

    public function getArticles(Request $request, $keywordName): View
    {
        $articles = Article::getPaginated($request);

        return view('frontend.articles.index', compact('articles'));
    }
}
