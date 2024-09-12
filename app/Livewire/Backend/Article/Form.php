<?php

namespace App\Livewire\Backend\Article;

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

    public array $articleData = [];

    public string $method;

    public array $rules = [
        'articleData.heading' => 'required',
        'articleData.slug' => 'required',
        'articleData.category_id' => 'required',
        'articleData.content' => 'required',
        'articleData.language' => 'required',
        'articleData.is_comment_enabled' => 'boolean',
        'articleData.meta.description' => 'nullable|string',
        'articleData.meta.image_url' => 'nullable|url',
    ];

    public function mount($article = null): void
    {
        if ($article?->id) {
            /** @var User $user */
            $user = Auth::user();
            if (! $article->hasAuthorization($user)) {
                $this->redirectRoute('home');
                return;
            }

            $this->originalArticle = $article;
            $this->articleData = $article->toArray();
            $this->articleData['keywords'] = $article->keywords->pluck('name')->implode(' ');
            $this->articleData['meta'] = $article->meta ?: [];
        }

        $this->method = $article?->id ? 'put' : 'post';
    }

    public function render(): View
    {
        if (Arr::get($this->articleData, 'heading')) {
            $this->articleData['slug'] = Str::slug(Arr::get($this->articleData, 'heading'), '-', Arr::get($this->articleData, 'language'));
        }
        $categories = Category::query()->active()->get();

        return view('livewire.backend.article.form', compact('categories'));
    }

    public function submit(): void
    {
        $data = Arr::get($this->validate(), 'articleData');

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
        $keywordsToAttach = $this->getKeywords();

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

    public function getKeywords(): array {
        return array_filter(array_unique(explode(' ', Arr::get($this->articleData, 'keywords'))));
    }

    protected function update(array $updateData): void
    {
        $this->originalArticle->update($updateData);

        $this->originalArticle->keywords()->detach();

        $keywordsToAttach = array_unique(explode(' ', Arr::get($this->articleData, 'keywords')));

        foreach ($keywordsToAttach as $keywordToAttach) {
            /** @var Keyword $newKeyword */
            $newKeyword = Keyword::query()->firstOrCreate(['name' => $keywordToAttach]);
            $this->originalArticle->keywords()->attach($newKeyword->id);
        }

        session()->flash('successMsg', 'Article updated successfully!');
        redirect()->to(route('backend.article.index'));
    }
}
