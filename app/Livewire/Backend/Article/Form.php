<?php

declare(strict_types=1);

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
use League\CommonMark\Exception\CommonMarkException;
use Livewire\Component;

class Form extends Component
{
    public ?Article $article = null;

    public array $articleData = [];

    public string $contentPreview = '';

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

    /**
     * @throws CommonMarkException
     */
    public function mount(): void
    {
        if ($this->article) {
            /** @var User $user */
            $user = Auth::user();
            if (! $this->article->hasAuthorization($user)) {
                $this->redirectRoute('home');

                return;
            }

            $this->articleData = $this->article->toArray();
            $this->articleData['keywords'] = $this->article->keywords->pluck('name')->implode(' ');
            $this->articleData['meta'] = $this->article->meta ?: [];
            $this->contentPreview = Article::markdownToHtml($this->article->content);
        }

        $this->method = $this->article === null ? 'post' : 'put';
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
            /** @var Keyword $newKeyword */
            $newKeyword = Keyword::query()->firstOrCreate(['name' => $keywordToAttach]);
            $newArticle->keywords()->attach($newKeyword->id);
        }

        //Notify all subscriber about the new article
        foreach (User::getSubscribedUsers() as $subscriber) {
            Mail::to($subscriber->email)->queue(new NotifySubscriberForNewArticle($newArticle, $subscriber));
        }

        session()->flash('success', 'Article published successfully!');
        $this->redirectRoute('backend.article.index', navigate: true);
    }

    protected function update(array $updateData): void
    {
        $this->article->update($updateData);

        $this->article->keywords()->detach();

        $keywordsToAttach = $this->getKeywords();

        foreach ($keywordsToAttach as $keywordToAttach) {
            /** @var Keyword $newKeyword */
            $newKeyword = Keyword::query()->firstOrCreate(['name' => $keywordToAttach]);
            $this->article->keywords()->attach($newKeyword->id);
        }

        session()->flash('successMsg', 'Article updated successfully!');
        $this->redirectRoute('backend.article.index', navigate: true);
    }

    public function getKeywords(): array
    {
        return array_filter(
            array_unique(
                explode(' ', Arr::get($this->articleData, 'keywords', ''))
            )
        );
    }

    /**
     * @throws CommonMarkException
     */
    public function updated(string $property): void
    {
        if ($property === 'articleData.content') {
            $this->contentPreview = Article::markdownToHtml($this->articleData['content']);
        }
    }

    public function render(): View
    {
        if (Arr::get($this->articleData, 'heading')) {
            $this->articleData['slug'] = Str::slug(Arr::get($this->articleData, 'heading'), '-', Arr::get($this->articleData, 'language'));
        }

        $categories = Category::query()->active()->get();

        return view('livewire.backend.article.form', compact('categories'));
    }
}
