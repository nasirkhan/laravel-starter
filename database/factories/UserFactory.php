<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
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
     * @return array<string, mixed>
     */
    public function definition()
    {
        $first_name = $this->faker->firstName;
        $last_name = $this->faker->lastName;
        $name = $first_name.' '.$last_name;

        return [
            'first_name'        => $first_name,
            'last_name'         => $last_name,
            'name'              => $name,
            'email'             => $this->faker->unique()->safeEmail(),
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token'    => Str::random(10),
            'mobile'            => $this->faker->phoneNumber,
            'date_of_birth'     => $this->faker->date,
            'avatar'            => 'img/default-avatar.jpg',
            'gender'            => $this->faker->randomElement(['Male', 'Female', 'Other']),
            'email_verified_at' => now(),
            'created_at'        => now(),
            'updated_at'        => now(),
        ];
    }
}
