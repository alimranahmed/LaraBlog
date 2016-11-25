<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){
        if(Auth::check()){
           return view('backend.dashboard');
        }else{
            $articles =  Article::all();
            return view('frontend.articles', compact('articles'));
        }
    }
}
