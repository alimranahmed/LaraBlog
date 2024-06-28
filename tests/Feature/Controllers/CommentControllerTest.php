<?php

namespace Tests\Feature\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    protected User $user;

    protected Category $category;

    protected $article;

    public function setUp(): void
    {
        parent::setUp();

        Role::findOrCreate('reader');

        $this->user = User::factory()
            ->create(['name' => 'Example User', 'email' => 'example@test.com']);

        $this->category = Category::factory()->create();

        $this->article = Article::factory()->published()->create([
            'heading' => 'Test Heading',
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
        ]);
    }

    public function testConfirmComment()
    {
        $comment = Comment::factory()
            ->create([
                'user_id' => $this->user->id,
                'article_id' => $this->article->id,
                'is_published' => 0,
                'is_confirmed' => 0,
                'token' => 'test-token',
            ]);

        $this->get("comment/{$comment->id}/confirm/?token={$comment->token}")
            ->assertRedirect(route('get-article', [$comment->article->id]))
            ->assertSessionHas('successMsg');

        $comment = Comment::query()->find($comment->id);

        $this->assertEquals(1, $comment->is_published);
        $this->assertEquals(1, $comment->is_confirmed);
    }

    public function testConfirmCommentFailsWithInvalidToken()
    {
        $comment = Comment::factory()
            ->create([
                'user_id' => $this->user->id,
                'article_id' => $this->article->id,
                'is_published' => 0,
                'is_confirmed' => 0,
                'token' => 'test-token',
            ]);

        $this->get("comment/{$comment->id}/confirm/?token=".Str::random())
            ->assertRedirectToRoute('home')
            ->assertSessionHas('errorMsg');

        $this->assertEquals(0, $comment->is_published);
        $this->assertEquals(0, $comment->is_confirmed);
    }

    public function testConfirmCommentFailsWithAlreadyPublishedComment()
    {
        $comment = Comment::factory()
            ->create([
                'user_id' => $this->user->id,
                'article_id' => $this->article->id,
                'is_published' => 1,
                'is_confirmed' => 1,
                'token' => 'test-token',
            ]);

        $this->get("comment/{$comment->id}/confirm/?token=".$comment->token)
            ->assertRedirectToRoute('get-article', [$comment->article->id])
            ->assertSessionHas('warningMsg');

        $this->assertEquals(1, $comment->is_published);
        $this->assertEquals(1, $comment->is_confirmed);
    }
}
