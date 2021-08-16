<?php

namespace App\Http\Livewire\Backend\Category;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $listeners = ['categoryDeleted' => '$refresh'];

    public function render()
    {
        $categories = Category::with(['articles' => function ($articles) {
            return $articles->notDeleted();
        }])->orderBy('name')
            ->paginate();

        return view('livewire.backend.category.index', compact('categories'));
    }
}
