<?php

namespace Tests\Unit;

use App\Models\Address;
use App\Models\Article;
use App\Models\Category;
use App\Models\HitLogger;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HitLoggerTest extends TestCase
{
    use DatabaseTransactions;

    protected $article;

    protected function setUp()
    {
        parent::setUp();

        $user = factory(User::class, 1)->create(['email' => 'example@test.com'])->first();

        $category = factory(Category::class, 1)->create()->first();

        $this->article = factory(Article::class, 1)->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
        ])->first();
    }

    public function testCountryAttribute()
    {

        $address = factory(Address::class, 1)->create([
            'country_name' => 'Bangladesh'
        ])->first();

        $hitLogger = HitLogger::create([
            'article_id' => $this->article->id,
            'address_id' => $address->id,
        ]);

        $this->assertEquals('Bangladesh', $hitLogger->country);

        $address = $address = factory(Address::class, 1)->create([
            'country_name' => null,
        ])->first();

        $hitLogger = HitLogger::create([
            'article_id' => $this->article->id,
            'address_id' => $address->id,
        ]);

        $this->assertEquals('Unknown', $hitLogger->country);
    }

    public function testCityAttribute()
    {
        $address = factory(Address::class, 1)->create([
            'city' => 'Dhaka'
        ])->first();

        $hitLogger = HitLogger::create([
            'article_id' => $this->article->id,
            'address_id' => $address->id,
        ]);

        $this->assertEquals('Dhaka', $hitLogger->city);

        $address = $address = factory(Address::class, 1)->create([
            'city' => null,
        ])->first();

        $hitLogger = HitLogger::create([
            'article_id' => $this->article->id,
            'address_id' => $address->id,
        ]);

        $this->assertEquals('Unknown', $hitLogger->city);
    }
}
