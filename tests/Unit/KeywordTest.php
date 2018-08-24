<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Models\Category;
use App\Models\Keyword;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class KeywordTest extends TestCase
{
    use DatabaseTransactions;

    protected $article;

    protected function setUp()
    {
        parent::setUp();

        $user = factory(User::class)->create(['email' => 'example@test.com']);

        $category = factory(Category::class)->create();

        $this->article = factory(Article::class)->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);
    }

    public function testCreatedAtHumanAttribute()
    {
        $keyword = factory(Keyword::class)->create([
            'name' => 'test_keyword',
        ]);

        $this->assertEquals('1 second ago', $keyword->createdAtHuman);
    }

    public function testGetArticleIds()
    {
        $keyword = factory(Keyword::class, 2)->create();

        $this->article->keywords()->attach($keyword->first()->id);



        $this->assertSame([$this->article->id], Keyword::getArticleIDs($keyword));
    }
}
