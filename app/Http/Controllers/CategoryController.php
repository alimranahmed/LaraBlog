<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
