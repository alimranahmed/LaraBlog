<?php

namespace Tests\Feature\Livewire\Backend\Article;

use App\Livewire\Backend\Article\Index;
use App\Livewire\Backend\Article\IndexRow;
use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class IndexRowTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();
        $author = Role::findOrCreate('author');
        $user->assignRole($author);
        Auth::loginUsingId($user->id);
    }

    public function testRender(): void
    {
        $article = Article::factory()->create();

        Livewire::test(IndexRow::class, ['article' => $article])
            ->assertStatus(Response::HTTP_OK)
            ->assertViewIs('livewire.backend.article.index-row');
    }

    public function testTogglePublishCanMakeUnpublish()
    {
        $article = Article::factory()->create(['is_published' => true]);

        Livewire::test(IndexRow::class, ['article' => $article])
            ->call('togglePublish');

        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'is_published' => false,
        ]);
    }

    public function testTogglePublishCanMakePublish()
    {
        $article = Article::factory()->create(['is_published' => false]);

        Livewire::test(IndexRow::class, ['article' => $article])
            ->call('togglePublish');

        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'is_published' => true,
        ]);
    }

    public function testDestroy()
    {
        $article = Article::factory()->create(['is_deleted' => false]);

        Livewire::test(IndexRow::class, ['article' => $article])
            ->call('destroy')
            ->assertDispatchedTo(Index::class, 'articleDeleted');

        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'is_deleted' => true,
        ]);
    }
}
