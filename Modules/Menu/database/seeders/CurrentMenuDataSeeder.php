<?php

namespace Modules\Menu\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Menu\Models\Menu;
use Modules\Menu\Models\MenuItem;

class CurrentMenuDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear existing data
        MenuItem::truncate();
        Menu::truncate();
        
        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create Top Navigation Menu
        $topMenu = Menu::create([
            'id' => 1,
            'name' => 'Top Nav',
            'slug' => 'top-nav',
            'description' => null,
            'location' => 'frontend-header',
            'theme' => 'default',
            'css_classes' => null,
            'settings' => [
                'max_depth' => null,
                'cache_duration' => null
            ],
            'permissions' => null,
            'roles' => null,
            'is_public' => true,
            'is_active' => true,
            'is_visible' => true,
            'locale' => null,
            'note' => null,
            'status' => 1,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        // Create Footer Menu
        $footerMenu = Menu::create([
            'id' => 2,
            'name' => 'Footer Menu',
            'slug' => 'footer-menu',
            'description' => null,
            'location' => 'frontend-footer',
            'theme' => 'default',
            'css_classes' => null,
            'settings' => [
                'max_depth' => null,
                'cache_duration' => null
            ],
            'permissions' => null,
            'roles' => null,
            'is_public' => true,
            'is_active' => true,
            'is_visible' => true,
            'locale' => null,
            'note' => null,
            'status' => 1,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        // Create Top Menu Items
        $this->createTopMenuItems($topMenu);

        // Create Footer Menu Items
        $this->createFooterMenuItems($footerMenu);

        echo 'Frontend Header and Footer Menus seeded successfully!' . PHP_EOL;
    }

    /**
     * Create top menu items
     */
    private function createTopMenuItems(Menu $menu): void
    {
        // Home
        MenuItem::create([
            'id' => 1,
            'menu_id' => $menu->id,
            'parent_id' => null,
            'name' => 'Home',
            'slug' => 'home',
            'description' => null,
            'type' => 'external',
            'url' => '/',
            'route_name' => null,
            'route_parameters' => null,
            'opens_new_tab' => false,
            'sort_order' => 0,
            'depth' => 0,
            'path' => null,
            'icon' => null,
            'badge_text' => null,
            'badge_color' => null,
            'css_classes' => null,
            'html_attributes' => null,
            'permissions' => [],
            'roles' => [],
            'is_visible' => true,
            'is_active' => true,
            'locale' => null,
            'meta_title' => 'Home',
            'custom_data' => null,
            'note' => null,
            'status' => 1,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        // Posts
        MenuItem::create([
            'id' => 2,
            'menu_id' => $menu->id,
            'parent_id' => null,
            'name' => 'Posts',
            'slug' => 'posts',
            'description' => null,
            'type' => 'link',
            'url' => null,
            'route_name' => 'frontend.posts.index',
            'route_parameters' => null,
            'opens_new_tab' => false,
            'sort_order' => 1,
            'depth' => 0,
            'path' => null,
            'icon' => null,
            'badge_text' => null,
            'badge_color' => null,
            'css_classes' => null,
            'html_attributes' => null,
            'permissions' => null,
            'roles' => null,
            'is_visible' => true,
            'is_active' => true,
            'locale' => null,
            'meta_title' => 'Posts',
            'custom_data' => null,
            'note' => null,
            'status' => 1,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        // Categories
        MenuItem::create([
            'id' => 3,
            'menu_id' => $menu->id,
            'parent_id' => null,
            'name' => 'Categories',
            'slug' => 'categories',
            'description' => null,
            'type' => 'link',
            'url' => null,
            'route_name' => 'frontend.categories.index',
            'route_parameters' => null,
            'opens_new_tab' => false,
            'sort_order' => 2,
            'depth' => 0,
            'path' => null,
            'icon' => null,
            'badge_text' => null,
            'badge_color' => null,
            'css_classes' => null,
            'html_attributes' => null,
            'permissions' => null,
            'roles' => null,
            'is_visible' => true,
            'is_active' => true,
            'locale' => null,
            'meta_title' => 'Categories',
            'custom_data' => null,
            'note' => null,
            'status' => 1,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        // Tags
        MenuItem::create([
            'id' => 4,
            'menu_id' => $menu->id,
            'parent_id' => null,
            'name' => 'Tags',
            'slug' => 'tags',
            'description' => null,
            'type' => 'link',
            'url' => null,
            'route_name' => 'frontend.tags.index',
            'route_parameters' => null,
            'opens_new_tab' => false,
            'sort_order' => 3,
            'depth' => 0,
            'path' => null,
            'icon' => null,
            'badge_text' => null,
            'badge_color' => null,
            'css_classes' => null,
            'html_attributes' => null,
            'permissions' => null,
            'roles' => null,
            'is_visible' => true,
            'is_active' => true,
            'locale' => null,
            'meta_title' => 'Tags',
            'custom_data' => null,
            'note' => null,
            'status' => 1,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        // Dropdown (parent)
        $dropdownItem = MenuItem::create([
            'id' => 11,
            'menu_id' => $menu->id,
            'parent_id' => null,
            'name' => 'Dropdown',
            'slug' => 'dropdown',
            'description' => null,
            'type' => 'dropdown',
            'url' => null,
            'route_name' => '#',
            'route_parameters' => null,
            'opens_new_tab' => false,
            'sort_order' => 5,
            'depth' => 0,
            'path' => null,
            'icon' => null,
            'badge_text' => null,
            'badge_color' => null,
            'css_classes' => null,
            'html_attributes' => null,
            'permissions' => null,
            'roles' => null,
            'is_visible' => true,
            'is_active' => true,
            'locale' => null,
            'meta_title' => 'Dropdown',
            'custom_data' => null,
            'note' => null,
            'status' => 1,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        // Level 1 (child of dropdown)
        MenuItem::create([
            'id' => 10,
            'menu_id' => $menu->id,
            'parent_id' => $dropdownItem->id,
            'name' => 'Level 1',
            'slug' => 'level-1',
            'description' => null,
            'type' => 'link',
            'url' => '#',
            'route_name' => null,
            'route_parameters' => null,
            'opens_new_tab' => false,
            'sort_order' => 0,
            'depth' => 0,
            'path' => null,
            'icon' => null,
            'badge_text' => null,
            'badge_color' => null,
            'css_classes' => null,
            'html_attributes' => null,
            'permissions' => null,
            'roles' => null,
            'is_visible' => true,
            'is_active' => true,
            'locale' => null,
            'meta_title' => 'Level 1',
            'custom_data' => null,
            'note' => null,
            'status' => 1,
            'created_by' => 1,
            'updated_by' => 1,
        ]);
    }

    /**
     * Create footer menu items
     */
    private function createFooterMenuItems(Menu $menu): void
    {
        // About
        MenuItem::create([
            'id' => 5,
            'menu_id' => $menu->id,
            'parent_id' => null,
            'name' => 'About',
            'slug' => 'about',
            'description' => null,
            'type' => 'link',
            'url' => '#',
            'route_name' => null,
            'route_parameters' => null,
            'opens_new_tab' => false,
            'sort_order' => 0,
            'depth' => 0,
            'path' => null,
            'icon' => null,
            'badge_text' => null,
            'badge_color' => null,
            'css_classes' => null,
            'html_attributes' => null,
            'permissions' => null,
            'roles' => null,
            'is_visible' => true,
            'is_active' => true,
            'locale' => null,
            'meta_title' => 'About',
            'custom_data' => null,
            'note' => null,
            'status' => 1,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        // Privacy
        MenuItem::create([
            'id' => 6,
            'menu_id' => $menu->id,
            'parent_id' => null,
            'name' => 'Privacy',
            'slug' => 'privacy',
            'description' => null,
            'type' => 'link',
            'url' => null,
            'route_name' => 'frontend.privacy',
            'route_parameters' => null,
            'opens_new_tab' => false,
            'sort_order' => 1,
            'depth' => 0,
            'path' => null,
            'icon' => null,
            'badge_text' => null,
            'badge_color' => null,
            'css_classes' => null,
            'html_attributes' => null,
            'permissions' => null,
            'roles' => null,
            'is_visible' => true,
            'is_active' => true,
            'locale' => null,
            'meta_title' => 'Privacy',
            'custom_data' => null,
            'note' => null,
            'status' => 1,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        // Terms
        MenuItem::create([
            'id' => 7,
            'menu_id' => $menu->id,
            'parent_id' => null,
            'name' => 'Terms',
            'slug' => 'terms',
            'description' => null,
            'type' => 'link',
            'url' => null,
            'route_name' => 'frontend.terms',
            'route_parameters' => null,
            'opens_new_tab' => false,
            'sort_order' => 2,
            'depth' => 0,
            'path' => null,
            'icon' => null,
            'badge_text' => null,
            'badge_color' => null,
            'css_classes' => null,
            'html_attributes' => null,
            'permissions' => null,
            'roles' => null,
            'is_visible' => true,
            'is_active' => true,
            'locale' => null,
            'meta_title' => 'Terms',
            'custom_data' => null,
            'note' => null,
            'status' => 1,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        // Contact
        MenuItem::create([
            'id' => 8,
            'menu_id' => $menu->id,
            'parent_id' => null,
            'name' => 'Contact',
            'slug' => 'contact',
            'description' => null,
            'type' => 'link',
            'url' => '#',
            'route_name' => null,
            'route_parameters' => null,
            'opens_new_tab' => false,
            'sort_order' => 4,
            'depth' => 0,
            'path' => null,
            'icon' => null,
            'badge_text' => null,
            'badge_color' => null,
            'css_classes' => null,
            'html_attributes' => null,
            'permissions' => null,
            'roles' => null,
            'is_visible' => true,
            'is_active' => true,
            'locale' => null,
            'meta_title' => 'Contact',
            'custom_data' => null,
            'note' => null,
            'status' => 1,
            'created_by' => 1,
            'updated_by' => 1,
        ]);
    }
}
