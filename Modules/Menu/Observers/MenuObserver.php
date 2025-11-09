<?php

namespace Modules\Menu\Observers;

use Modules\Menu\Models\Menu;

class MenuObserver
{
    /**
     * Handle the Menu "created" event.
     */
    public function created(Menu $menu): void
    {
        $this->clearCache($menu);
    }

    /**
     * Handle the Menu "updated" event.
     */
    public function updated(Menu $menu): void
    {
        $this->clearCache($menu);
    }

    /**
     * Handle the Menu "deleted" event.
     */
    public function deleted(Menu $menu): void
    {
        $this->clearCache($menu);
    }

    /**
     * Handle the Menu "restored" event.
     */
    public function restored(Menu $menu): void
    {
        $this->clearCache($menu);
    }

    /**
     * Handle the Menu "force deleted" event.
     */
    public function forceDeleted(Menu $menu): void
    {
        $this->clearCache($menu);
    }

    /**
     * Clear menu cache for the affected location.
     */
    protected function clearCache(Menu $menu): void
    {
        // Clear cache for this specific menu location
        Menu::clearMenuCache($menu->location);

        // Log the cache clear for debugging purposes
        \Illuminate\Support\Facades\Log::debug("Menu cache cleared for location: {$menu->location}");
    }
}
