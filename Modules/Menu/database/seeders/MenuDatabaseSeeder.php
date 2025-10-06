<?php

namespace Modules\Menu\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Menu\Models\Menu;
use Modules\Menu\Models\MenuItem;

class MenuDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Disable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        /*
         * Menus Seed
         * ------------------
         */

        // Create a frontend header menu
        $frontendHeaderMenu = Menu::firstOrCreate([
            'location' => 'frontend-header',
            'locale' => 'en',
        ], [
            'name' => 'Frontend Header Menu',
            'slug' => 'frontend-header-menu',
            'description' => 'Main navigation menu for the frontend header',
            'location' => 'frontend-header',
            'theme' => 'default',
            'is_public' => true,
            'is_active' => true,
            'is_visible' => true,
            'locale' => 'en',
            'status' => 1,
        ]);

        // Create menu items
        $menuItems = [
            [
                'name' => 'Home',
                'slug' => 'home',
                'type' => 'link',
                'route_name' => 'home',
                'sort_order' => 1,
                'is_visible' => true,
                'is_active' => true,
                'locale' => 'en',
            ],
            [
                'name' => 'Posts',
                'slug' => 'posts',
                'type' => 'link',
                'route_name' => 'frontend.posts.index',
                'sort_order' => 2,
                'is_visible' => true,
                'is_active' => true,
                'locale' => 'en',
            ],
            [
                'name' => 'Categories',
                'slug' => 'categories',
                'type' => 'link',
                'route_name' => 'frontend.categories.index',
                'sort_order' => 3,
                'is_visible' => true,
                'is_active' => true,
                'locale' => 'en',
            ],
            [
                'name' => 'Tags',
                'slug' => 'tags',
                'type' => 'link',
                'route_name' => 'frontend.tags.index',
                'sort_order' => 4,
                'is_visible' => true,
                'is_active' => true,
                'locale' => 'en',
            ],
            [
                'name' => 'Contact',
                'slug' => 'contact',
                'type' => 'external',
                'url' => 'https://nasirkhn.com',
                'opens_new_tab' => true,
                'sort_order' => 5,
                'is_visible' => true,
                'is_active' => true,
                'locale' => 'en',
            ],
        ];

        foreach ($menuItems as $itemData) {
            MenuItem::firstOrCreate([
                'menu_id' => $frontendHeaderMenu->id,
                'slug' => $itemData['slug'],
            ], array_merge($itemData, [
                'menu_id' => $frontendHeaderMenu->id,
                'status' => 1,
            ]));
        }

        echo "Frontend header menu created successfully! \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
