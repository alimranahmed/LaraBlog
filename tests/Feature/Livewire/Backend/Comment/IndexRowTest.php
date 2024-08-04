<?php

namespace Tests\Feature\Livewire\Backend\Comment;

use App\Livewire\Backend\Comment\Index;
use App\Livewire\Backend\Comment\IndexRow;
use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Livewire\Livewire;
use Tests\TestCase;

class IndexRowTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();
        Auth::login($user);

    }

    public function testRender()
    {
        $article = Article::factory()->create();
        $comment = Comment::factory()->create([
            'article_id' => $article->id,
            'user_id' => Auth::id(),
        ]);

        Livewire::test(IndexRow::class, ['comment' => $comment])
            ->assertStatus(Response::HTTP_OK)
            ->assertViewIs('livewire.backend.comment.index-row');
    }

    public function testTogglePublishMakePublished()
    {
        $article = Article::factory()->create();
        $comment = Comment::factory()->create([
            'article_id' => $article->id,
            'user_id' => Auth::id(),
            'is_published' => false,
            'published_at' => now(),
        ]);

        Livewire::test(IndexRow::class, ['comment' => $comment])
            ->call('togglePublish');

        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'is_published' => true,
        ]);
    }

    public function testTogglePublishMakeUnpublished()
    {
        $article = Article::factory()->create();
        $comment = Comment::factory()->create([
            'article_id' => $article->id,
            'user_id' => Auth::id(),
            'is_published' => true,
        ]);

        Livewire::test(IndexRow::class, ['comment' => $comment])
            ->call('togglePublish');

        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'is_published' => false,
        ]);
    }

    public function testDestroy()
    {
        $article = Article::factory()->create([
            'comment_count' => 1,
        ]);

        $comment = Comment::factory()->create([
            'article_id' => $article->id,
            'user_id' => Auth::id(),
            'is_published' => true,
        ]);

        Livewire::test(IndexRow::class, ['comment' => $comment])
            ->call('destroy', $comment)
            ->assertDispatchedTo(Index::class, 'commentDeleted');

        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'comment_count' => 0,
        ]);
    }
}
