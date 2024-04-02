<?php

namespace App\Livewire\Backend\Keyword;

use App\Models\Keyword;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render(): View
    {
        $keywords = Keyword::with('articles')->paginate(25);

        return view('livewire.backend.keyword.index', compact('keywords'));
    }

    public function delete(Keyword $keyword): void
    {
        $keyword->articles()->detach();
        $keyword->delete();
    }
}
