<?php

namespace Database\Factories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $first_name = $this->faker->firstName;
        $last_name = $this->faker->lastName;
        $name = $first_name.' '.$last_name;

        return [
            'first_name'    => $first_name,
            'last_name'     => $last_name,
            'name'          => $name,
            'email'         => $this->faker->unique()->safeEmail,
            'password'      => Hash::make('password'),
            'mobile'        => $this->faker->phoneNumber,
            'date_of_birth' => $this->faker->date,
            'avatar'        => 'img/default-avatar.jpg',
            'gender'        => $this->faker->randomElement(['Male', 'Female', 'Other']),
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ];
    }
}
