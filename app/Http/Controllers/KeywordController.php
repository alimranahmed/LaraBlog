<?php

namespace App\Http\Controllers;

use App\Http\Requests\KeywordRequest;
use App\Models\Article;
use App\Models\Keyword;

class KeywordController extends Controller
{
    public function index(){
        $keywords = Keyword::with('articles')->get();
        return view('backend.keywordList', compact('keywords'));
    }

    public function store(KeywordRequest $request){
        $newKeyword = $request->only('name');
        try{
            Keyword::create($newKeyword);
        }catch(\PDOException $e){
            return redirect()->back()->with('errorMsg', $this->getMessage($e));
        }
        return redirect()->route('keywords')->with('successMsg', 'Keyword added');
    }

    public function toggleActive($keywordId){
        $keyword = Keyword::find($keywordId);
        try{
            $keyword->update(['is_active' => !$keyword->is_active]);
        }catch(\PDOException $e){
            return redirect()->back()->with('errorMsg', $this->getMessage($e));
        }
        return redirect()->route('keywords')->with('successMsg', 'Keyword updated');
    }

    public function update(KeywordRequest $request, $keywordId){
        $updatedKeyword = $request->only('name');
        try{
            Keyword::where('id', $keywordId)->update($updatedKeyword);
        }catch(\PDOException $e){
            return redirect()->back()->with('errorMsg', $this->getMessage($e));
        }
        return redirect()->route('keywords')->with('successMsg', 'Keyword updated');
    }

    public function destroy($keywordId){
        try{
            Keyword::destroy($keywordId);
        }catch (\PDOException $e){
            return redirect()->back()->with('errorMsg', $this->getMessage($e));
        }
        return redirect()->route('keywords')->with('successMsg', 'Keyword deleted');
    }

    public function getArticles($keywordName){
        $keyword = Keyword::where('name', $keywordName)->first();
        if(is_null($keyword)){
            return redirect()->route('home')->with('warningMsg', 'Keyword not found');
        }
        $articleIds = $keyword->articles->pluck('id')->toArray();
        $articles = Article::whereIn('id', $articleIds)
            ->where('is_deleted', 0)
            ->where('is_published', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('frontend.articles', compact('articles'));
    }
}
