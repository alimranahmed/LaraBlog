<?php

namespace Tests\Unit\Models;

use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var Category
     */
    protected $category;

    /**
     * @var Article
     */
    protected $article;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create(['email' => 'example@test.com']);

        $this->category = Category::factory()->create();

        $this->article = Article::factory()->create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
        ]);
    }

    public function testPublishedScope()
    {
        Comment::factory()->create([
            'user_id' => $this->user->id,
            'article_id' => $this->article->id,
            'is_published' => 1
        ]);

        $comment = Comment::published()->first();
        $this->assertEquals(1, $comment->is_published);
    }


    public function testNoRepliesTest()
    {
        Comment::factory()->create([
            'user_id' => $this->user->id,
            'article_id' => $this->article->id,
            'is_published' => 1,
            'parent_comment_id' => null,
        ]);

        $comment = Comment::noReplies()->first();

        $this->assertNull($comment->parentComment);
    }
}
