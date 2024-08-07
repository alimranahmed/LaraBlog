<?php

namespace App\Livewire\Backend\Comment;

use App\Models\Comment;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Livewire\Component;

class Show extends Component
{
    public ?Comment $comment = null;

    public array $reply = [];

    public array $rules = [
        'reply.content' => ['required'],
    ];

    public function mount(Comment $comment): void
    {
        $this->comment = $comment;
    }

    public function render(): View
    {
        return view('livewire.backend.comment.show');
    }

    public function submitReply(): void
    {
        $data = $this->validate();
        Comment::query()->create([
            'content' => Arr::get($data, 'reply.content'),
            'article_id' => $this->comment->article_id,
            'user_id' => auth()->id(),
            'parent_comment_id' => $this->comment->id,
            'is_published' => true,
            'published_at' => now(),
            'is_confirmed' => 1,
        ]);

        $this->reset('reply');

        $this->comment->refresh();
    }

    public function delete(Comment $comment): void
    {
        $comment->delete();
    }
}
