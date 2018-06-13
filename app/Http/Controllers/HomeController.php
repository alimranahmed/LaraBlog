<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check()) {
            $dashboard = new DashboardController();
            return $dashboard->index();
        } else {
            $articles = Article::getPaginate($request);
            return view('frontend.articles', compact('articles'));
        }
    }
}
