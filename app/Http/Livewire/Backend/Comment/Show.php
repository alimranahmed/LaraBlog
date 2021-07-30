<?php

namespace App\Http\Livewire\Backend\Comment;

use App\Models\Comment;
use Illuminate\Support\Arr;
use Livewire\Component;

class Show extends Component
{
    public $comment;

    public $reply;

    public $rules = [
        'reply.content' => ['required'],
    ];

    public function mount(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function render()
    {
        return view('livewire.backend.comment.show');
    }

    public function submitReply()
    {
        $data = $this->validate();
        Comment::create([
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

    public function delete(Comment $comment)
    {
        $comment->delete();
        $this->comment->refresh();
    }
}
