<?php

namespace App\Http\Livewire\Backend\Article;

use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public $category = '';

    protected $queryString = [
        'category' => ['except' => '']
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

        return $articles->paginate(config('blog.item_per_page'));
    }
}
