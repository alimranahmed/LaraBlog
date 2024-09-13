<?php

namespace App\Livewire\Backend\Comment;

use App\Models\Comment;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Livewire\Component;

class Edit extends Component
{
    public array $rules = [
        'content' => 'string|required',
        'is_published' => 'boolean',
    ];

    public Comment $comment;

    public ?string $content;

    public ?bool $is_published = false;

    public function mount(Comment $comment): void
    {
        $this->comment = $comment;
        $this->content = $comment->content;
        $this->is_published = (bool) $this->is_published;
    }

    public function update(): RedirectResponse|Redirector
    {
        $this->validate();

        $this->comment->update([
            'is_published' => $isPublished = $this->is_published,
            'published_at' => $isPublished ? now() : null,
            'content' => $this->content,
            'original_content' => $this->comment->count_edit ? $this->comment->original_content : $this->comment->content,
            'count_edit' => $this->comment->count_edit + 1,
        ]);

        return redirect()->to(route('backend.comment.show', $comment->parent_comment_id ?? $this->comment->id));
    }

    public function render(): View
    {
        return view('livewire.backend.comment.edit');
    }
}
