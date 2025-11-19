<?php

namespace App\Console\Commands;

use Database\Seeders\AuthTableSeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class SeedEssentialData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:seed-essential
                            {--fresh : Run migrate:fresh before seeding}
                            {--force : Force the operation to run when in production}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed only essential data (users, roles, permissions, menus) without dummy data';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        if ($this->option('fresh')) {
            if (app()->environment('production') && ! $this->option('force')) {
                $this->error('This command will drop all tables. Use --force to run in production.');

                return self::FAILURE;
            }

            $this->info('Running fresh migrations...');
            $this->call('migrate:fresh', ['--force' => $this->option('force')]);
        }

        $this->info('Seeding essential data only...');

        Schema::disableForeignKeyConstraints();

        // Seed auth data (users, roles, permissions)
        $this->call('db:seed', [
            '--class' => AuthTableSeeder::class,
            '--force' => $this->option('force'),
        ]);

        // Seed Menu module (essential for navigation)
        $this->seedMenuModule();

        Schema::enableForeignKeyConstraints();

        $this->info('Essential data seeding completed successfully!');
        $this->line('');
        $this->line('<fg=yellow>Note:</fg=yellow> Dummy data (Posts, Categories, Tags) was skipped.');
        $this->line('<fg=green>To seed dummy data:</fg=green> Set SEED_DUMMY_DATA=true in .env and run php artisan db:seed');

        return self::SUCCESS;
    }

    /**
     * Seed the Menu module if it exists and is enabled.
     */
    protected function seedMenuModule(): void
    {
        $modulesStatusFile = base_path('modules_statuses.json');

        if (! file_exists($modulesStatusFile)) {
            $this->warn('modules_statuses.json not found. Skipping menu seeding.');

            return;
        }

        $modulesStatus = json_decode(file_get_contents($modulesStatusFile), true);

        if (! isset($modulesStatus['Menu']) || ! $modulesStatus['Menu']) {
            $this->warn('Menu module is not enabled. Skipping menu seeding.');

            return;
        }

        try {
            $this->call('db:seed', [
                '--class' => 'Modules\\Menu\\database\\seeders\\MenuDatabaseSeeder',
                '--force' => $this->option('force'),
            ]);
            $this->info('Menu module seeded successfully.');
        } catch (\Exception $e) {
            $this->error("Failed to seed Menu module: {$e->getMessage()}");
        }
    }
}
