<?php

namespace App\Livewire\Backend\Article;

use App\Models\Article;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
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
    public string $category = '';

    #[Url]
    public string $query = '';

    #[Url]
    public string $keyword = '';

    protected $listeners = ['articleDeleted' => '$refresh'];

    private function getArticles()
    {
        $articles = Article::notDeleted()
            ->with('category', 'keywords', 'user')
            ->latest();

        if (Auth::user()->hasRole(['author'])) {
            $articles = $articles->where('user_id', Auth::user()->id);
        }

        if ($this->category) {
            $articles = $articles->where('category_id', $this->category);
        }

        if ($this->keyword) {
            $articles = $articles->whereHas('keywords', function (Builder $builder) {
                return $builder->where('name', $this->keyword);
            });
        }

        if ($this->query) {
            $articles = $articles->search($this->query);
        }

        return $articles->paginate(config('blog.item_per_page'));
    }

    public function placeholder(): View
    {
        return view('livewire.placeholders.list');
    }

    public function render(): View
    {
        $articles = $this->getArticles();

        return view('livewire.backend.article.index', compact('articles'));
    }
}
