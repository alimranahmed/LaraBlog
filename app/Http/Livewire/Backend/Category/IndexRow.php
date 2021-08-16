<?php

namespace App\Http\Livewire\Backend\Category;

use App\Models\Category;
use Livewire\Component;

class IndexRow extends Component
{
    public $category;

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
}
