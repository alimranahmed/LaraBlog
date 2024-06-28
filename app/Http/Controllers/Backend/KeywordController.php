<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Keyword;
use Illuminate\Contracts\View\View;

class KeywordController extends Controller
{
    public function index(): View
    {
        $keywords = Keyword::with('articles')->get();

        return view('backend.keywords.index', compact('keywords'));
    }
}
