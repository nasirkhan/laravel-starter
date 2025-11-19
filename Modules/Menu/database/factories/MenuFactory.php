<?php

namespace Modules\Menu\database\factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class MenuFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Menu\Models\Menu::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => substr($this->faker->text(15), 0, -1),
            'slug' => '',
            'description' => $this->faker->paragraph,
            'location' => $this->faker->randomElement(['header', 'footer', 'sidebar', 'mobile']),
            'theme' => 'default',
            'css_classes' => null,
            'settings' => null,
            'permissions' => null,
            'roles' => null,
            'is_public' => $this->faker->boolean(80), // 80% chance of being public
            'is_active' => $this->faker->boolean(90), // 90% chance of being active
            'is_visible' => $this->faker->boolean(95), // 95% chance of being visible
            'locale' => $this->faker->optional()->randomElement(['en', 'es', 'fr']),
            'note' => $this->faker->optional()->sentence(),
            'status' => 1,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
