<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with([
            'articles' => function ($articles) {
                return $articles->notDeleted();
            }
        ])->get();
        return view('backend.categoryList', compact('categories'));
    }

    public function update(CategoryRequest $request, $categoryId)
    {
        $updatedCategory = $request->only(['name', 'alias', 'position', 'parent_category_id']);
        try {
            Category::where('id', $categoryId)->update($updatedCategory);
        } catch (\PDOException $e) {
            Log::error($this->getLogMsg($e));
            return redirect()->back()->with('errorMsg', $this->getMessage($e));
        }
        return redirect()->back()->with('successMsg', 'Category updated successfully!');
    }

    public function store(CategoryRequest $request)
    {
        $newCategory = $request->only(['name', 'alias', 'position', 'parent_category_id']);
        try {
            Category::create($newCategory);
        } catch (\PDOException $e) {
            Log::error($this->getLogMsg($e));
            return redirect()->back()->with('errorMsg', $this->getMessage($e));
        }
        return redirect()->back()->with('successMsg', 'Category created successfully!');
    }

    public function toggleActive($categoryId)
    {
        $category = Category::find($categoryId);
        try {
            $category->update(['is_active' => !$category->is_active]);
        } catch (\PDOException $e) {
            Log::error($this->getLogMsg($e));
            return redirect()->back()->with('errorMsg', $this->getMessage($e));
        }
        return redirect()->route('categories')->with('successMsg', 'Category updated');
    }

    public function getArticles(Request $request, $categoryAlias)
    {
        $articles = Article::getPaginate($request);

        return view('frontend.articles', compact('articles'));
    }

    public function destroy($categoryId)
    {
        try {
            Category::destroy($categoryId);
        } catch (\PDOException $e) {
            Log::error($this->getLogMsg($e));
            return redirect()->back()->with('errorMsg', $this->getMessage($e));
        }
        return redirect()->back()->with('successMsg', 'Category deleted');
    }
}
