<?php

namespace Tests\Feature\Livewire\Frontend\Article;

use App\Livewire\Frontend\Article\Comments;
use App\Mail\CommentConfirmation;
use App\Mail\NotifyAdmin;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Config;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CommentTest extends TestCase
{
    public function testAddValidation()
    {
        $article = Article::factory()->create();

        Livewire::test(Comments::class, ['article' => $article])
            ->call('add')
            ->assertHasErrors('comment.name')
            ->assertHasErrors('comment.email')
            ->assertHasErrors('comment.content');
    }

    public function testAdd()
    {
        Mail::fake();

        Config::query()->create(['name' => 'admin_email', 'value' => 'imran@example.com']);
        Role::findOrCreate('reader');

        $article = Article::factory()->create();

        Livewire::test(Comments::class, ['article' => $article])
            ->set('comment.content', $content = 'test comment')
            ->set('comment.email', $email = 'test@example.com')
            ->set('comment.name', $name = 'Al Imran Ahmed')
            ->set('comment.notify', 1)
            ->call('add');

        Mail::assertQueued(CommentConfirmation::class);
        Mail::assertQueued(NotifyAdmin::class);

        $comment = Comment::query()->where('article_id', $article->id)->where('content', $content)->first();
        $this->assertNotNull($comment);
        $this->assertEquals(0, $comment->is_published);
        $this->assertEquals(0, $comment->is_confirmed);

        $user = User::query()->where('email', $email)->first();
        $this->assertNotNull($user);
        $this->assertEquals($name, $user->name);

        $this->assertEquals(1, $user->reader->notify);
        $this->assertEquals(0, $user->reader->is_verified);
    }
}
