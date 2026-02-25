<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class StarterUpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'starter:update
                            {--skip-migrate : Skip running database migrations}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Laravel Starter: pull Composer packages, check module migrations, run migrations, and clear caches';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->displayHeader();

        $this->updateComposerPackages();
        $this->checkModuleMigrations();
        $this->runMigrationsIfNeeded();
        $this->clearCaches();
        $this->displaySummary();

        return self::SUCCESS;
    }

    /**
     * Display the update header.
     */
    protected function displayHeader(): void
    {
        $this->newLine();
        $this->line('╔════════════════════════════════════════════════════╗');
        $this->line('║                                                    ║');
        $this->line('║          <fg=bright-blue>Laravel Starter Update</>                  ║');
        $this->line('║                                                    ║');
        $this->line('╚════════════════════════════════════════════════════╝');
        $this->newLine();
    }

    /**
     * Run composer update to pull the latest package versions.
     */
    protected function updateComposerPackages(): void
    {
        $this->components->task('Updating Composer packages', function () {
            $output = [];
            $exitCode = 0;
            exec('composer update --no-interaction --no-ansi 2>&1', $output, $exitCode);

            if ($exitCode !== 0) {
                $this->newLine();
                $this->components->warn('composer update returned a non-zero exit code. Check output above.');
            }

            return true;
        });
    }

    /**
     * Report any new module migrations that need publishing.
     */
    protected function checkModuleMigrations(): void
    {
        $this->newLine();
        $this->components->info('Checking for new module migrations...');
        Artisan::call('module:check-migrations', [], $this->output);
    }

    /**
     * Run outstanding database migrations (unless skipped).
     */
    protected function runMigrationsIfNeeded(): void
    {
        if ($this->option('skip-migrate')) {
            $this->components->warn('Skipping migrations (--skip-migrate).');

            return;
        }

        if (! $this->confirm('Run database migrations?', true)) {
            $this->components->warn('Skipping migrations. Run manually: php artisan migrate');

            return;
        }

        $this->components->task('Running migrations', function () {
            Artisan::call('migrate', ['--force' => true], $this->output);

            return true;
        });
    }

    /**
     * Clear all application caches.
     */
    protected function clearCaches(): void
    {
        $this->components->task('Clearing caches', function () {
            Artisan::call('config:clear');
            Artisan::call('cache:clear');
            Artisan::call('view:clear');
            Artisan::call('route:clear');

            return true;
        });
    }

    /**
     * Display the post-update summary.
     */
    protected function displaySummary(): void
    {
        $this->newLine();
        $this->components->info('✓ Update complete!');
        $this->newLine();
        $this->components->twoColumnDetail('<fg=bright-blue>Next Steps</>', '');
        $this->line('  • <fg=green>npm install && npm run build</> — Rebuild frontend assets if needed');
        $this->line('  • <fg=green>php artisan module:status</> — Review module status');
        $this->line('  • <fg=green>php artisan app:health-check</> — Verify the environment is healthy');
        $this->newLine();
    }
}
