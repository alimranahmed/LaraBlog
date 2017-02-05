<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Article;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::with(['articles' => function($articles){
            $articles->where('is_deleted', 0);
        }])->get();
        return view('backend.categoryList', compact('categories'));
    }

    public function update(CategoryRequest $request, $categoryId){
        $updatedCategory = $request->only(['name', 'alias', 'position', 'parent_category_id']);
        try{
            Category::where('id', $categoryId)->update($updatedCategory);
        }catch (\PDOException $e){
            return redirect()->back()->with('errorMsg', $this->getMessage($e));
        }
        return redirect()->back()->with('successMsg', 'Category updated successfully!');
    }

    public function store(CategoryRequest $request){
        $newCategory = $request->only(['name', 'alias', 'position', 'parent_category_id']);
        try{
            Category::create($newCategory);
        }catch (\PDOException $e){
            return redirect()->back()->with('errorMsg', $this->getMessage($e));
        }
        return redirect()->back()->with('successMsg', 'Category created successfully!');
    }

    public function toggleActive($categoryId){
        $category = Category::find($categoryId);
        try{
            $category->update(['is_active' => !$category->is_active]);
        }catch(\PDOException $e){
            return redirect()->back()->with('errorMsg', $this->getMessage($e));
        }
        return redirect()->route('categories')->with('successMsg', 'Category updated');
    }

    public function getArticles($categoryAlias){
        $category = Category::where('alias', $categoryAlias)->first();
        if(is_null($category)){
            return redirect()->route('home')->with('warningMsg', 'Category not found');
        }
        $articles = Article::where('category_id', $category->id)
            ->where('is_deleted', 0)
            ->where('is_published', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('frontend.articles', compact('articles'));
    }

    public function destroy($categoryId){
        try{
            Category::destroy($categoryId);
        }catch (\PDOException $e){
            return redirect()->back()->with('errorMsg', $this->getMessage($e));
        }
        return redirect()->back()->with('successMsg', 'Category deleted');
    }
}
