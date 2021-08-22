<?php

namespace App\Http\Controllers;

use App\Http\Requests\KeywordRequest;
use App\Models\Article;
use App\Models\Keyword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class KeywordController extends Controller
{
    public function index()
    {
        $keywords = Keyword::with('articles')->get();
        return view('backend.keywords.index', compact('keywords'));
    }
}
