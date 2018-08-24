<?php

namespace Tests\Unit;

use App\Models\Address;
use App\Models\Article;
use App\Models\Category;
use App\Models\HitLogger;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class HitLoggerTest extends TestCase
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

    public function testCountryAttribute()
    {
        $address = factory(Address::class)->create([
            'country_name' => 'Bangladesh'
        ]);

        $hitLogger = HitLogger::create([
            'article_id' => $this->article->id,
            'address_id' => $address->id,
        ]);

        $this->assertEquals('Bangladesh', $hitLogger->country);

        $address = $address = factory(Address::class)->create([
            'country_name' => null,
        ]);

        $hitLogger = HitLogger::create([
            'article_id' => $this->article->id,
            'address_id' => $address->id,
        ]);

        $this->assertEquals('Unknown', $hitLogger->country);
    }

    public function testCityAttribute()
    {
        $address = factory(Address::class)->create([
            'city' => 'Dhaka'
        ]);

        $hitLogger = HitLogger::create([
            'article_id' => $this->article->id,
            'address_id' => $address->id,
        ]);

        $this->assertEquals('Dhaka', $hitLogger->city);

        $address = $address = factory(Address::class)->create([
            'city' => null,
        ]);

        $hitLogger = HitLogger::create([
            'article_id' => $this->article->id,
            'address_id' => $address->id,
        ]);

        $this->assertEquals('Unknown', $hitLogger->city);
    }
}
