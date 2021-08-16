<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Keyword;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ArticleController extends Controller
{
    public function index()
    {
        return view('backend.articles.index');
    }

    public function create(Article $article)
    {
        return view('backend.articles.create', compact('article'));
    }

    public function edit(Article $article)
    {
        if ($article->hasAuthorization(Auth::user())) {
            return redirect()->route('home')->with('errorMsg', 'Unauthorized request');
        }

        $keywords = implode(' ', $article->keywords->pluck('name')->toArray());
        $article = json_decode(json_encode($article));
        $article->keywords = $keywords;

        $categories = Category::active()->get();
        return view('backend.article_edit', compact('categories', 'article'));
    }

    public function update(Request $request, $articleId)
    {
        $article = Article::find($articleId);
        if (is_null($article)) {
            return response()->json(['errorMsg' => 'Article not found'], Response::HTTP_NOT_FOUND);
        }

        if ($article->hasAuthorization(Auth::user())) {
            return response()->json(['errorMsg' => 'Unauthorized request'], Response::HTTP_UNAUTHORIZED);
        }
        $updatedArticle = $request->only(['heading', 'content', 'category_id', 'language']);
        $updatedArticle['is_comment_enabled'] = $request->input('is_comment_enabled');
        $keywordsToAttach = array_unique(explode(' ', $request->get('keywords')));
        try {
            $article->update($updatedArticle);
            //remove all keywords then add all keywords from input
            $article->keywords()->detach();
            foreach ($keywordsToAttach as $keywordToAttach) {
                $newKeyword = Keyword::firstOrCreate(['name' => $keywordToAttach]);
                $article->keywords()->attach($newKeyword->id);
            }
        } catch (\PDOException $e) {
            Log::error($this->getLogMsg($e));
            return response()->json(['errorMsg' => $this->getMessage($e)], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        session()->flash('successMsg', 'Article updated successfully!');
        return response()->json(['redirect_url' => redirect()->route('admin-articles')->getTargetUrl()]);
    }
}
