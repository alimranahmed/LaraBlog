<?php

namespace Tests\Unit;

use App\Models\Address;
use App\Models\Article;
use App\Models\HitLogger;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HitLoggerTest extends TestCase
{
    use DatabaseTransactions;

    public function testCountryAttribute()
    {
        $article = factory(Article::class, 1)->create()->first();

        $address = factory(Address::class, 1)->create([
            'country_name' => 'Bangladesh'
        ])->first();

        $hitLogger = HitLogger::create([
            'article_id' => $article->id,
            'address_id' => $address->id,
        ]);

        $this->assertEquals('Bangladesh', $hitLogger->country);

        $address = $address = factory(Address::class, 1)->create([
            'country_name' => null,
        ])->first();

        $hitLogger = HitLogger::create([
            'article_id' => $article->id,
            'address_id' => $address->id,
        ]);

        $this->assertEquals('Unknown', $hitLogger->country);
    }

    public function testCityAttribute()
    {
        $article = factory(Article::class, 1)->create()->first();

        $address = factory(Address::class, 1)->create([
            'city' => 'Dhaka'
        ])->first();

        $hitLogger = HitLogger::create([
            'article_id' => $article->id,
            'address_id' => $address->id,
        ]);

        $this->assertEquals('Dhaka', $hitLogger->city);

        $address = $address = factory(Address::class, 1)->create([
            'city' => null,
        ])->first();

        $hitLogger = HitLogger::create([
            'article_id' => $article->id,
            'address_id' => $address->id,
        ]);

        $this->assertEquals('Unknown', $hitLogger->city);
    }
}
