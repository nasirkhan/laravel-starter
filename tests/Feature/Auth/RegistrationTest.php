<?php

namespace Tests\Feature\Auth;

use App\Livewire\Auth\Register;
use App\Notifications\NewRegistrationNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        if (config('app.user_registration')) {
            $response->assertStatus(200);
        } else {
            $response->assertStatus(404);
        }
    }

    public function test_new_users_can_register(): void
    {
        if (config('app.user_registration')) {
            Notification::fake();

            $response = Livewire::test(Register::class)
                ->set('name', 'Test User')
                ->set('email', 'test@example.com')
                ->set('password', 'password')
                ->set('password_confirmation', 'password')
                ->call('register');

            $response
                ->assertHasNoErrors()
                ->assertRedirect(route('home', absolute: false));

            $this->assertAuthenticated();
            Notification::assertSentTo(auth()->user(), NewRegistrationNotification::class);
        } else {
            $response = $this->get('/register');
            $response->assertStatus(404);
        }
    }
}
