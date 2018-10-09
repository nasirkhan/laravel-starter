<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Modules\Article\Entities\Newsletter::class, function (Faker $faker) {
    return [
        'name'              => $faker->sentence,
        'code'              => '',
        'content'           => $faker->paragraph,
        'type'              => $faker->randomElement(['Weekly', 'Monthly', 'Special']),
        'image'             => $faker->imageUrl($width = 1200, $height = 630),
        'status'            => 1,
        'created_at'        => Carbon::now(),
        'updated_at'        => Carbon::now(),
        'published_at'      => Carbon::now(),
    ];
});
