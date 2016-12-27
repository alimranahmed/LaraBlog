<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function index(Request $request){
        $articles =  Article::where('is_published', 1)->where('is_deleted', 0)
            ->orderBy('published_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('frontend.articles', compact('articles'));
    }

    public function show(Request $request, $articleId){
        $article = Article::where('id', $articleId)
            ->where('is_published', 1)
            ->where('is_deleted', 0)
            ->with(['category', 'comments' => function($comments){
                $comments->where('is_published', 1)->orderBy('created_at', 'desc');
            }])->first();
        //TODO keep log of which ip has hit the article
        try{
            $article->increment('hit_count');
        }catch(\PDOException $e){
            //TODO add log
        }
        return view('frontend.article', compact('article'));
    }

    public function edit(Request $request, $articleId){
        $article = Article::find($articleId);
        $categories = Category::where('is_active', 1)->get();
        return view('backend.article_edit', compact('categories', 'article'));
    }

    public function update(Request $request, $articleId){
        $updatedArticle = $request->only(['heading', 'content', 'category_id', 'language']);
        try{
            Article::where('id', $articleId)->update($updatedArticle);
        }catch(\PDOException $e){
            return redirect()->back()->with('errorMsg', $this->getMessage($e));
        }

        return redirect()->route('admin-articles')->with('successMsg', 'Article updated');
    }

    public function create(Request $request){
        $categories = Category::where('is_active', 1)->get();
        return view('backend.article_create', compact('categories'));
    }

    public function store(Request $request){
        $clientIP = $_SERVER['REMOTE_ADDR'];

        $newArticle = $request->only(['heading', 'content', 'category_id', 'language']);
        $newAddress = ['ip' => $clientIP];

        try{
            //Create new address
            $newAddress = Address::create($newAddress);
            //Create new article
            $newArticle['address_id'] = $newAddress->id;
            $newArticle['published_at'] = new \DateTime();
            $newArticle['user_id'] = Auth::user()->id;
            Article::create($newArticle);
        }catch(\PDOException $e){
            return redirect()->back()->with('errorMsg', $this->getMessage($e));
        }

        return redirect()->route('admin-articles');
    }

    public function togglePublish(Request $request, $articleId){
        $article = Article::find($articleId);
        try{
            $article->update([
                'is_published' => !$article->is_published,
                'published_at' => new \DateTime(),
            ]);
        }catch(\PDOException $e){
            return redirect()->back()->with('errorMsg', $this->getMessage($e));
        }
        return redirect()->route('admin-articles')->with('successMsg', 'Article updated');
    }

    public function search(Request $request){
        $this->validate($request, ['query_string' => 'required']);

        $queryString = $request->get('query_string');
        $articles = Article::where('heading', 'LIKE', "%$queryString%")
            ->orWhere('content', 'LIKE', "%$queryString%")
            ->get();
        $searched = new \stdClass();
        $searched->query = $queryString;
        $searched->articles = $articles->where('is_published', 1)->where('is_deleted', 0);
        return view('frontend.search_result', compact('searched'));
    }

    public function adminArticle(Request $request){
        $articles =  Article::where('is_deleted', 0)
            ->with('category', 'keywords', 'user')
            ->orderBy('id', 'desc')
            ->get();
        //return $articles;
        return view('backend.articleList', compact('articles'));
    }

    public function destroy(Request $request, $articleId){
        try{
            Article::where('id', $articleId)->update(['is_deleted' => 1]);
        }catch (\PDOException $e){
            return redirect()->back()->with('errorMsg', $this->getMessage($e));
        }
        return redirect()->route('admin-articles')->with('successMsg', 'Article deleted');
    }
}
