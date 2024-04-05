<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
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
            $response = $this->post('/register', [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => 'password',
                'password_confirmation' => 'password',
            ]);

            $this->assertAuthenticated();
            $response->assertRedirect(route('home', absolute: false));
        } else {
            $response = $this->get('/register');
            $response->assertStatus(404);
        }
    }
}
