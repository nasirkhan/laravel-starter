<?php

namespace Tests\Feature\Frontend\Users;

use App\Livewire\Frontend\Users\UnlinkProvider;
use App\Models\User;
use App\Models\UserProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class UnlinkProviderTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_unlink_their_own_provider(): void
    {
        $user = User::factory()->create();
        $provider = UserProvider::factory()->create([
            'user_id' => $user->id,
            'provider' => 'github',
        ]);

        $this->actingAs($user);

        Livewire::test(UnlinkProvider::class, ['userProviderId' => $provider->id])
            ->call('unlink')
            ->assertDispatched('provider-unlinked');

        $this->assertDatabaseMissing('user_providers', [
            'id' => $provider->id,
        ]);
    }

    public function test_user_cannot_unlink_another_users_provider(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $provider = UserProvider::factory()->create([
            'user_id' => $otherUser->id,
            'provider' => 'github',
        ]);

        $this->actingAs($user);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('There was a problem updating this user');

        Livewire::test(UnlinkProvider::class, ['userProviderId' => $provider->id])
            ->call('unlink');

        // Provider should still exist
        $this->assertDatabaseHas('user_providers', [
            'id' => $provider->id,
        ]);
    }

    public function test_guest_cannot_unlink_provider(): void
    {
        $user = User::factory()->create();
        $provider = UserProvider::factory()->create([
            'user_id' => $user->id,
            'provider' => 'github',
        ]);

        Livewire::test(UnlinkProvider::class, ['userProviderId' => $provider->id])
            ->call('unlink')
            ->assertStatus(401);
    }

    public function test_component_displays_provider_name(): void
    {
        $user = User::factory()->create();
        $provider = UserProvider::factory()->create([
            'user_id' => $user->id,
            'provider' => 'google',
        ]);

        $this->actingAs($user);

        Livewire::test(UnlinkProvider::class, ['userProviderId' => $provider->id])
            ->assertSet('providerName', 'google');
    }
}
