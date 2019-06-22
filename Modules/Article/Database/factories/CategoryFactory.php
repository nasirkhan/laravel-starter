<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Modules\Article\Entities\Category::class, function (Faker $faker) {
    return [
        'name'              => $faker->sentence(2),
        'slug'              => '',
        'description'       => $faker->paragraph,
        'status'            => 1,
        'created_at'        => Carbon::now(),
        'updated_at'        => Carbon::now(),
    ];
});
