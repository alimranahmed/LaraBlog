<?php

namespace Tests\Unit;

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

    protected function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create(['email' => 'example@test.com']);

        $this->category = factory(Category::class)->create();

        $this->article = factory(Article::class)->create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
        ]);
    }

    public function testPublishedScope()
    {
        factory(Comment::class)->create([
            'user_id' => $this->user->id,
            'article_id' => $this->article->id,
            'is_published' => 1
        ]);

        $comment = Comment::published()->first();
        $this->assertEquals(1, $comment->is_published);
    }


    public function testNoRepliesTest()
    {
        factory(Comment::class, 1)->create([
            'user_id' => $this->user->id,
            'article_id' => $this->article->id,
            'is_published' => 1,
            'parent_comment_id' => null,
        ]);

        $comment = Comment::noReplies()->first();

        $this->assertNull($comment->parentComment);
    }

    public function testCreatedAtHumanAttribute()
    {
        $comment = factory(Comment::class)->create([
            'user_id' => $this->user->id,
            'article_id' => $this->article->id,
        ]);

        $this->assertEquals('1 second ago', $comment->createdAtHuman);
    }

    public function testPublishedAtHumanAttribute()
    {
        $comment = factory(Comment::class)->create([
            'user_id' => $this->user->id,
            'article_id' => $this->article->id,
            'published_at' => now(),
        ]);

        $this->assertEquals('1 second ago', $comment->publishedAtHuman);
    }
}
