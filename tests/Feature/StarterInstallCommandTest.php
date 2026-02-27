<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class StarterInstallCommandTest extends TestCase
{
    public function test_starter_install_is_registered_as_an_artisan_command(): void
    {
        $commands = Artisan::all();

        $this->assertArrayHasKey('starter:install', $commands);
    }

    public function test_command_aborts_gracefully_when_user_declines_existing_env_confirmation(): void
    {
        // Ensure .env exists so the confirmation prompt fires
        if (! File::exists(base_path('.env'))) {
            File::copy(base_path('.env.example'), base_path('.env'));
        }

        // Remove backup so the "existing .env" branch triggers
        if (File::exists(base_path('.env.backup'))) {
            File::delete(base_path('.env.backup'));
        }

        $this->artisan('starter:install')
            ->expectsConfirmation('Do you want to continue? (A backup will be created)', 'no')
            ->assertSuccessful();
    }

    public function test_skip_db_seed_npm_flags_bypass_all_those_steps(): void
    {
        // Ensure .env.backup exists so the existing-env confirmation is skipped
        $createdBackup = false;

        if (! File::exists(base_path('.env.backup'))) {
            File::copy(base_path('.env'), base_path('.env.backup'));
            $createdBackup = true;
        }

        // --skip-db bypasses both DB type selection AND migrations,
        // so no database choice prompt should appear.
        $this->artisan('starter:install', [
            '--skip-db' => true,
            '--skip-seed' => true,
            '--skip-npm' => true,
        ])
            ->assertSuccessful();

        if ($createdBackup) {
            File::delete(base_path('.env.backup'));
        }
    }

    public function test_migration_choice_prompts_with_correct_options(): void
    {
        $createdBackup = false;

        if (! File::exists(base_path('.env.backup'))) {
            File::copy(base_path('.env'), base_path('.env.backup'));
            $createdBackup = true;
        }

        $this->artisan('starter:install', [
            '--skip-seed' => true,
            '--skip-npm' => true,
        ])
            ->expectsChoice(
                'Select database type',
                'SQLite',
                ['SQLite', 'MySQL', 'PostgreSQL']
            )
            ->expectsChoice(
                'How would you like to set up the database?',
                'skip',
                [
                    'fresh' => 'Fresh install — drop all tables and re-run all migrations (⚠️  destroys existing data)',
                    'migrate' => 'Run new migrations only — safe for existing data',
                    'skip' => 'Skip migrations',
                ]
            )
            ->assertFailed(); // skipping migrations means the inner block is not entered

        if ($createdBackup) {
            File::delete(base_path('.env.backup'));
        }
    }
}
