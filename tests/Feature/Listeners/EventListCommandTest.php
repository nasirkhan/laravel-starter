<?php

namespace Tests\Feature\Listeners;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventListCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_event_list_command_runs_successfully(): void
    {
        $this->artisan('event:list')
            ->assertExitCode(0);
    }
}
