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
    protected $description = 'Manage menu data - seed from PHP, export to PHP, or reset all data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $action = $this->argument('action');

        switch ($action) {
            case 'seed':
                return $this->seedFromPhp();
            case 'export':
                return $this->exportToPhp();
            case 'reset':
                return $this->resetMenuData();
            default:
                $this->error('Invalid action. Available actions: seed, export, reset');

                return 1;
        }
    }

    /**
     * Seed menu data from PHP files.
     */
    protected function seedFromPhp()
    {
        $files = glob(base_path('Modules/*/database/seeders/data/menu_data.php'));

        if (empty($files)) {
            $this->error("No menu_data.php files found in Modules.");

            return 1;
        }

        if (! $this->option('force') && ! $this->confirm('This will truncate existing menu data and seed from PHP files. Continue?')) {
            $this->info('Operation cancelled.');

            return 0;
        }

        $this->info('Seeding menus and menu items from PHP data...');

        // Disable foreign key constraints
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate existing data
        MenuItem::truncate();
        Menu::truncate();

        $allMenus = [];
        $allMenuItems = [];

        foreach ($files as $file) {
            $this->line("Reading: " . str_replace(base_path() . DIRECTORY_SEPARATOR, '', $file));
            $data = require $file;

            if (isset($data['menus']) && is_array($data['menus'])) {
                $allMenus = array_merge($allMenus, $data['menus']);
            }
            if (isset($data['menu_items']) && is_array($data['menu_items'])) {
                $allMenuItems = array_merge($allMenuItems, $data['menu_items']);
            }
        }

        // Seed menus
        $menuBar = $this->output->createProgressBar(count($allMenus));
        $menuBar->setFormat('Seeding menus: %current%/%max% [%bar%] %percent:3s%%');
        $menuBar->start();

        foreach ($allMenus as $menuData) {
            Menu::create($menuData);
            $menuBar->advance();
        }
        $menuBar->finish();
        $this->newLine();

        // Seed menu items
        $itemBar = $this->output->createProgressBar(count($allMenuItems));
        $itemBar->setFormat('Seeding menu items: %current%/%max% [%bar%] %percent:3s%%');
        $itemBar->start();

        foreach ($allMenuItems as $itemData) {
            MenuItem::create($itemData);
            $itemBar->advance();
        }
        $itemBar->finish();
        $this->newLine();

        // Re-enable foreign key constraints
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->info('Menu data seeded successfully from PHP files!');

        return 0;
    }

    /**
     * Export current menu data to PHP file.
     */
    protected function exportToPhp()
    {
        $this->info('Exporting current menu data to PHP...');

        $menus = Menu::orderBy('id')->get()->toArray();
        $menuItems = MenuItem::orderBy('menu_id')->orderBy('sort_order')->get()->toArray();

        $data = [
            'menus' => $menus,
            'menu_items' => $menuItems,
        ];

        $dataFile = base_path('Modules/Menu/database/seeders/data/menu_data.php');
        
        // Convert to short array syntax string
        $content = "<?php\n\nreturn " . $this->varExportShort($data) . ";\n";

        File::put($dataFile, $content);

        $this->info("Menu data exported successfully to: {$dataFile}");
        $this->info('Exported '.count($menus).' menus and '.count($menuItems).' menu items');

        return 0;
    }

    /**
     * Custom var_export with short array syntax
     */
    private function varExportShort($expression, $return = true)
    {
        $export = var_export($expression, true);
        $export = preg_replace("/^([ ]*)(.*)/m", '$1$1$2', $export);
        $array = preg_split("/\r\n|\n|\r/", $export);
        $array = preg_replace(["/\s*array\s\($/", "/\)(,)?$/", "/\s=>\s$/"], [NULL, ']$1', ' => ['], $array);
        $export = join(PHP_EOL, array_filter(["["] + $array));
        
        return $export;
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
