<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Modules\Article\Entities\Comment::class, function (Faker $faker) {
    return [
        'name'              => $faker->sentence(2),
        'slug'              => '',
        'comment'           => $faker->paragraph,
        'user_id'           => encode_id($faker->numberBetween(1, 4)),
        'status'            => $faker->randomElement([0, 1]),
        'moderated_by'      => $faker->numberBetween(1, 2),
        'moderated_at'      => Carbon::now(),
        'published_at'      => Carbon::now(),
        'created_at'        => Carbon::now(),
        'updated_at'        => Carbon::now(),
    ];
});
