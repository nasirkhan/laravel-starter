<?php

namespace Modules\Menu\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Menu\Models\Menu;
use Modules\Menu\Models\MenuItem;

class FrontendHeaderMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create main navigation menu for frontend header
        $menu = Menu::create([
            'name' => 'Frontend Header Navigation',
            'location' => 'frontend-header',
            'description' => 'Main navigation menu for frontend header',
            'locale' => 'en',
            'is_public' => true,
            'is_active' => true,
            'is_visible' => true,
            'sort_order' => 1,
        ]);

        // Create menu items
        $menuItems = [
            [
                'name' => 'Home',
                'type' => 'link',
                'route_name' => 'home',
                'sort_order' => 1,
                'is_active' => true,
                'is_visible' => true,
            ],
            [
                'name' => 'About',
                'type' => 'dropdown',
                'sort_order' => 2,
                'is_active' => true,
                'is_visible' => true,
                'children' => [
                    [
                        'name' => 'About Us',
                        'type' => 'link',
                        'url' => '/about',
                        'sort_order' => 1,
                        'is_active' => true,
                        'is_visible' => true,
                    ],
                    [
                        'name' => 'Our Team',
                        'type' => 'link',
                        'url' => '/team',
                        'sort_order' => 2,
                        'is_active' => true,
                        'is_visible' => true,
                    ],
                    [
                        'name' => 'Company Info',
                        'type' => 'heading',
                        'sort_order' => 3,
                        'is_active' => true,
                        'is_visible' => true,
                    ],
                    [
                        'name' => 'History',
                        'type' => 'link',
                        'url' => '/history',
                        'sort_order' => 4,
                        'is_active' => true,
                        'is_visible' => true,
                    ],
                ],
            ],
            [
                'name' => 'Services',
                'type' => 'dropdown',
                'sort_order' => 3,
                'is_active' => true,
                'is_visible' => true,
                'children' => [
                    [
                        'name' => 'Web Development',
                        'type' => 'link',
                        'url' => '/services/web-development',
                        'sort_order' => 1,
                        'is_active' => true,
                        'is_visible' => true,
                    ],
                    [
                        'name' => 'Mobile Apps',
                        'type' => 'link',
                        'url' => '/services/mobile-apps',
                        'sort_order' => 2,
                        'is_active' => true,
                        'is_visible' => true,
                    ],
                    [
                        'name' => 'divider',
                        'type' => 'divider',
                        'sort_order' => 3,
                        'is_active' => true,
                        'is_visible' => true,
                    ],
                    [
                        'name' => 'Consulting',
                        'type' => 'link',
                        'url' => '/services/consulting',
                        'sort_order' => 4,
                        'is_active' => true,
                        'is_visible' => true,
                    ],
                ],
            ],
            [
                'name' => 'Blog',
                'type' => 'link',
                'url' => '/blog',
                'sort_order' => 4,
                'is_active' => true,
                'is_visible' => true,
            ],
            [
                'name' => 'Contact',
                'type' => 'link',
                'url' => '/contact',
                'sort_order' => 5,
                'is_active' => true,
                'is_visible' => true,
            ],
            [
                'name' => 'External Link',
                'type' => 'external',
                'url' => 'https://github.com/nasirkhan/laravel-starter',
                'sort_order' => 6,
                'is_active' => true,
                'is_visible' => true,
                'opens_new_tab' => true,
            ],
        ];

        foreach ($menuItems as $itemData) {
            $children = $itemData['children'] ?? null;
            unset($itemData['children']);

            $itemData['menu_id'] = $menu->id;
            $menuItem = MenuItem::create($itemData);

            // Create children if they exist
            if ($children) {
                foreach ($children as $childData) {
                    $childData['menu_id'] = $menu->id;
                    $childData['parent_id'] = $menuItem->id;
                    MenuItem::create($childData);
                }
            }
        }

        $this->command->info('Frontend Header Menu seeded successfully!');
    }
}
