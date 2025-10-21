<?php

namespace Modules\Menu\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Modules\Menu\Models\Menu;
use Modules\Menu\Models\MenuItem;

class CurrentMenuDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Load menu data from JSON file
        $dataFile = __DIR__.'/data/menu_data.json';

        if (! File::exists($dataFile)) {
            if (property_exists($this, 'command') && $this->command) {
                $this->command->error("Menu data file not found: {$dataFile}");
            } else {
                echo "Menu data file not found: {$dataFile}\n";
            }

            return;
        }

        $data = json_decode(File::get($dataFile), true);

        if (! $data || ! isset($data['menus']) || ! isset($data['menu_items'])) {
            if (property_exists($this, 'command') && $this->command) {
                $this->command->error("Invalid menu data format in: {$dataFile}");
            } else {
                echo "Invalid menu data format in: {$dataFile}\n";
            }

            return;
        }

        if (property_exists($this, 'command') && $this->command) {
            $this->command->info('Seeding menus and menu items from JSON data...');
        } else {
            echo 'Seeding menus and menu items from JSON data...'.PHP_EOL;
        }

        // Disable foreign key constraints
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate existing data
        MenuItem::truncate();
        Menu::truncate();

        // Seed menus
        foreach ($data['menus'] as $menuData) {
            Menu::create([
                'id' => $menuData['id'],
                'name' => $menuData['name'],
                'slug' => $menuData['slug'],
                'location' => $menuData['location'],
                'description' => $menuData['description'] ?? null,
                'status' => $menuData['status'],
                'is_active' => $menuData['is_active'],
                'is_visible' => $menuData['is_visible'],
                'is_public' => $menuData['is_public'],
                'theme' => $menuData['theme'] ?? 'default',
                'css_classes' => $menuData['css_classes'] ?? null,
                'locale' => $menuData['locale'] ?? null,
                'permissions' => $menuData['permissions'] ?? null,
                'roles' => $menuData['roles'] ?? null,
                'note' => $menuData['note'] ?? null,
                'settings' => $menuData['settings'] ?? null,
                'created_by' => $menuData['created_by'] ?? 1,
                'updated_by' => $menuData['updated_by'] ?? 1,
            ]);
        }

        // Seed menu items
        foreach ($data['menu_items'] as $itemData) {
            MenuItem::create([
                'id' => $itemData['id'],
                'menu_id' => $itemData['menu_id'],
                'parent_id' => $itemData['parent_id'],
                'name' => $itemData['name'],
                'slug' => $itemData['slug'],
                'description' => $itemData['description'] ?? null,
                'type' => $itemData['type'],
                'url' => $itemData['url'] ?? null,
                'route_name' => $itemData['route_name'] ?? null,
                'route_parameters' => $itemData['route_parameters'] ?? null,
                'opens_new_tab' => $itemData['opens_new_tab'] ?? false,
                'sort_order' => $itemData['sort_order'],
                'depth' => $itemData['depth'] ?? 0,
                'path' => $itemData['path'] ?? null,
                'icon' => $itemData['icon'] ?? null,
                'badge_text' => $itemData['badge_text'] ?? null,
                'badge_color' => $itemData['badge_color'] ?? null,
                'css_classes' => $itemData['css_classes'] ?? null,
                'html_attributes' => $itemData['html_attributes'] ?? null,
                'permissions' => $itemData['permissions'] ?? null,
                'roles' => $itemData['roles'] ?? null,
                'is_visible' => $itemData['is_visible'],
                'is_active' => $itemData['is_active'],
                'locale' => $itemData['locale'] ?? null,
                'meta_title' => $itemData['meta_title'] ?? null,
                'custom_data' => $itemData['custom_data'] ?? null,
                'note' => $itemData['note'] ?? null,
                'status' => $itemData['status'],
                'created_by' => $itemData['created_by'] ?? 1,
                'updated_by' => $itemData['updated_by'] ?? 1,
            ]);
        }

        // Re-enable foreign key constraints
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        echo 'Menus and menu items seeded successfully from JSON data!'.PHP_EOL;
    }
}
