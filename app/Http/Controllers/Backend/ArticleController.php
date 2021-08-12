<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    public function index()
    {
        return view('backend.articles.index');
    }
}
