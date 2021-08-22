<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Keyword;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ArticleController extends Controller
{
    public function index()
    {
        return view('backend.articles.index');
    }

    public function create(Article $article)
    {
        return view('backend.articles.create', compact('article'));
    }

    public function edit(Article $article)
    {
        if ($article->hasAuthorization(Auth::user())) {
            return redirect()->route('home')->with('errorMsg', 'Unauthorized request');
        }

        return view('backend.articles.edit', compact('article'));
    }
}
