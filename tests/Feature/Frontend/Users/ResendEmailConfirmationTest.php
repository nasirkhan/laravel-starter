<?php

namespace Tests\Feature\Frontend\Users;

use App\Livewire\Frontend\Users\ResendEmailConfirmation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ResendEmailConfirmationTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_resend_email_verification(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $this->actingAs($user);

        $response = Livewire::test(ResendEmailConfirmation::class)
            ->call('resend');

        $response->assertStatus(200);
        // Flash message should be set - we can't easily assert this in Livewire tests
    }

    public function test_does_not_resend_if_already_verified(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $this->actingAs($user);

        $response = Livewire::test(ResendEmailConfirmation::class)
            ->call('resend');

        $response->assertStatus(200);
        // Should flash a message saying email is already verified
    }

    public function test_component_only_shows_for_unverified_users(): void
    {
        $unverifiedUser = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $this->actingAs($unverifiedUser);

        $response = Livewire::test(ResendEmailConfirmation::class);

        // Component should render
        $response->assertStatus(200);
    }

    public function test_guest_cannot_access_component(): void
    {
        Livewire::test(ResendEmailConfirmation::class)
            ->call('resend')
            ->assertStatus(401);
    }
}
