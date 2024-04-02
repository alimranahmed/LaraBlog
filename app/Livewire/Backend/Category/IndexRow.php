<?php

namespace App\Livewire\Backend\Category;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Livewire\Component;

class IndexRow extends Component
{
    public ?Category $category;

    public array $categoryData;

    public bool $editing = false;

    public function mount(Category $category): void
    {
        $this->category = $category;
    }

    public function render(): View
    {
        return view('livewire.backend.category.index-row');
    }

    public function toggleActive(): void
    {
        $this->category->update(['is_active' => ! $this->category->is_active]);
        $this->category->refresh();
    }

    public function destroy(Category $category): void
    {
        $category->delete();
        $this->dispatch('categoryDeleted')->to(Index::class);
    }

    public function startEditing(): void
    {
        $this->editing = true;
        $this->categoryData = $this->category->toArray();
    }

    public function update(): void
    {
        $data = $this->validate(['categoryData.name' => 'required', 'categoryData.alias' => 'required']);

        $data = Arr::get($data, 'categoryData');

        $this->category->update($data);

        $this->editing = false;

        $this->category->refresh();
    }
}
