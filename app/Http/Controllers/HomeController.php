<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){
        if(Auth::check()){
           return view('backend.dashboard');
        }else{
            $articles =  Article::where('is_published', 1)->where('is_deleted', 0)
                ->orderBy('published_at', 'desc')
                ->orderBy('created_at', 'desc')
                ->paginate(15);
            return view('frontend.articles', compact('articles'));
        }
    }
}
