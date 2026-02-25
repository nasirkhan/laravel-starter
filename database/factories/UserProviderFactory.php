<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserProvider>
 */
class UserProviderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $providers = ['github', 'google', 'facebook', 'twitter'];

        return [
            'user_id' => User::factory(),
            'provider' => fake()->randomElement($providers),
            'provider_id' => fake()->unique()->numerify('########'),
            'avatar' => fake()->imageUrl(200, 200, 'people'),
        ];
    }
}
