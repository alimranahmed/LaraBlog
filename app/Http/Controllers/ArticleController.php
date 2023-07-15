<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ArticleController extends Controller
{
    public function index(Request $request): View
    {
        $articles = Article::getPaginated($request);

        return view('frontend.articles.index', compact('articles'));
    }

    public function show(string $slug): mixed
    {
        $article = Article::query()
            ->with(['user', 'category', 'keywords'])
            ->where('slug', $slug)
            ->published()
            ->notDeleted()
            ->first();

        if (is_null($article)) {
            return redirect()->route('home')->with('warning', 'Article not found');
        }

        $relatedArticles = $this->getRelatedArticles($article);

        return view('frontend.articles.show', compact('article', 'relatedArticles'));
    }

    public function showById($articleId, $articleHeading = ''): View|RedirectResponse
    {
        $article = Article::query()
            ->where('id', $articleId)
            ->published()
            ->notDeleted()
            ->with(['user', 'category', 'keywords'])
            ->first();

        if (is_null($article)) {
            return redirect()->route('home')->with('warning', 'Article not found');
        }

        $relatedArticles = $this->getRelatedArticles($article);

        return view('frontend.articles.show', compact('article', 'relatedArticles'));
    }

    private function getRelatedArticles(Article $article): Collection
    {
        return Article::query()
            ->with(['user', 'category', 'keywords'])
            ->where('category_id', $article->category->id)
            ->where('id', '!=', $article->id)
            ->published()
            ->latest()
            ->take(3)
            ->get();
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function search(Request $request): View
    {
        $this->validate($request, ['query_string' => 'required']);

        $queryString = $request->get('query_string');

        $articles = Article::query()
            ->published()
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

        return view('frontend.articles.search_result', compact('searched'));
    }
}
