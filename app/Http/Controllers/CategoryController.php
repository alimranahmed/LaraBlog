<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return view('backend.categories.index');
    }

    public function getArticles(Request $request, $categoryAlias)
    {
        $articles = Article::getPaginated($request);

        return view("frontend.articles.index", compact('articles'));
    }
}
