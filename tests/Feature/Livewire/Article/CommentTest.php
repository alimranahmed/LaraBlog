<?php

namespace Tests\Feature\Livewire\Article;

use App\Http\Livewire\Frontend\Article\Comments;
use App\Mail\CommentConfirmation;
use App\Mail\NotifyAdmin;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Config;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CommentTest extends TestCase
{
    public function testAdd()
    {
        Mail::fake();

        Config::create(['name' => 'admin_email', 'value' => 'imran@example.com']);
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

        $comment = Comment::where('article_id', $article->id)->where('content', $content)->first();
        $this->assertNotNull($comment);
        $this->assertEquals(0, $comment->is_published);
        $this->assertEquals(0, $comment->is_confirmed);

        $user = User::where('email', $email)->first();
        $this->assertNotNull($user);
        $this->assertEquals($name, $user->name);

        $this->assertEquals(1, $user->reader->notify);
        $this->assertEquals(0, $user->reader->is_verified);
    }
}
