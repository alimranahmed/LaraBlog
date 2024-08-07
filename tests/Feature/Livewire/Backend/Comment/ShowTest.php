<?php

namespace Tests\Feature\Livewire\Backend\Comment;

use App\Livewire\Backend\Comment\Show;
use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Livewire\Livewire;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use WithFaker;

    protected Comment $comment;

    protected User $user;

    protected Article $article;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        Auth::login($this->user);

        $this->article = Article::factory()->create([
            'user_id' => $this->user->id,
        ]);
        $this->comment = Comment::factory()->create([
            'article_id' => $this->article->id,
            'user_id' => $this->user->id,
        ]);
    }

    public function testRender()
    {
        Livewire::test(Show::class, ['comment' => $this->comment])
            ->assertOk()
            ->assertViewIs('livewire.backend.comment.show');
    }

    public function testSubmitReply()
    {
        Livewire::test(Show::class, ['comment' => $this->comment])
            ->set('reply', [
                'content' => $replyContent = $this->faker()->paragraph(),
            ])
            ->call('submitReply')
            ->assertOk()
            ->assertHasNoErrors();

        $this->assertDatabaseHas('comments', [
            'parent_comment_id' => $this->comment->id,
            'article_id' => $this->article->id,
            'user_id' => $this->user->id,
            'content' => $replyContent,
        ]);
    }

    public function testDelete()
    {
        Livewire::test(Show::class, ['comment' => $this->comment])
            ->call('delete', $this->comment)
            ->assertOk()
            ->assertHasNoErrors();

        $this->assertDatabaseMissing('comments', [
            'id' => $this->comment->id,
        ]);
    }
}
