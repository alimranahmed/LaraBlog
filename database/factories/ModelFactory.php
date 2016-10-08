<?php

$factory->define(App\Models\Category::class, function(Faker\Generator $faker){
    return [ 'name' => $faker->word ];
});

$factory->define(App\Models\Article::class, function (Faker\Generator $faker) {

    return [
        'heading' => $faker->sentence,
        'content' => $faker->paragraph,
        'published_at' => new \DateTime(),
        'user_id' => 1,
    ];
});
