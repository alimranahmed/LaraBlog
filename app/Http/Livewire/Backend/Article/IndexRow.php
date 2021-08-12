<?php

namespace App\Http\Livewire\Backend\Article;

use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class IndexRow extends Component
{
    public $article;

    public function mount(Article $article)
    {
        $this->article = $article;
    }

    public function render()
    {
        return view('livewire.backend.article.index-row');
    }

    public function togglePublish()
    {
        $this->article->update([
            'is_published' => !$this->article->is_published,
            'published_at' => now(),
        ]);

        $this->article->refresh();
    }

    public function destroy()
    {
        $this->article->update(['is_deleted' => 1]);

        $this->emitUp('articleDeleted');
    }
}
