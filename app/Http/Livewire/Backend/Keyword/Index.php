<?php

namespace App\Http\Livewire\Backend\Keyword;

use App\Models\Keyword;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        $keywords = Keyword::with('articles')->paginate(25);

        return view('livewire.backend.keyword.index', compact('keywords'));
    }

    public function delete(Keyword $keyword)
    {
        $keyword->articles()->detach();
        $keyword->delete();
    }
}
