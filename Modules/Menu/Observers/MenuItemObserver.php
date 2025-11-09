<?php

namespace Modules\Menu\Observers;

use Modules\Menu\Models\Menu;
use Modules\Menu\Models\MenuItem;

class MenuItemObserver
{
    /**
     * Handle the MenuItem "created" event.
     */
    public function created(MenuItem $menuItem): void
    {
        $this->clearCache($menuItem);
    }

    /**
     * Handle the MenuItem "updated" event.
     */
    public function updated(MenuItem $menuItem): void
    {
        $this->clearCache($menuItem);
    }

    /**
     * Handle the MenuItem "deleted" event.
     */
    public function deleted(MenuItem $menuItem): void
    {
        $this->clearCache($menuItem);
    }

    /**
     * Handle the MenuItem "restored" event.
     */
    public function restored(MenuItem $menuItem): void
    {
        $this->clearCache($menuItem);
    }

    /**
     * Handle the MenuItem "force deleted" event.
     */
    public function forceDeleted(MenuItem $menuItem): void
    {
        $this->clearCache($menuItem);
    }

    /**
     * Clear menu cache for the affected menu location.
     */
    protected function clearCache(MenuItem $menuItem): void
    {
        // Get the parent menu to find the location
        $menu = $menuItem->menu;

        if ($menu) {
            // Clear cache for this menu's location
            Menu::clearMenuCache($menu->location);

            // Log the cache clear for debugging purposes
            \Illuminate\Support\Facades\Log::debug("Menu cache cleared for location: {$menu->location} (MenuItem: {$menuItem->name})");
        } else {
            // If menu is not found, clear all menu caches to be safe
            Menu::clearAllMenuCaches();

            \Illuminate\Support\Facades\Log::warning("Menu not found for MenuItem {$menuItem->id}, cleared all menu caches");
        }
    }
}
