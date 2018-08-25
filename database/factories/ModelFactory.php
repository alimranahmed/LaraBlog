<?php

use Faker\Generator as Faker;

//User
$factory->define(\App\Models\User::class, function (Faker $faker) {
    return [
        'title' => 'Mr',
        'name' => 'Al Imran Ahmed',
        'username' => 'imran',
        'email' => $faker->email,
        'password' => bcrypt('secret'),
        'token' => null,
    ];
});

//Category
$factory->define(App\Models\Category::class, function (Faker $faker) {
    return ['name' => $name = $faker->word, 'alias' => $name];
});

//Keyword
$factory->define(App\Models\Keyword::class, function (Faker $faker) {
    return ['name' => $faker->word];
});

//Article
$factory->define(App\Models\Article::class, function (Faker $faker) {
    return [
        'heading' => $faker->sentence,
        'content' => implode(' ', $faker->paragraphs(15)),
        'published_at' => now(),
        'is_published' => 1,
        'is_deleted' => 0,
        'user_id' => null,
        'language' => $faker->randomElement(['ben', 'eng']),
        'category_id' => null,
    ];
});

$factory->state(\App\Models\Article::class, 'published', [
    'is_published' => 1,
    'published_at' => now(),
]);

$factory->state(\App\Models\Article::class, 'unpublished', [
    'is_published' => 0,
    'published_at' => new \DateTime('+3 days'),
]);

//Comment
$factory->define(\App\Models\Comment::class, function (Faker $faker) {
    return [
        'content' => $faker->paragraph,
        'article_id' => null,
        'is_published' => 1,
        'published_at' => now(),
        'is_confirmed' => 1,
        'user_id' => null,
        'parent_comment_id' => null,
    ];
});


//Address
$factory->define(\App\Models\Address::class, function (Faker $faker) {
    return [
        'ip' => $faker->ipv4,
        'country_code' => $faker->countryCode,
        'country_name' => $faker->country,
        'region_name' => $faker->city,
        'city' => $faker->city,
        'timezone' => $faker->timezone,
        'zip_code' => $faker->postcode,
        'latitude' => $faker->latitude,
        'longitude' => $faker->longitude,
    ];
});
