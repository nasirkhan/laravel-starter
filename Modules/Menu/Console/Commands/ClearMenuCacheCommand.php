<?php

namespace Modules\Menu\Console\Commands;

use Illuminate\Console\Command;
use Modules\Menu\Models\Menu;

class ClearMenuCacheCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'menu:clear-cache 
                            {location? : The menu location to clear cache for (optional)}
                            {--all : Clear all menu caches}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear cached menu data for a specific location or all menus';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $location = $this->argument('location');
        $clearAll = $this->option('all');

        if ($clearAll || ! $location) {
            $this->info('Clearing all menu caches...');
            Menu::clearAllMenuCaches();
            $this->info('✓ All menu caches cleared successfully!');

            return Command::SUCCESS;
        }

        $this->info("Clearing menu cache for location: {$location}");
        Menu::clearMenuCache($location);
        $this->info("✓ Menu cache cleared successfully for location: {$location}");

        return Command::SUCCESS;
    }
}
