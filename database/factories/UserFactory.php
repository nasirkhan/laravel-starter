<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\User::class, function (Faker $faker) {
    $first_name = $faker->firstName;
    $last_name = $faker->lastName;

    return [
        'first_name'    => $first_name,
        'last_name'     => $last_name,
        'name'          => $first_name.' '.$last_name,
        'email'         => $faker->unique()->safeEmail,
        'password'      => Hash::make('000000'),
        'mobile'        => $faker->phoneNumber,
        'date_of_birth' => $faker->date,
        'avatar'        => 'img/default-avatar.jpg',
        'gender'        => $faker->randomElement(['Man', 'Woman', 'Other']),
        'created_at'    => Carbon::now(),
        'updated_at'    => Carbon::now(),
    ];
});
