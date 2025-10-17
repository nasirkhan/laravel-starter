<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Modules\Menu\Models\Menu;
use Modules\Menu\Models\MenuItem;

echo "Adding Menu Management items..." . PHP_EOL;

// Get the admin sidebar menu
$adminMenu = Menu::where('location', 'admin-sidebar')->first();

if (!$adminMenu) {
    echo "Admin sidebar menu not found!" . PHP_EOL;
    exit(1);
}

// Check if Menu Management already exists
$existingMenuManagement = MenuItem::where('menu_id', $adminMenu->id)
    ->where('name', 'Menu Management')
    ->first();

if ($existingMenuManagement) {
    echo "Menu Management already exists! Skipping..." . PHP_EOL;
    exit(0);
}

// Add Menu Management parent item
$menuManagement = MenuItem::create([
    'menu_id' => $adminMenu->id,
    'parent_id' => null,
    'name' => 'Menu Management',
    'slug' => 'menu-management',
    'description' => 'Manage website menus and navigation',
    'type' => 'dropdown',
    'url' => null,
    'route_name' => null,
    'route_parameters' => null,
    'icon' => 'fa-solid fa-bars',
    'css_classes' => null,
    'permissions' => ['view_menus'],
    'roles' => ['super admin', 'admin'],
    'is_public' => false,
    'is_active' => true,
    'is_visible' => true,
    'sort_order' => 100,
    'locale' => 'en',
    'target' => null,
    'badge_text' => null,
    'badge_color' => null,
    'note' => 'Parent menu for menu management',
    'status' => 1
]);

echo "Created Menu Management parent item (ID: {$menuManagement->id})" . PHP_EOL;

// Add Menus child item
$menusItem = MenuItem::create([
    'menu_id' => $adminMenu->id,
    'parent_id' => $menuManagement->id,
    'name' => 'Menus',
    'slug' => 'menus',
    'description' => 'Manage menu containers',
    'type' => 'link',
    'url' => null,
    'route_name' => 'backend.menus.index',
    'route_parameters' => null,
    'icon' => 'fa-solid fa-list',
    'css_classes' => null,
    'permissions' => ['view_menus'],
    'roles' => ['super admin', 'admin'],
    'is_public' => false,
    'is_active' => true,
    'is_visible' => true,
    'sort_order' => 1,
    'locale' => 'en',
    'target' => null,
    'badge_text' => null,
    'badge_color' => null,
    'note' => 'Manage menu containers',
    'status' => 1
]);

echo "Created Menus item (ID: {$menusItem->id})" . PHP_EOL;

// Add Menu Items child item
$menuItemsItem = MenuItem::create([
    'menu_id' => $adminMenu->id,
    'parent_id' => $menuManagement->id,
    'name' => 'Menu Items',
    'slug' => 'menu-items',
    'description' => 'Manage individual menu items',
    'type' => 'link',
    'url' => null,
    'route_name' => 'backend.menuitems.index',
    'route_parameters' => null,
    'icon' => 'fa-solid fa-link',
    'css_classes' => null,
    'permissions' => ['view_menus'],
    'roles' => ['super admin', 'admin'],
    'is_public' => false,
    'is_active' => true,
    'is_visible' => true,
    'sort_order' => 2,
    'locale' => 'en',
    'target' => null,
    'badge_text' => null,
    'badge_color' => null,
    'note' => 'Manage individual menu items',
    'status' => 1
]);

echo "Created Menu Items item (ID: {$menuItemsItem->id})" . PHP_EOL;

echo PHP_EOL . "Menu management items added successfully!" . PHP_EOL;