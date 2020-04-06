<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Modules\Article\Entities\Post::class, function (Faker $faker) {
    return [
        'name'              => $faker->sentence,
        'slug'              => '',
        'intro'             => $faker->paragraph,
        'content'           => $faker->paragraphs(rand(5, 7), true),
        'type'              => $faker->randomElement(['Article', 'Blog', 'News']),
        'is_featured'       => $faker->randomElement([1, 0]),
        'featured_image'    => "https://picsum.photos/1200/630",
        'status'            => 1,
        'category_id'       => $faker->numberBetween(1, 5),
        'meta_title'        => '',
        'meta_keywords'     => '',
        'meta_description'  => '',
        'meta_og_image'     => '',
        'meta_og_url'       => '',
        'created_by_name'   => '',
        'created_at'        => Carbon::now(),
        'updated_at'        => Carbon::now(),
        'published_at'      => Carbon::now(),
    ];
});
