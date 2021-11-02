<?php

namespace App\Http\Livewire\Backend\Article;

use App\Models\Article;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public $category = '';
    public $query = '';
    public $keyword = '';

    protected $queryString = [
        'category' => ['except' => ''],
        'keyword' => ['except' => ''],
        'query' => ['except' => ''],
    ];

    protected $listeners = ['articleDeleted' => '$refresh'];

    public function render()
    {
        $articles = $this->getArticles();
        return view('livewire.backend.article.index', compact('articles'));
    }

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
}
