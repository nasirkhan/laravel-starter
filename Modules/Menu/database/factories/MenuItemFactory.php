<?php

namespace Modules\Menu\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Menu\Models\Menu;
use Modules\Menu\Models\MenuItem;

class MenuItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MenuItem::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['link', 'dropdown', 'divider', 'heading', 'external'];
        $icons = ['fas fa-home', 'fas fa-user', 'fas fa-cog', 'fas fa-info', 'fas fa-envelope'];

        return [
            'menu_id' => Menu::factory(),
            'parent_id' => null,
            'name' => $this->faker->words(2, true),
            'slug' => $this->faker->slug,
            'description' => $this->faker->sentence(),
            'type' => $this->faker->randomElement($types),
            'url' => $this->faker->optional()->url(),
            'route_name' => $this->faker->optional()->randomElement(['home', 'about', 'contact']),
            'route_parameters' => $this->faker->optional()->randomElement([[], ['id' => 1]]),
            'opens_new_tab' => $this->faker->boolean(20), // 20% chance
            'sort_order' => $this->faker->numberBetween(0, 100),
            'depth' => 0,
            'path' => null,
            'icon' => $this->faker->optional()->randomElement($icons),
            'badge_text' => $this->faker->optional()->word(),
            'badge_color' => $this->faker->optional()->randomElement(['primary', 'secondary', 'success', 'danger']),
            'css_classes' => $this->faker->optional()->words(2, true),
            'html_attributes' => $this->faker->optional()->randomElement([
                ['data-toggle' => 'tooltip'],
                ['data-placement' => 'top'],
            ]),
            'permissions' => $this->faker->optional()->randomElement([
                ['view_backend'],
                ['edit_posts', 'view_posts'],
                [],
            ]),
            'roles' => $this->faker->optional()->randomElement([
                ['admin'],
                ['editor', 'author'],
                [],
            ]),
            'is_visible' => $this->faker->boolean(90), // 90% chance
            'is_active' => $this->faker->boolean(95), // 95% chance
            'locale' => $this->faker->optional()->randomElement(['en', 'es', 'fr']),
            'meta_title' => $this->faker->optional()->sentence(3),
            'meta_description' => $this->faker->optional()->sentence(),
            'meta_keywords' => $this->faker->optional()->words(3, true),
            'custom_data' => $this->faker->optional()->randomElement([
                ['priority' => 'high'],
                ['category' => 'navigation'],
            ]),
            'note' => $this->faker->optional()->sentence(),
            'status' => $this->faker->randomElement([0, 1, 2]), // disabled, enabled, draft
            'created_by' => 1,
            'updated_by' => 1,
        ];
    }

    /**
     * Create a dropdown menu item.
     */
    public function dropdown(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'dropdown',
            'url' => null,
            'route_name' => null,
        ]);
    }

    /**
     * Create an external link menu item.
     */
    public function external(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'external',
            'url' => $this->faker->url(),
            'opens_new_tab' => true,
            'route_name' => null,
        ]);
    }

    /**
     * Create a divider menu item.
     */
    public function divider(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'divider',
            'name' => '---',
            'url' => null,
            'route_name' => null,
            'icon' => null,
        ]);
    }

    /**
     * Create a heading menu item.
     */
    public function heading(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'heading',
            'name' => $this->faker->words(1, true),
            'url' => null,
            'route_name' => null,
        ]);
    }

    /**
     * Create a child menu item with parent.
     */
    public function child(): static
    {
        return $this->state(fn (array $attributes) => [
            'parent_id' => MenuItem::factory(),
            'depth' => 1,
        ]);
    }

    /**
     * Create a visible menu item.
     */
    public function visible(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_visible' => true,
            'is_active' => true,
            'status' => 1,
        ]);
    }

    /**
     * Create a hidden menu item.
     */
    public function hidden(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_visible' => false,
            'status' => 0,
        ]);
    }
}
