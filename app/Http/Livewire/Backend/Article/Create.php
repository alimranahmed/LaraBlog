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

class Create extends Component
{
    public $article;

    public $rules = [
        'article.heading' => 'required',
        'article.category_id' => 'required',
        'article.content' => 'required',
        'article.language' => 'required',
        'article.is_comment_enabled' => 'boolean'
    ];

    public function render()
    {
        $categories = Category::active()->get();

        return view('livewire.backend.article.create', compact('categories'));
    }

    public function submit()
    {
        $newArticle = Arr::get($this->validate(), 'article');

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
}
