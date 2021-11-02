<?php

namespace App\Http\Livewire\Backend\Article;

use App\Mail\NotifySubscriberForNewArticle;
use App\Models\Article;
use App\Models\Category;
use App\Models\Keyword;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Form extends Component
{
    public $originalArticle;

    public $article;

    public $method;

    public $rules = [
        'article.heading' => 'required',
        'article.category_id' => 'required',
        'article.content' => 'required',
        'article.language' => 'required',
        'article.is_comment_enabled' => 'boolean'
    ];

    public function mount(?Article $article = null)
    {
        if ($article->id) {
            $this->originalArticle = $article;
            $this->article = $article->toArray();
            $this->article['keywords'] = $this->originalArticle->keywords->pluck('name')->implode(' ');
        }

        $this->method = $article->id ? 'put' : 'post';
    }

    public function render()
    {
        $categories = Category::active()->get();

        return view('livewire.backend.article.form', compact('categories'));
    }

    public function submit()
    {
        $data = Arr::get($this->validate(), 'article');

        if ($this->method == 'post') {
            $this->store($data);
        } else {
            $this->update($data);
        }
    }

    protected function store(array $newArticle)
    {
        //Create new article
        $newArticle['published_at'] = now();
        $newArticle['user_id'] = Auth::id();
        $newArticle = Article::create($newArticle);

        //add keywords
        $keywordsToAttach = array_unique(explode(' ', Arr::get($this->article, 'keywords')));

        foreach ($keywordsToAttach as $keywordToAttach) {
            $newKeyword = Keyword::firstOrCreate(['name' => $keywordToAttach]);
            $newArticle->keywords()->attach($newKeyword->id);
        }

        //Notify all subscriber about the new article
        foreach (User::getSubscribedUsers() as $subscriber) {
            Mail::to($subscriber->email)->queue(new NotifySubscriberForNewArticle($newArticle, $subscriber));
        }

        session()->flash('success', 'Article published successfully!');
        redirect()->to(route('backend.article.index'));
    }

    protected function update(array $updateData)
    {
        $this->originalArticle->update($updateData);

        $this->originalArticle->keywords()->detach();

        $keywordsToAttach = array_unique(explode(' ', Arr::get($this->article, 'keywords')));

        foreach ($keywordsToAttach as $keywordToAttach) {
            $newKeyword = Keyword::firstOrCreate(['name' => $keywordToAttach]);
            $this->originalArticle->keywords()->attach($newKeyword->id);
        }

        session()->flash('successMsg', 'Article updated successfully!');
        redirect()->to(route('backend.article.index'));
    }
}
