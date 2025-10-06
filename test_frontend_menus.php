<?php

require_once 'vendor/autoload.php';

use Modules\Menu\Models\Menu;
use Modules\Menu\Models\MenuItem;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Testing Frontend Menu System\n";
echo "=" . str_repeat("=", 50) . "\n\n";

$locations = ['frontend-header', 'frontend-footer'];

foreach ($locations as $location) {
    echo "Testing Menu Query for location: {$location}\n";
    echo "-" . str_repeat("-", 40) . "\n";
    
    // Get current locale
    $currentLocale = 'en';
    
    // Query menus by location (without locale filter first)
    $menus = Menu::byLocation($location)
        ->activeAndVisible()
        ->where(function($query) use ($currentLocale) {
            $query->where('locale', $currentLocale)
                  ->orWhereNull('locale');
        })
        ->with(['items' => function($query) {
            $query->visible()
                  ->rootLevel()
                  ->orderBy('sort_order')
                  ->with(['children' => function($childQuery) {
                      $childQuery->visible()->orderBy('sort_order');
                  }]);
        }])
        ->get()
        ->filter(function($menu) {
            return $menu->userCanSee();
        });
    
    echo "Found " . $menus->count() . " menu(s)\n";
    
    foreach ($menus as $menu) {
        echo "  Menu: {$menu->name}\n";
        echo "    Location: {$menu->location}\n";
        echo "    Items: " . $menu->items->count() . "\n";
        
        foreach ($menu->items as $item) {
            echo "      - {$item->name} ({$item->type})";
            if ($item->route_name) {
                echo " -> Route: {$item->route_name}";
            }
            if ($item->url) {
                echo " -> URL: {$item->url}";
            }
            echo "\n";
        }
    }
    echo "\n";
}

echo "Menu system testing completed!\n";