<?php

namespace App\Http\Livewire\Backend\Comment;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $listeners = ['commentDeleted' => '$refresh'];

    public function render()
    {
        $comments = $this->getComments();
        return view('livewire.backend.comment.index', compact('comments'));
    }

    private function getComments(): LengthAwarePaginator
    {
        if (auth()->user()->hasRole('author')) {
            $authorsArticleIDs = Article::where('user_id', Auth::user()->id)->pluck('id');
            return Comment::whereIn('article_id', $authorsArticleIDs)
                ->with('article', 'user', 'replies')
                ->latest()
                ->noReplies()
                ->paginate(config('blog.item_per_page'));
        }
        return Comment::with('article', 'user', 'replies')
            ->latest()
            ->noReplies()
            ->paginate(config('blog.item_per_page'));
    }
}
