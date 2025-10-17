<?php

namespace Modules\Menu\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Modules\Menu\Models\Menu;
use Modules\Menu\Models\MenuItem;

class MenuDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'menu:data 
                          {action : Action to perform (seed|export|reset)}
                          {--force : Force the operation without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manage menu data - seed from JSON, export to JSON, or reset all data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $action = $this->argument('action');

        switch ($action) {
            case 'seed':
                return $this->seedFromJson();
            case 'export':
                return $this->exportToJson();
            case 'reset':
                return $this->resetMenuData();
            default:
                $this->error('Invalid action. Available actions: seed, export, reset');

                return 1;
        }
    }

    /**
     * Seed menu data from JSON file.
     */
    protected function seedFromJson()
    {
        $dataFile = base_path('Modules/Menu/database/seeders/data/menu_data.json');

        if (! File::exists($dataFile)) {
            $this->error("Menu data file not found: {$dataFile}");

            return 1;
        }

        $data = json_decode(File::get($dataFile), true);

        if (! $data || ! isset($data['menus']) || ! isset($data['menu_items'])) {
            $this->error("Invalid menu data format in: {$dataFile}");

            return 1;
        }

        if (! $this->option('force') && ! $this->confirm('This will truncate existing menu data and seed from JSON. Continue?')) {
            $this->info('Operation cancelled.');

            return 0;
        }

        $this->info('Seeding menus and menu items from JSON data...');

        // Disable foreign key constraints
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate existing data
        MenuItem::truncate();
        Menu::truncate();

        // Seed menus
        $menuBar = $this->output->createProgressBar(count($data['menus']));
        $menuBar->setFormat('Seeding menus: %current%/%max% [%bar%] %percent:3s%%');
        $menuBar->start();

        foreach ($data['menus'] as $menuData) {
            Menu::create($menuData);
            $menuBar->advance();
        }
        $menuBar->finish();
        $this->newLine();

        // Seed menu items
        $itemBar = $this->output->createProgressBar(count($data['menu_items']));
        $itemBar->setFormat('Seeding menu items: %current%/%max% [%bar%] %percent:3s%%');
        $itemBar->start();

        foreach ($data['menu_items'] as $itemData) {
            MenuItem::create($itemData);
            $itemBar->advance();
        }
        $itemBar->finish();
        $this->newLine();

        // Re-enable foreign key constraints
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->info('Menu data seeded successfully from JSON!');

        return 0;
    }

    /**
     * Export current menu data to JSON file.
     */
    protected function exportToJson()
    {
        $this->info('Exporting current menu data to JSON...');

        $menus = Menu::orderBy('id')->get()->toArray();
        $menuItems = MenuItem::orderBy('menu_id')->orderBy('sort_order')->get()->toArray();

        $data = [
            'menus' => $menus,
            'menu_items' => $menuItems,
        ];

        $dataFile = base_path('Modules/Menu/database/seeders/data/menu_data.json');
        $jsonData = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        File::put($dataFile, $jsonData);

        $this->info("Menu data exported successfully to: {$dataFile}");
        $this->info('Exported '.count($menus).' menus and '.count($menuItems).' menu items');

        return 0;
    }

    /**
     * Reset all menu data.
     */
    protected function resetMenuData()
    {
        if (! $this->option('force') && ! $this->confirm('This will permanently delete all menu data. Are you sure?')) {
            $this->info('Operation cancelled.');

            return 0;
        }

        $this->info('Resetting menu data...');

        // Disable foreign key constraints
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate all menu data
        $itemCount = MenuItem::count();
        $menuCount = Menu::count();

        MenuItem::truncate();
        Menu::truncate();

        // Re-enable foreign key constraints
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->info("Reset complete! Deleted {$menuCount} menus and {$itemCount} menu items.");

        return 0;
    }
}
