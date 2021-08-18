<?php

namespace App\Http\Livewire\Backend\Category;

use App\Models\Category;
use Illuminate\Support\Arr;
use Livewire\Component;

class IndexRow extends Component
{
    public $category;

    public $categoryData;

    public $editing = false;

    public function mount(Category $category)
    {
        $this->category = $category;
    }

    public function render()
    {
        return view('livewire.backend.category.index-row');
    }

    public function toggleActive()
    {
        $this->category->update(['is_active' => !$this->category->is_active]);
        $this->category->refresh();
    }

    public function destroy(Category $category)
    {
        $category->delete();
        $this->emitUp('categoryDeleted');
    }

    public function startEditing()
    {
        $this->editing = true;
        $this->categoryData = $this->category->toArray();
    }

    public function update()
    {
        $data = $this->validate(['categoryData.name' => 'required', 'categoryData.alias' => 'required']);

        $data = Arr::get($data, 'categoryData');

        $this->category->update($data);

        $this->editing = false;

        $this->category->refresh();
    }
}
