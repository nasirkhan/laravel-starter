<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Modules\Menu\Models\Menu;
use Modules\Menu\Models\MenuItem;

echo "=== Backend Dynamic Menu Test ===" . PHP_EOL;

// Get the admin sidebar menu
$adminMenu = Menu::where('location', 'admin-sidebar')->first();

if (!$adminMenu) {
    echo "❌ Admin sidebar menu not found!" . PHP_EOL;
    exit(1);
}

echo "✅ Admin Sidebar Menu Found: {$adminMenu->name}" . PHP_EOL;
echo "Location: {$adminMenu->location}" . PHP_EOL;
echo "Status: " . ($adminMenu->is_active ? 'Active' : 'Inactive') . PHP_EOL;
echo "Visible: " . ($adminMenu->is_visible ? 'Yes' : 'No') . PHP_EOL;

// Get root level menu items
$rootItems = $adminMenu->items()->whereNull('parent_id')->orderBy('sort_order')->get();

echo PHP_EOL . "=== Root Menu Items ({$rootItems->count()}) ===" . PHP_EOL;

foreach ($rootItems as $item) {
    echo "- {$item->name}";
    if ($item->route_name) {
        echo " (Route: {$item->route_name})";
    }
    if ($item->icon) {
        echo " [{$item->icon}]";
    }
    echo PHP_EOL;
    
    // Show children
    $children = $item->children()->orderBy('sort_order')->get();
    if ($children->count() > 0) {
        echo "  └─ Children ({$children->count()}):" . PHP_EOL;
        foreach ($children as $child) {
            echo "     └─ {$child->name}";
            if ($child->route_name) {
                echo " (Route: {$child->route_name})";
            }
            echo PHP_EOL;
        }
    }
}

echo PHP_EOL . "=== Menu System Status ===" . PHP_EOL;
echo "✅ Total Menus: " . Menu::count() . PHP_EOL;
echo "✅ Total Menu Items: " . MenuItem::count() . PHP_EOL;
echo "✅ Admin Menu Items: " . $adminMenu->allItems()->count() . PHP_EOL;

echo PHP_EOL . "=== Test Complete ===" . PHP_EOL;