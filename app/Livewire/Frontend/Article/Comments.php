<?php

namespace App\Livewire\Frontend\Article;

use App\Mail\CommentConfirmation;
use App\Mail\NotifyAdmin;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Config;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

use function route;
use function view;

class Comments extends Component
{
    public Article $article;

    public Collection $comments;

    public array $comment = [];

    public bool $isSubmitted = false;

    public array $rules = [
        'comment.content' => 'required',
        'comment.name' => 'required',
        'comment.email' => 'email|required',
    ];

    public function mount(Article $article): void
    {
        $this->article = $article;
        $this->comments = $this->getComments();
    }

    public function render(): View
    {
        return view('livewire.frontend.article.comments');
    }

    public function add(): void
    {
        $this->validate();

        DB::beginTransaction();

        $newComment = Comment::query()->create([
            'article_id' => $this->article->id,
            'content' => $this->comment['content'],
            'token' => Hash::make($this->comment['content']),
            'is_published' => false,
            'user_id' => $this->updateOrCreateUser()->id,
        ]);

        $this->article->increment('comment_count');

        DB::commit();

        Mail::to($this->comment['email'])->queue(new CommentConfirmation($newComment));

        Mail::to(Config::get('admin_email'))
            ->queue(new NotifyAdmin($newComment, route('get-article', $this->article->id)));

        $this->reset('comment');
        $this->comments = $this->getComments();
        $this->isSubmitted = true;
    }

    private function getComments()
    {
        return $this->article->comments()
            ->noReplies()
            ->published()
            ->with('replies', function ($replies) {
                return $replies->published();
            })
            ->with('user', 'replies.user')
            ->get();
    }

    private function updateOrCreateUser(): User
    {
        /** @var User $user */
        $user = User::query()->where('email', $this->comment['email'])->first();

        if (is_null($user)) {
            $user = User::query()->create(['email' => $this->comment['email']]);
            $user->assignRole('reader');
            $user->reader()->create(['notify' => isset($this->comment['notify'])]);
        } elseif ($user->isReader()) {
            $user->reader->update(['notify' => isset($this->comment['notify'])]);
        }

        $user->update([
            'name' => $this->comment['name'],
            'last_ip' => $_SERVER['REMOTE_ADDR'] ?? '',
            'token' => Hash::make($this->comment['content']),
        ]);

        return $user;
    }
}
