<?php

namespace App\Http\Controllers;

use App\Models\Keyword;
use Illuminate\Http\Request;

class KeywordController extends Controller
{
    public function index(Request $request){
        $keywords = Keyword::with('articles')->get();
        return view('backend.keywordList', compact('keywords'));
    }

    public function toggleActive(Request $request, $keywordId){
        $keyword = Keyword::find($keywordId);
        try{
            $keyword->update(['is_active' => !$keyword->is_active]);
        }catch(\PDOException $e){
            return response()->json(['message' => $e->getMessage()]);
        }
        return redirect()->route('keywords');
    }
}
