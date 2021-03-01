<?php


namespace App\Http\View\Composer;

use App\Models\Category;
use Illuminate\View\View;

class CategoriesComposer
{
    protected $categories;

    public function __construct()
    {
        $this->categories = Category::getNonEmptyOnly();
    }

    public function compose(View $view)
    {
        $view->with('navCategories', $this->categories);
    }
}
