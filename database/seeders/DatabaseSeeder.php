<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Traits\AutoDiscoverModuleSeeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    use AutoDiscoverModuleSeeders;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        // Always run essential seeders
        $this->call(AuthTableSeeder::class);

        // Always run Menu seeder (essential for navigation)
        $this->callEssentialModuleSeeders();

        // Only run dummy data seeders if enabled
        if ($this->shouldSeedDummyData()) {
            $this->callDummyDataSeeders();
        }

        Schema::enableForeignKeyConstraints();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }

    /**
     * Determine if dummy data should be seeded.
     */
    protected function shouldSeedDummyData(): bool
    {
        // Check environment variable first
        if (env('SEED_DUMMY_DATA') !== null) {
            return env('SEED_DUMMY_DATA', true);
        }

        // Check for command line option
        if (isset($_SERVER['argv']) && in_array('--no-dummy', $_SERVER['argv'])) {
            return false;
        }

        // Default to seeding dummy data
        return true;
    }

    /**
     * Call essential module seeders that are required for the application to function.
     */
    protected function callEssentialModuleSeeders(): void
    {
        $essentialModules = ['Menu'];

        foreach ($essentialModules as $moduleName) {
            $this->callModuleSeeder($moduleName);
        }
    }

    /**
     * Call dummy data module seeders for development/testing purposes.
     */
    protected function callDummyDataSeeders(): void
    {
        $dummyDataModules = ['Post', 'Category', 'Tag'];

        foreach ($dummyDataModules as $moduleName) {
            $this->callModuleSeeder($moduleName);
        }

        if (! app()->runningUnitTests()) {
            $this->command->info('Dummy data seeders completed');
        }
    }

    /**
     * Call a specific module seeder if it exists and is enabled.
     */
    protected function callModuleSeeder(string $moduleName): void
    {
        $modulesStatusFile = base_path('modules_statuses.json');

        if (! file_exists($modulesStatusFile)) {
            return;
        }

        $modulesStatus = json_decode(file_get_contents($modulesStatusFile), true);

        if (! isset($modulesStatus[$moduleName]) || ! $modulesStatus[$moduleName]) {
            return; // Skip if module is not enabled
        }

        $moduleNameLower = strtolower($moduleName);
        $seederBinding = $moduleNameLower.'.database.seeder';

        if (app()->bound($seederBinding)) {
            try {
                $seederClass = app()->make($seederBinding);
                $this->call($seederClass);
            } catch (\Exception $e) {
                $this->command->warn("Failed to seed module '{$moduleName}': ".$e->getMessage());
            }
        }
    }
}
