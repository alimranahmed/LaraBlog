<?php

namespace Tests\Unit\Models;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseTransactions;

    public function testActiveScope()
    {
        Category::factory()->create(['is_active' => 1]);
        $category = Category::active()->first();
        $this->assertEquals(1, $category->is_active);
    }

    public function testNonEmptyOnly()
    {
        $user = User::factory()->create(['email' => 'example@test.com']);

        $category = Category::factory()->create();
        Article::factory()->create(['category_id' => $category->id, 'user_id' => $user->id]);

        $this->assertTrue(Category::getNonEmptyOnly()->first()->articles->isNotEmpty());
    }
}
