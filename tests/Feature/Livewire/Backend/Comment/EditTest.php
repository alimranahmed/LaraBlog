<?php

namespace Tests\Feature\Livewire\Backend\Comment;

use App\Livewire\Backend\Comment\Edit;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class EditTest extends TestCase
{
    use WithFaker;

    public function testRender()
    {
        $article = Article::factory()->create();
        $comment = Comment::factory()->create(['article_id' => $article->id]);
        Livewire::test(Edit::class, ['comment' => $comment])
            ->assertViewIs('livewire.backend.comment.edit');
    }

    public function testUpdate()
    {
        $article = Article::factory()->create();
        $comment = Comment::factory(['article_id' => $article->id])->create();
        $updatedComment = clone $comment;

        Livewire::test(Edit::class, ['comment' => $comment])
            ->set('content', $content = $this->faker->paragraph)
            ->call('update', $updatedComment);

        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'content' => $content,
        ]);
    }
}
