<?php

namespace App\Http\Controllers;

use App\Models\Keyword;
use Illuminate\Http\Request;

class KeywordController extends Controller
{
    public function index(Request $request){
        $keywords = Keyword::all();
        return view('backend.keywordList', compact('keywords'));
    }
}
