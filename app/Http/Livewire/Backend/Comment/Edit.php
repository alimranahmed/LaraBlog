<?php

namespace App\Http\Livewire\Backend\Comment;

use App\Models\Comment;
use Illuminate\Support\Arr;
use Livewire\Component;

class Edit extends Component
{
    public $rules = [
        'comment.content' => 'string|required',
        'comment.is_published' => 'boolean'
    ];

    public $comment;

    public function mount(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function render()
    {
        return view('livewire.backend.comment.edit');
    }

    public function update(Comment $comment)
    {
        $data = $this->validate();

        $comment->update([
            'is_published' => $isPublished = Arr::get($data, 'comment.is_published', false),
            'published_at' => $isPublished ? now() : null,
            'content' => Arr::get($data, 'comment.content', $comment->content),
            'original_content' => $comment->count_edit ? $comment->original_content : $comment->content,
            'count_edit' => $comment->count_edit + 1,
        ]);

        return redirect()->to(route('backend.comment.show', $comment->parent_comment_id ?? $comment->id));
    }
}
