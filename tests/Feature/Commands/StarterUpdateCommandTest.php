<?php

namespace Tests\Feature\Commands;

use Tests\TestCase;

class StarterUpdateCommandTest extends TestCase
{
    /**
     * The command exists under the correct signature.
     */
    public function test_command_is_registered_under_starter_update(): void
    {
        $this->assertTrue(
            collect($this->app['Illuminate\Contracts\Console\Kernel']->all())
                ->has('starter:update')
        );
    }

    /**
     * Passing --skip-migrate skips the migration prompt and succeeds.
     */
    public function test_it_skips_migrations_when_flag_is_passed(): void
    {
        $this->artisan('starter:update', ['--skip-migrate' => true])
            ->assertSuccessful();
    }

    /**
     * When prompted for migrations the user can decline and the command still succeeds.
     */
    public function test_it_succeeds_when_user_declines_migrations(): void
    {
        $this->artisan('starter:update')
            ->expectsConfirmation('Run database migrations?', 'no')
            ->assertSuccessful();
    }

    /**
     * The output includes the next-steps summary.
     */
    public function test_it_outputs_next_steps_after_completion(): void
    {
        $this->artisan('starter:update', ['--skip-migrate' => true])
            ->expectsOutputToContain('Next Steps')
            ->assertSuccessful();
    }
}
