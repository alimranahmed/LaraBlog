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
        return view('backend.keywordList', compact('keywords'));
    }

    public function store(KeywordRequest $request)
    {
        $newKeyword = $request->only('name');
        try {
            Keyword::create($newKeyword);
        } catch (\PDOException $e) {
            Log::error($this->getLogMsg($e));
            return redirect()->back()->with('errorMsg', $this->getMessage($e));
        }
        return redirect()->route('keywords')->with('successMsg', 'Keyword added');
    }

    public function toggleActive($keywordId)
    {
        $keyword = Keyword::find($keywordId);
        try {
            $keyword->update(['is_active' => !$keyword->is_active]);
        } catch (\PDOException $e) {
            Log::error($this->getLogMsg($e));
            return redirect()->back()->with('errorMsg', $this->getMessage($e));
        }
        return redirect()->route('keywords')->with('successMsg', 'Keyword updated');
    }

    public function update(KeywordRequest $request, $keywordId)
    {
        $updatedKeyword = $request->only('name');
        try {
            Keyword::where('id', $keywordId)->update($updatedKeyword);
        } catch (\PDOException $e) {
            Log::error($this->getLogMsg($e));
            return redirect()->back()->with('errorMsg', $this->getMessage($e));
        }
        return redirect()->route('keywords')->with('successMsg', 'Keyword updated');
    }

    public function destroy($keywordId)
    {
        try {
            Keyword::find($keywordId)->articles()->detach();
            Keyword::destroy($keywordId);
        } catch (\PDOException $e) {
            Log::error($this->getLogMsg($e));
            return redirect()->back()->with('errorMsg', $this->getMessage($e));
        }
        return redirect()->route('keywords')->with('successMsg', 'Keyword deleted');
    }

    public function getArticles(Request $request, $keywordName)
    {
        $articles = Article::getPaginate($request);

        return view('frontend.articles', compact('articles'));
    }
}
