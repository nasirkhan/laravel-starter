<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AppHealthCheckCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:health-check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Validate environment, database, cache, and mail configuration';

    /** @var array<string, bool> */
    protected array $results = [];

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->newLine();
        $this->components->info('Running health checks...');
        $this->newLine();

        $this->checkEnvironment();
        $this->checkDatabase();
        $this->checkCache();
        $this->checkMail();

        $this->displaySummary();

        $failed = in_array(false, $this->results, strict: true);

        return $failed ? self::FAILURE : self::SUCCESS;
    }

    /**
     * Check required environment variables are set.
     */
    protected function checkEnvironment(): void
    {
        $required = ['APP_KEY', 'APP_URL', 'DB_CONNECTION'];
        $missing = [];

        foreach ($required as $key) {
            if (empty(env($key))) {
                $missing[] = $key;
            }
        }

        $passed = empty($missing);
        $this->results['Environment'] = $passed;

        if ($passed) {
            $this->components->twoColumnDetail('Environment variables', '<fg=green>OK</>');
        } else {
            $this->components->twoColumnDetail(
                'Environment variables',
                '<fg=red>FAIL — missing: '.implode(', ', $missing).'</>'
            );
        }
    }

    /**
     * Check that the database connection is reachable.
     */
    protected function checkDatabase(): void
    {
        try {
            DB::connection()->getPdo();
            $this->results['Database'] = true;
            $this->components->twoColumnDetail('Database connection', '<fg=green>OK</>');
        } catch (\Throwable $e) {
            $this->results['Database'] = false;
            $this->components->twoColumnDetail(
                'Database connection',
                '<fg=red>FAIL — '.$e->getMessage().'</>'
            );
        }
    }

    /**
     * Check that the cache driver is readable and writable.
     */
    protected function checkCache(): void
    {
        try {
            $key = 'health_check_'.uniqid();
            Cache::put($key, true, 5);
            $value = Cache::get($key);
            Cache::forget($key);

            $passed = $value === true;
            $this->results['Cache'] = $passed;

            $label = $passed ? '<fg=green>OK</>' : '<fg=red>FAIL — read-back mismatch</>';
            $this->components->twoColumnDetail('Cache ('.config('cache.default').')', $label);
        } catch (\Throwable $e) {
            $this->results['Cache'] = false;
            $this->components->twoColumnDetail(
                'Cache ('.config('cache.default').')',
                '<fg=red>FAIL — '.$e->getMessage().'</>'
            );
        }
    }

    /**
     * Check that the mail driver is configured (does not send).
     */
    protected function checkMail(): void
    {
        $mailer = config('mail.default');
        $fromAddress = config('mail.from.address');

        $passed = ! empty($mailer) && ! empty($fromAddress);
        $this->results['Mail'] = $passed;

        if ($passed) {
            $this->components->twoColumnDetail(
                'Mail (driver: '.$mailer.')',
                '<fg=green>OK — from: '.$fromAddress.'</>'
            );
        } else {
            $this->components->twoColumnDetail(
                'Mail',
                '<fg=yellow>WARN — MAIL_MAILER or MAIL_FROM_ADDRESS not set</>'
            );
        }
    }

    /**
     * Display the overall health summary.
     */
    protected function displaySummary(): void
    {
        $this->newLine();

        $failed = array_filter($this->results, fn (bool $passed) => ! $passed);

        if (empty($failed)) {
            $this->components->info('✓ All checks passed. Application is healthy.');
        } else {
            $this->components->error('✗ '.count($failed).' check(s) failed: '.implode(', ', array_keys($failed)));
        }

        $this->newLine();
    }
}
