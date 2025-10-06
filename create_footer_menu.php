<?php

require_once 'vendor/autoload.php';

use Modules\Menu\Models\Menu;
use Modules\Menu\Models\MenuItem;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Creating Footer Menu...\n";

// Create footer menu if it doesn't exist
$footerMenu = Menu::where('location', 'frontend-footer')->first();
if (!$footerMenu) {
    $footerMenu = Menu::create([
        'name' => 'Frontend Footer Navigation',
        'location' => 'frontend-footer',
        'description' => 'Footer links for frontend',
        'locale' => 'en',
        'is_public' => true,
        'is_active' => true,
        'is_visible' => true,
        'sort_order' => 1,
    ]);
    
    echo "Footer menu created with ID: {$footerMenu->id}\n";
} else {
    echo "Footer menu already exists with ID: {$footerMenu->id}\n";
}

// Create footer menu items
$footerMenuItems = [
    [
        'name' => 'About',
        'type' => 'link',
        'url' => '/about',
        'sort_order' => 1,
        'is_active' => true,
        'is_visible' => true,
    ],
    [
        'name' => 'Privacy',
        'type' => 'link',
        'route_name' => 'privacy',
        'sort_order' => 2,
        'is_active' => true,
        'is_visible' => true,
    ],
    [
        'name' => 'Terms',
        'type' => 'link',
        'route_name' => 'terms',
        'sort_order' => 3,
        'is_active' => true,
        'is_visible' => true,
    ],
    [
        'name' => 'FAQs',
        'type' => 'link',
        'url' => '/faqs',
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
];

foreach ($footerMenuItems as $itemData) {
    $itemData['menu_id'] = $footerMenu->id;
    
    // Check if item already exists
    $existingItem = MenuItem::where('menu_id', $footerMenu->id)
                           ->where('name', $itemData['name'])
                           ->first();
    
    if (!$existingItem) {
        MenuItem::create($itemData);
        echo "Created menu item: {$itemData['name']}\n";
    } else {
        echo "Menu item already exists: {$itemData['name']}\n";
    }
}

echo "\nFooter menu setup completed!\n";