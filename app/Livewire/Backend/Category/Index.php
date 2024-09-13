<?php

namespace App\Livewire\Backend\Category;

use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;
use Livewire\Component;

class Index extends Component
{
    public bool $adding = false;

    public array $category = [];

    protected $listeners = ['categoryDeleted' => '$refresh'];

    public function startAdding(): void
    {
        $this->adding = true;
    }

    public function store(): void
    {
        $data = $this->validate(['category.name' => 'required', 'category.alias' => 'required']);

        Category::query()->create(Arr::get($data, 'category'));

        $this->adding = false;
    }

    protected function getCategories(): LengthAwarePaginator
    {
        return Category::query()
            ->with(['articles' => fn (HasMany $articles) => $articles->notDeleted()])
            ->orderBy('name')
            ->paginate();
    }

    public function placeholder(): View
    {
        return view('livewire.placeholders.list');
    }

    public function render(): View
    {
        $categories = $this->getCategories();

        return view('livewire.backend.category.index', compact('categories'));
    }
}
