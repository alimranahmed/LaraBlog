<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request){
        $articles =  Article::all();
        return view('frontend.articles', compact('articles'));
    }

    public function show(Request $request, $articleId){
        $article = Article::where('id', $articleId)->with('comments')->first();
        //TODO keep log of which ip has hit the article
        try{
            $article->update(['hit_count' => ++$article->hit_count]);
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
            $newArticle['user_id'] = 1; //TODO remove the hard coded user id
            $newArticle = Article::create($newArticle);
        }catch(\PDOException $e){
            return response()->json(['message' => $e->getMessage()]);
        }

        return response()->json(['message' => 'Article created successfully!', 'entity' => $newArticle]);
    }

    public function togglePublish(Request $request, $articleId){
        $article = Article::find($articleId);
        try{
            $article->update(['is_published' => !$article->is_published]);
        }catch(\PDOException $e){
            return response()->json(['message' => $e->getMessage()]);
        }
        return response()->json(['message' => 'Publication status changed successfully!']);
    }

    public function search(Request $request, $queryString){
        $articles = Article::where('heading', 'LIKE', "%$queryString%")
            ->orWhere('content', 'LIKE', "%$queryString%")
            ->get();
        return $articles;
    }
}
