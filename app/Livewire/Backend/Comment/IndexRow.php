<?php

namespace App\Livewire\Backend\Comment;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class IndexRow extends Component
{
    public ?Comment $comment;

    public function mount(Comment $comment): void
    {
        $this->comment = $comment;
    }

    public function render(): View
    {
        return view('livewire.backend.comment.index-row');
    }

    public function togglePublish(): void
    {
        $this->comment->update([
            'is_published' => ! $this->comment->is_published,
            'published_at' => now(),
        ]);

        $this->comment->refresh();
    }

    public function destroy(Comment $comment): void
    {
        Article::query()
            ->where('id', $comment->article_id)
            ->decrement('comment_count');

        $comment->delete();

        $this->dispatch('commentDeleted')->to(Index::class);
    }
}
