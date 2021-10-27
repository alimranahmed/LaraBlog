<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $articles = Article::getPaginated($request);
        return view("frontend.articles.index", compact('articles'));
    }

    public function show($articleId, $articleHeading = '')
    {
        $article = Article::where('id', $articleId)
            ->published()
            ->notDeleted()
            ->with(['user', 'category', 'keywords',])
            ->first();

        if (is_null($article)) {
            return redirect()->route('home')->with('warning', 'Article not found');
        }

        $article->isEditable = $this->isEditable($article);

        $relatedArticles = $this->getRelatedArticles($article);

        return view("frontend.articles.show", compact('article', 'relatedArticles'));
    }

    private function isEditable(Article $article)
    {
        if (!auth()->check()) {
            return false;
        }
        $isAdmin = auth()->user()->hasRole(['owner', 'admin']);
        $isAuthor = $article->user->id == auth()->user()->id;
        return auth()->check() && ($isAdmin || $isAuthor);
    }

    private function getRelatedArticles(Article $article)
    {
        return Article::where('category_id', $article->category->id)
            ->where('id', '!=', $article->id)
            ->published()
            ->latest()
            ->take(3)
            ->get();
    }

    public function search(Request $request)
    {
        $this->validate($request, ['query_string' => 'required']);

        $queryString = $request->get('query_string');

        $articles = Article::published()
            ->notDeleted()
            ->where('heading', 'LIKE', "%$queryString%")
            ->orWhere('content', 'LIKE', "%$queryString%")
            ->orWhereHas('keywords', function (Builder $keywords) use ($queryString) {
                return $keywords->where('name', 'LIKE', "%$queryString%")
                    ->where('is_active', 1);
            })
            ->with('category', 'keywords', 'user')
            ->latest()
            ->paginate(config('blog.item_per_page'));

        $articles->setPath(url("search/?query_string=$queryString"));

        $searched = new \stdClass();
        $searched->articles = $articles;
        $searched->query = $queryString;

        return view("frontend.articles.search_result", compact('searched'));
    }
}
