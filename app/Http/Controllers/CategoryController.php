<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request){
        return Category::all();
    }

    public function show(Request $request, $categoryId){
        return Category::with('articles')->find($categoryId);
    }
}
