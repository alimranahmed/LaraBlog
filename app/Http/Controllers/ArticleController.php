<?php

namespace App\Http\Controllers;

use App\Events\ArticleHit;
use App\Models\Address;
use App\Models\Article;
use App\Models\Category;
use App\Models\HitLogger;
use App\Models\Keyword;
use App\Models\User;
use App\Mail\NotifySubscriberForNewArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $articles = Article::getPaginate($request);
        return view('frontend.articles', compact('articles'));
    }

    public function show($articleId, $articleHeading = '')
    {
        $clientIP = $_SERVER['REMOTE_ADDR'];

        $article = Article::where('id', $articleId)
            ->published()
            ->notDeleted()
            ->with([
                'category',
                'keywords',
                'comments' => function ($comments) {
                    return $comments->published();
                }
            ])->first();

        if (is_null($article)) {
            return redirect()->route('home')->with('warningMsg', 'Article not found');
        }

        event(new ArticleHit($article, $clientIP));

        $relatedArticles = $this->getRelatedArticles($article);

        return view('frontend.article', compact('article', 'relatedArticles'));
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

    public function edit($articleId)
    {
        $article = Article::find($articleId);
        if (is_null($article)) {
            return redirect()->route('home')->with('errorMsg', 'Article not found');
        }

        if ($this->hasArticleAuthorization(Auth::user(), $article)) {
            return redirect()->route('home')->with('errorMsg', 'Unauthorized request');
        }
        $categories = Category::where('is_active', 1)->get();
        return view('backend.article_edit', compact('categories', 'article'));
    }

    public function update(Request $request, $articleId)
    {
        $article = Article::find($articleId);
        if (is_null($article)) {
            return redirect()->route('home')->with('errorMsg', 'Article not found');
        }

        if ($this->hasArticleAuthorization(Auth::user(), $article)) {
            return redirect()->route('home')->with('errorMsg', 'Unauthorized request');
        }
        $updatedArticle = $request->only(['heading', 'content', 'category_id', 'language']);
        $updatedArticle['is_comment_enabled'] = $request->has('is_comment_enabled');
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
            return redirect()->back()->with('errorMsg', $this->getMessage($e));
        }

        return redirect()->route('admin-articles')->with('successMsg', 'Article updated');
    }

    public function create()
    {
        $categories = Category::where('is_active', 1)->get();
        return view('backend.article_create', compact('categories'));
    }

    public function store(Request $request)
    {
        $clientIP = $_SERVER['REMOTE_ADDR'];

        $newArticle = $request->only(['heading', 'content', 'category_id', 'language']);
        $newArticle['is_comment_enabled'] = $request->has('is_comment_enabled');
        $newAddress = ['ip' => $clientIP];

        try {
            //Create new address
            $newAddress = Address::create($newAddress);
            //Create new article
            $newArticle['address_id'] = $newAddress->id;
            $newArticle['published_at'] = new \DateTime();
            $newArticle['user_id'] = Auth::user()->id;
            $newArticle = Article::create($newArticle);
            //add keywords
            $keywordsToAttach = array_unique(explode(' ', $request->get('keywords')));
            foreach ($keywordsToAttach as $keywordToAttach) {
                $newKeyword = Keyword::firstOrCreate(['name' => $keywordToAttach]);
                $newArticle->keywords()->attach($newKeyword->id);
            }
            //Notify all subscriber about the new article
            foreach (User::getSubscribedUsers() as $subscriber) {
                Mail::to($subscriber->email)->queue(new NotifySubscriberForNewArticle($newArticle, $subscriber));
            }
        } catch (\PDOException $e) {
            return redirect()->back()->with('errorMsg', $this->getMessage($e));
        }

        return redirect()->route('admin-articles')->with('successMsg', 'Article published successfully!');
    }

    public function togglePublish($articleId)
    {
        $article = Article::find($articleId);
        if (is_null($article)) {
            return redirect()->route('home')->with('errorMsg', 'Article not found');
        }

        if ($this->hasArticleAuthorization(Auth::user(), $article)) {
            return redirect()->route('home')->with('errorMsg', 'Unauthorized request');
        }
        try {
            $article->update([
                'is_published' => !$article->is_published,
                'published_at' => new \DateTime(),
            ]);
        } catch (\PDOException $e) {
            return redirect()->back()->with('errorMsg', $this->getMessage($e));
        }
        return redirect()->route('admin-articles')->with('successMsg', 'Article updated');
    }

    public function search(Request $request)
    {
        $this->validate($request, ['query_string' => 'required']);

        $queryString = $request->get('query_string');
        $keywords = Keyword::where('name', 'LIKE', "%$queryString%")->where('is_active', 1)->get();
        $articleIDsByKeywords = Keyword::getArticleIDs($keywords);

        $articles = Article::published()
            ->notDeleted()
            ->whereIn('id', $articleIDsByKeywords)
            ->where('heading', 'LIKE', "%$queryString%")
            ->orWhere('content', 'LIKE', "%$queryString%")
            ->latest()
            ->paginate(config('view.item_per_page'));

        $articles->setPath(url("search/?query_string=$queryString"));

        $searched = new \stdClass();
        $searched->articles = $articles;
        $searched->query = $queryString;
        return view('frontend.search_result', compact('searched'));
    }

    public function adminArticle()
    {
        $articles = Article::notDeleted()
            ->with('category', 'keywords', 'user')
            ->latest()
            ->get();
        if (Auth::user()->hasRole(['author'])) {
            $articles = $articles->where('user_id', Auth::user()->id);
        }
        return view('backend.articleList', compact('articles'));
    }

    public function destroy($articleId)
    {
        $article = Article::find($articleId);
        if (is_null($article)) {
            return redirect()->route('home')->with('errorMsg', 'Article not found');
        }

        if ($this->hasArticleAuthorization(Auth::user(), $article)) {
            return redirect()->route('home')->with('errorMsg', 'Unauthorized request');
        }
        try {
            Article::where('id', $articleId)->update(['is_deleted' => 1]);
        } catch (\PDOException $e) {
            return redirect()->back()->with('errorMsg', $this->getMessage($e));
        }
        return redirect()->route('admin-articles')->with('successMsg', 'Article deleted');
    }

    private function hasArticleAuthorization($user, $article)
    {
        return $user->hasRole(['author']) && $article->user_id != $user->id;
    }
}
