<?php

namespace Tests\Feature;

use App\Http\Livewire\Frontend\Article\Comments;
use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\User;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CommentTest extends TestCase
{
    protected $user;

    protected $category;

    protected $article;

    public function setUp(): void
    {
        parent::setUp();

        Role::findOrCreate('reader');

        $this->user =  User::factory()
            ->create(['name' => 'Example User', 'email' => 'example@test.com']);

        $this->category = Category::factory()->create();

        $this->article = Article::factory()->published()->create([
            'heading' => 'Test Heading',
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
        ]);
    }

    public function testStoreValidation()
    {
        Livewire::test(Comments::class, ['article' => $this->article])
            ->call('add')
            ->assertHasErrors('comment.name')
            ->assertHasErrors('comment.email')
            ->assertHasErrors('comment.content');
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
            ->assertRedirect(route('get-article', [$comment->article->id]));


        $comment = Comment::find($comment->id);

        $this->assertEquals(1, $comment->is_published);
        $this->assertEquals(1, $comment->is_confirmed);

        $comment->update([
            'is_published' => 0,
            'is_confirmed' => 0,
            'token' => 'test-token'
        ]);

        $this->get("comment/{$comment->id}/confirm/?token=invalid-token")
            ->assertRedirect(route('home'));

        $this->assertEquals(0, $comment->is_published);
        $this->assertEquals(0, $comment->is_confirmed);
    }
}
