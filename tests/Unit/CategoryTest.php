<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseTransactions;

    public function testCreatedAtAttribute()
    {
        $category = factory(Category::class)->create();
        $this->assertEquals('1 second ago', $category->createdAtHuman);
    }

    public function testActiveScope()
    {
        factory(Category::class)->create(['is_active' => 1]);
        $category = Category::active()->first();
        $this->assertEquals(1, $category->is_active);
    }

    public function testNonEmptyOnly()
    {
        $user = factory(User::class)->create(['email' => 'example@test.com']);
        $category = factory(Category::class)->create();
        factory(Article::class)->create(['category_id' => $category->id, 'user_id' => $user->id]);

        $this->assertTrue(Category::getNonEmptyOnly()->first()->articles->isNotEmpty());
    }
}
