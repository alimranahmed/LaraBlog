<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
        /** @var User $user */
        $user = Auth::user();
        if ($article->hasAuthorization($user)) {
            return redirect()->route('home')->with('errorMsg', 'Unauthorized request');
        }

        return view('backend.articles.edit', compact('article'));
    }
}
