<?php

namespace Tests\Feature\Commands;

use Tests\TestCase;

class AppHealthCheckCommandTest extends TestCase
{
    /**
     * Health check passes in a properly configured test environment.
     */
    public function test_health_check_passes_in_test_environment(): void
    {
        $this->artisan('app:health-check')
            ->assertSuccessful();
    }

    /**
     * The command output includes confirmation text.
     */
    public function test_health_check_outputs_environment_result(): void
    {
        $this->artisan('app:health-check')
            ->expectsOutputToContain('Environment variables')
            ->assertSuccessful();
    }

    /**
     * The command output includes a database check result.
     */
    public function test_health_check_outputs_database_result(): void
    {
        $this->artisan('app:health-check')
            ->expectsOutputToContain('Database connection')
            ->assertSuccessful();
    }

    /**
     * The command output includes a cache check result.
     */
    public function test_health_check_outputs_cache_result(): void
    {
        $this->artisan('app:health-check')
            ->expectsOutputToContain('Cache')
            ->assertSuccessful();
    }

    /**
     * The command output includes a mail check result.
     */
    public function test_health_check_outputs_mail_result(): void
    {
        $this->artisan('app:health-check')
            ->expectsOutputToContain('Mail')
            ->assertSuccessful();
    }
}
