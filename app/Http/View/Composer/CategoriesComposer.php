<?php

namespace App\Http\View\Composer;

use App\Models\Category;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class CategoriesComposer
{
    protected Collection $categories;

    public function __construct()
    {
        $this->categories = Category::getNonEmptyOnly();
    }

    public function compose(View $view): void
    {
        $view->with('navCategories', $this->categories);
    }
}
