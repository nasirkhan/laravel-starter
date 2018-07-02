<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Modules\Article\Entities\Post::class, function (Faker $faker) {
    return [
        'title'             => $faker->sentence,
        'slug'              => '',
        'intro'             => $faker->paragraph,
        'content'           => $faker->paragraph,
        'content'           => $faker->paragraph,
        'type'              => $faker->randomElement(['Article', 'Blog', 'News']),
        'is_featured'       => $faker->randomElement(['Yes', 'No']),
        'featured_image'    => $faker->imageUrl($width = 1200, $height = 630),
        'status'            => 1,
        'category_id'       => $faker->numberBetween(1, 5),
        'created_at'        => Carbon::now(),
        'updated_at'        => Carbon::now(),
        'published_at'      => Carbon::now(),
    ];
});
