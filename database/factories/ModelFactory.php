<?php

$factory->define(App\Models\Category::class, function(Faker\Generator $faker){
    return [ 'name' => $name = $faker->word, 'alias' => $name ];
});

$factory->define(App\Models\Article::class, function (Faker\Generator $faker) {

    return [
        'heading' => $faker->sentence,
        'content' => $faker->paragraph,
        'published_at' => new \DateTime(),
        'user_id' => 1,
        'category_id' => $faker->numberBetween(1, 5),
    ];
});


$factory->define(\App\Models\Comment::class, function(Faker\Generator $faker){
    return [
        'content' => $faker->paragraph,
        'article_id' => $faker->numberBetween(1, 10),
        'user_id' => 1,
    ];
});