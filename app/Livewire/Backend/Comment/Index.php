<?php

namespace App\Livewire\Backend\Comment;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Lazy]
class Index extends Component
{
    use WithPagination;

    #[Url]
    public string $article = '';

    protected $listeners = ['commentDeleted' => '$refresh'];

    private function getComments(): LengthAwarePaginator
    {
        $commentQuery = Comment::with('article', 'user', 'replies')
            ->latest()
            ->noReplies();

        if (auth()->user()->hasRole('author')) {
            $authorsArticleIDs = Article::query()->where('user_id', Auth::user()->id)->pluck('id');

            $commentQuery->whereIn('article_id', $authorsArticleIDs);
        }

        if ($this->article) {
            $commentQuery->where('article_id', $this->article);
        }

        return $commentQuery->paginate(config('blog.item_per_page'));
    }

    public function placeholder(): View
    {
        return view('livewire.placeholders.list');
    }

    public function render(): View
    {
        $comments = $this->getComments();

        return view('livewire.backend.comment.index', compact('comments'));
    }
}
