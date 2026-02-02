<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class StarterInstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'starter:install
                            {--skip-db : Skip database setup}
                            {--skip-seed : Skip database seeding}
                            {--demo : Install with demo data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install and configure Laravel Starter';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->displayWelcome();

        if (! $this->confirmInstallation()) {
            return self::SUCCESS;
        }

        // Step 1: Environment Setup
        if ($this->setupEnvironment()) {
            // Step 2: Database Setup
            if ($this->option('skip-db') || $this->setupDatabase()) {
                // Step 3: Run Migrations
                if ($this->runMigrations()) {
                    // Step 4: Seed Database
                    if (! $this->option('skip-seed')) {
                        $this->seedDatabase();
                    }

                    // Step 5: Final Steps
                    $this->finalizeInstallation();

                    $this->displaySuccessMessage();

                    return self::SUCCESS;
                }
            }
        }

        $this->components->error('Installation failed. Please check the errors above.');

        return self::FAILURE;
    }

    /**
     * Display welcome message
     */
    protected function displayWelcome(): void
    {
        $this->newLine();
        $this->line('╔════════════════════════════════════════════════════╗');
        $this->line('║                                                    ║');
        $this->line('║        <fg=bright-blue>Laravel Starter Installation</fg=bright-blue>              ║');
        $this->line('║                                                    ║');
        $this->line('╚════════════════════════════════════════════════════╝');
        $this->newLine();
    }

    /**
     * Confirm installation
     */
    protected function confirmInstallation(): bool
    {
        if (File::exists(base_path('.env')) && ! File::exists(base_path('.env.backup'))) {
            $this->components->warn('Existing .env file detected.');

            if (! $this->confirm('Do you want to continue? (A backup will be created)', true)) {
                $this->components->info('Installation cancelled.');

                return false;
            }
        }

        return true;
    }

    /**
     * Setup environment file
     */
    protected function setupEnvironment(): bool
    {
        $this->components->task('Setting up environment', function () {
            if (! File::exists(base_path('.env'))) {
                File::copy(base_path('.env.example'), base_path('.env'));
                Artisan::call('key:generate', [], $this->output);

                return true;
            }

            // Backup existing .env
            if (! File::exists(base_path('.env.backup'))) {
                File::copy(base_path('.env'), base_path('.env.backup'));
                $this->line('  <fg=gray>✓ Existing .env backed up to .env.backup</>');
            }

            return true;
        });

        return true;
    }

    /**
     * Setup database
     */
    protected function setupDatabase(): bool
    {
        $this->newLine();
        $this->components->info('Database Configuration');

        $dbType = $this->choice(
            'Select database type',
            ['SQLite', 'MySQL', 'PostgreSQL'],
            0
        );

        if ($dbType === 'SQLite') {
            return $this->setupSQLite();
        }

        $this->components->warn('Please configure database manually in .env file:');
        $this->line('  - DB_CONNECTION=mysql (or pgsql)');
        $this->line('  - DB_HOST=127.0.0.1');
        $this->line('  - DB_PORT=3306 (or 5432 for PostgreSQL)');
        $this->line('  - DB_DATABASE=your_database');
        $this->line('  - DB_USERNAME=your_username');
        $this->line('  - DB_PASSWORD=your_password');
        $this->newLine();

        return $this->confirm('Have you configured the database?', true);
    }

    /**
     * Setup SQLite database
     */
    protected function setupSQLite(): bool
    {
        $this->components->task('Configuring SQLite', function () {
            $dbPath = database_path('database.sqlite');

            if (! File::exists($dbPath)) {
                File::put($dbPath, '');
            }

            $this->updateEnvFile('DB_CONNECTION', 'sqlite');
            $this->updateEnvFile('DB_DATABASE', $dbPath);

            return true;
        });

        return true;
    }

    /**
     * Run database migrations
     */
    protected function runMigrations(): bool
    {
        $this->newLine();

        if (! $this->confirm('Run database migrations?', true)) {
            $this->components->warn('Skipping migrations. Run manually: php artisan migrate');

            return false;
        }

        return $this->components->task('Running migrations', function () {
            Artisan::call('migrate:fresh', ['--force' => true], $this->output);

            return true;
        });
    }

    /**
     * Seed database
     */
    protected function seedDatabase(): void
    {
        $this->newLine();

        $seedDemo = $this->option('demo') || $this->confirm('Seed database with demo data?', true);

        if ($seedDemo) {
            $this->components->task('Seeding database', function () {
                Artisan::call('db:seed', ['--force' => true], $this->output);

                return true;
            });
        } else {
            $this->components->warn('Skipping seeding. Run manually: php artisan db:seed');
        }
    }

    /**
     * Finalize installation
     */
    protected function finalizeInstallation(): void
    {
        $this->newLine();
        $this->components->info('Finalizing installation');

        $this->components->task('Creating storage link', function () {
            if (! File::exists(public_path('storage'))) {
                Artisan::call('storage:link', [], $this->output);
            }

            return true;
        });

        $this->components->task('Clearing caches', function () {
            Artisan::call('config:clear');
            Artisan::call('cache:clear');
            Artisan::call('view:clear');
            Artisan::call('route:clear');

            return true;
        });
    }

    /**
     * Display success message
     */
    protected function displaySuccessMessage(): void
    {
        $this->newLine(2);
        $this->components->info('✓ Installation completed successfully!');
        $this->newLine();

        $this->components->twoColumnDetail('<fg=bright-blue>Default Credentials</>', '');
        $this->components->twoColumnDetail('Email', '<fg=yellow>admin@admin.com</>');
        $this->components->twoColumnDetail('Password', '<fg=yellow>secret</>');
        $this->newLine();

        $this->components->twoColumnDetail('<fg=bright-blue>Next Steps</>', '');
        $this->line('  1. <fg=green>npm install && npm run dev</> - Build frontend assets');
        $this->line('  2. <fg=green>php artisan serve</> - Start development server');
        $this->line('  3. Visit <fg=cyan>http://localhost:8000</> in your browser');
        $this->line('  4. Login with credentials above');
        $this->newLine();

        $this->components->twoColumnDetail('<fg=bright-blue>Useful Commands</>', '');
        $this->line('  • <fg=green>php artisan module:status</> - View module status');
        $this->line('  • <fg=green>php artisan module:publish {module}</> - Publish a module');
        $this->line('  • <fg=green>php artisan clear-all</> - Clear all caches');
        $this->newLine();
    }

    /**
     * Update environment file
     */
    protected function updateEnvFile(string $key, string $value): void
    {
        $envFile = base_path('.env');

        if (! File::exists($envFile)) {
            return;
        }

        $content = File::get($envFile);
        $pattern = "/^{$key}=.*/m";

        // Escape special regex characters in value
        $escapedValue = str_replace(['\\', '$'], ['\\\\', '\\$'], $value);
        $replacement = "{$key}={$escapedValue}";

        if (preg_match($pattern, $content)) {
            $content = preg_replace($pattern, $replacement, $content);
        } else {
            $content .= "\n{$replacement}";
        }

        File::put($envFile, $content);
    }
}
