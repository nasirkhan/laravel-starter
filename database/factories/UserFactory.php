<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

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
    static $password;

    $firstName = $faker->firstName;
    $lastName = $faker->lastName;

    return [
        'first_name'        => $firstName,
        'last_name'         => $lastName,
        'name'              => $firstName . ' ' . $lastName,
        'email'             => $faker->unique()->safeEmail,
        'mobile'            => $faker->phoneNumber,
        'gender'            => $faker->randomElement(['Man', 'Woman', 'Other']),
        'password'          => $password ?: $password = 'secret',
        'remember_token'    => str_random(10),
        'confirmation_code' => md5(uniqid(mt_rand(), true)),
        'confirmed_at'      => Carbon::now(),
        'created_at'        => Carbon::now(),
        'updated_at'        => Carbon::now(),
    ];
});
