<?php

namespace App\Http\Livewire\Backend\Category;

use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Livewire\Component;

class Index extends Component
{
    public $adding = false;

    public $category;

    protected $listeners = ['categoryDeleted' => '$refresh'];

    public function render()
    {
        $categories = $this->getCategories();

        return view('livewire.backend.category.index', compact('categories'));
    }

    public function startAdding()
    {
        $this->adding = true;
    }

    public function store()
    {
        $data = $this->validate(['category.name' => 'required', 'category.alias' => 'required']);

        Category::create(Arr::get($data, 'category'));

        $this->adding = false;
    }

    protected function getCategories(): LengthAwarePaginator
    {
        return Category::with(['articles' => function ($articles) {
            return $articles->notDeleted();
        }])->orderBy('name')
            ->paginate();
    }
}
