<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request){
        $articles =  Article::where('is_published', 1)->where('is_deleted', 0)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('frontend.articles', compact('articles'));
    }

    public function show(Request $request, $articleId){
        $article = Article::where('id', $articleId)
            ->where('is_published', 1)
            ->where('is_deleted', 0)
            ->with(['comments' => function($comments){
                $comments->where('is_published', 1);
            }])->first();
        //TODO keep log of which ip has hit the article
        try{
            $article->increment('hit_count');
        }catch(\PDOException $e){
            //TODO add log
        }
        return view('frontend.article', compact('article'));
    }

    public function update(Request $request, $articleId){
        $updatedArticle = $request->only(['heading', 'content']);
        try{
            Article::where('id', $articleId)->update($updatedArticle);
        }catch(\PDOException $e){
            return response()->json(['message' => $e->getMessage()]);
        }
        return response()->json(['message' => 'Updated successfully!']);
    }

    public function store(Request $request){
        $clientIP = $_SERVER['REMOTE_ADDR'];

        $newArticle = $request->only(['heading', 'content']);
        $newAddress = ['ip' => $clientIP];

        try{
            //Create new address
            $newAddress = Address::create($newAddress);
            //Create new article
            $newArticle['address_id'] = $newAddress->id;
            $newArticle['published_at'] = new \DateTime();
            $newArticle['user_id'] = Auth::user()->id;
            $newArticle = Article::create($newArticle);
        }catch(\PDOException $e){
            return response()->json(['message' => $e->getMessage()]);
        }

        return response()->json(['message' => 'Article created successfully!', 'entity' => $newArticle]);
    }

    public function togglePublish(Request $request, $articleId){
        $article = Article::find($articleId);
        try{
            $article->update([
                'is_published' => !$article->is_published,
                'published_at' => new \DateTime(),
            ]);
        }catch(\PDOException $e){
            return response()->json(['message' => $e->getMessage()]);
        }
        return redirect()->route('admin-articles');
    }

    public function search(Request $request){
        $this->validate($request, ['query_string' => 'required']);

        $queryString = $request->get('query_string');
        $articles = Article::where('heading', 'LIKE', "%$queryString%")
            ->orWhere('content', 'LIKE', "%$queryString%")
            ->where('is_published', 1)
            ->where('is_deleted', 0)
            ->get();
        $searched = new \stdClass();
        $searched->query = $queryString;
        $searched->articles = $articles;
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
            return response()->json(['message' => $e->getMessage()]);
        }
        return redirect()->route('admin-articles');
    }
}
