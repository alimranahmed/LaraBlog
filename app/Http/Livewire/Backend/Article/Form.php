<?php

namespace App\Http\Livewire\Backend\Article;

use App\Mail\NotifySubscriberForNewArticle;
use App\Models\Article;
use App\Models\Category;
use App\Models\Keyword;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Component;

class Form extends Component
{
    public Article $originalArticle;

    public $article;

    public string $method;

    public array $rules = [
        'article.heading' => 'required',
        'article.slug' => 'required',
        'article.category_id' => 'required',
        'article.content' => 'required',
        'article.language' => 'required',
        'article.is_comment_enabled' => 'boolean',
        'article.meta.description' => 'nullable|string',
        'article.meta.image_url' => 'nullable|url',
    ];

    public function mount(?Article $article = null): void
    {
        if ($article->id) {
            $this->originalArticle = $article;
            $this->article = $article->toArray();
            $this->article['keywords'] = $this->originalArticle->keywords->pluck('name')->implode(' ');
        }

        $this->method = $article->id ? 'put' : 'post';
    }

    public function render(): View
    {
        if (Arr::get($this->article, 'heading')) {
            $this->article['slug'] = Str::slug(Arr::get($this->article, 'heading'), '-', Arr::get($this->article, 'language'));
        }
        $categories = Category::query()->active()->get();

        return view('livewire.backend.article.form', compact('categories'));
    }

    public function submit(): void
    {
        $data = Arr::get($this->validate(), 'article');

        if ($this->method == 'post') {
            $this->store($data);
        } else {
            $this->update($data);
        }
    }

    protected function store(array $articleData): void
    {
        //Create new article
        $articleData['published_at'] = now();
        $articleData['user_id'] = Auth::id();
        /** @var Article $newArticle */
        $newArticle = Article::query()->create($articleData);

        //add keywords
        $keywordsToAttach = array_unique(explode(' ', Arr::get($this->article, 'keywords')));

        foreach ($keywordsToAttach as $keywordToAttach) {
            if (empty($keywordToAttach)) {
                continue;
            }
            /** @var Keyword $newKeyword */
            $newKeyword = Keyword::query()->firstOrCreate(['name' => $keywordToAttach]);
            $newArticle->keywords()->attach($newKeyword->id);
        }

        //Notify all subscriber about the new article
        foreach (User::getSubscribedUsers() as $subscriber) {
            Mail::to($subscriber->email)->queue(new NotifySubscriberForNewArticle($newArticle, $subscriber));
        }

        session()->flash('success', 'Article published successfully!');
        redirect()->to(route('backend.article.index'));
    }

    protected function update(array $updateData): void
    {
        $this->originalArticle->update($updateData);

        $this->originalArticle->keywords()->detach();

        $keywordsToAttach = array_unique(explode(' ', Arr::get($this->article, 'keywords')));

        foreach ($keywordsToAttach as $keywordToAttach) {
            /** @var Keyword $newKeyword */
            $newKeyword = Keyword::query()->firstOrCreate(['name' => $keywordToAttach]);
            $this->originalArticle->keywords()->attach($newKeyword->id);
        }

        session()->flash('successMsg', 'Article updated successfully!');
        redirect()->to(route('backend.article.index'));
    }
}
