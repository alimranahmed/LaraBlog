<?php

namespace App\Http\Livewire\Backend\Comment;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class IndexRow extends Component
{
    public $comment;

    public function mount(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function render()
    {
        return view('livewire.backend.comment.index-row');
    }

    public function togglePublish()
    {
        $this->comment->update([
            'is_published' => !$this->comment->is_published,
            'published_at' => now(),
        ]);

        $this->comment->refresh();
    }

    public function destroy(Comment $comment)
    {
        Article::where('id', $comment->article_id)->decrement('comment_count');
        $comment->delete();
        $this->emitUp('commentDeleted');
    }
}
