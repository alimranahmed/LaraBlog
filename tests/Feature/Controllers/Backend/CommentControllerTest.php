<?php

namespace Tests\Feature\Controllers\Backend;

use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    protected User $user;

    protected Category $category;

    protected Article $article;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();

        $role = Role::findOrCreate('owner');
        $this->user->assignRole($role);

        $this->category = Category::factory()->create();

        $this->article = Article::factory()->published()->create([
            'heading' => 'Test Heading',
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
        ]);
    }

    public function testIndex()
    {
        $this->actingAs($this->user)->get('/admin/comment')
            ->assertStatus(Response::HTTP_OK)
            ->assertViewIs('backend.comments.index');
    }

    public function testEdit()
    {
        $comment = Comment::factory()->create(['article_id' => $this->article->id]);

        $this->actingAs($this->user)->get("/admin/comment/{$comment->id}/edit")
            ->assertStatus(Response::HTTP_OK)
            ->assertViewIs('backend.comments.edit')
            ->assertViewHas('comment', $comment);
    }

    public function testShow()
    {
        $comment = Comment::factory()->create([
            'article_id' => $this->article->id,
            'user_id' => $this->user->id,
        ]);

        $this->actingAs($this->user)->get("/admin/comment/{$comment->id}")
            ->assertStatus(Response::HTTP_OK)
            ->assertViewIs('backend.comments.show')
            ->assertViewHas('comment', $comment);
    }
}
