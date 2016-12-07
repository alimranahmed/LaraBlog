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
            return redirect()->back()->with('errorMsg', $this->getMessage($e));
        }
        return redirect()->route('keywords')->with('successMsg', 'Keyword updated');
    }

    public function update(Request $request, $keywordId){
        $updatedKeyword = $request->only('name');
        try{
            Keyword::where('id', $keywordId)->update($updatedKeyword);
        }catch(\PDOException $e){
            return redirect()->back()->with('errorMsg', $this->getMessage($e));
        }
        return redirect()->route('keywords')->with('successMsg', 'Keyword updated');
    }
}
