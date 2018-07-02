<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(Modules\Article\Entities\Category::class, function (Faker $faker) {
    return [
        'name'              => $faker->sentence(2),
        'code'              => '',
        'description'       => $faker->paragraph,
        'status'            => 1,
        'created_at'        => Carbon::now(),
        'updated_at'        => Carbon::now(),
    ];
});
