<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Models\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    public function testCreatedAtAttribute()
    {
        $category = factory(Category::class, 1)->create()->first();
        $this->assertEquals('1 second ago', $category->createdAtHuman);
    }

    public function testActiveScope()
    {
        factory(Category::class, 1)->create(['is_active' => 1]);
        $category = Category::active()->first();
        $this->assertEquals(1, $category->is_active);
    }

    public function testNonEmptyOnly()
    {
        $category = factory(Category::class, 1)->create()->first();
        factory(Article::class, 1)->create(['category_id' => $category->id]);

        $this->assertTrue(Category::getNonEmptyOnly()->first()->articles->isNotEmpty());
    }
}
