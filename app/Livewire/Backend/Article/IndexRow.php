<?php

namespace App\Livewire\Backend\Article;

use App\Models\Article;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class IndexRow extends Component
{
    public ?Article $article = null;

    public function mount(Article $article): void
    {
        $this->article = $article;
    }

    public function render(): View
    {
        return view('livewire.backend.article.index-row');
    }

    public function togglePublish(): void
    {
        $this->article->update([
            'is_published' => ! $this->article->is_published,
            'published_at' => now(),
        ]);

        $this->article->refresh();
    }

    public function destroy(): void
    {
        $this->article->update(['is_deleted' => 1]);

        $this->dispatch('articleDeleted')->to(Index::class);
    }
}
