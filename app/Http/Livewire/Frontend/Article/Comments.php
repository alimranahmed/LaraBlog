<?php

namespace App\Http\Livewire\Frontend\Article;

use App\Mail\CommentConfirmation;
use App\Mail\NotifyAdmin;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Config;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use function route;
use function view;

class Comments extends Component
{
    public $article;

    public $comments;

    public $comment;

    public $isSubmitted = false;

    public $rules = [
        'comment.content' => 'required',
        'comment.name' => 'required',
        'comment.email' => 'email|required'
    ];

    public function mount(Article $article)
    {
        $this->article = $article;
        $this->comments = $this->getComments();
    }

    public function render()
    {
        return view('livewire.frontend.article.comments');
    }

    public function add()
    {
        $this->validate();

        DB::beginTransaction();

        $newComment = Comment::create([
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

        $this->comment = null;
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
        $user = User::where('email', $this->comment['email'])->first();

        if (is_null($user)) {
            $user = User::create(['email' => $this->comment['email']]);
            $user->assignRole('reader');
            $user->reader()->create(['notify' => isset($this->comment['notify']),]);
        } elseif ($user->isReader()) {
            $user->reader->update(['notify' => isset($this->comment['notify']),]);
        }

        $user->update([
            'name' => $this->comment['name'],
            'last_ip' => $_SERVER['REMOTE_ADDR'] ?? '',
            'token' => Hash::make($this->comment['content']),
        ]);
        return $user;
    }
}
