<?php

namespace Tests\Feature\Auth;

use App\Livewire\Auth\Register;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
        } else {
            $response = $this->get('/register');
            $response->assertStatus(404);
        }
    }
}
