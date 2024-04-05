<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FrontendPublicViewTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_public_view(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $value = app_name();

        $response->assertSeeText($value, $escxaped = true);
    }

    public function test_login_page_public_view(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);

        $value = __('Log in');

        $response->assertSeeText($value, $escxaped = true);
    }

    public function test_registration_page_public_view(): void
    {
        $response = $this->get('/register');

        if (config('app.user_registration')) {
            $response->assertStatus(200);

            $value = 'Register';

            $response->assertSeeText($value, $escxaped = true);
        } else {
            $response->assertStatus(404);
        }
    }

    public function test_forget_password_page_public_view(): void
    {
        $response = $this->get('/forgot-password');

        $response->assertStatus(200);

        $value = 'Email Password Reset Link';

        $response->assertSeeText($value, $escxaped = true);
    }

    public function test_privacy_policy_page_public_view(): void
    {
        $response = $this->get('/privacy');

        $response->assertStatus(200);

        $value = 'Privacy Policy';

        $response->assertSeeText($value, $escxaped = true);
    }

    public function test_terms_page_public_view(): void
    {
        $response = $this->get('/terms');

        $response->assertStatus(200);

        $value = 'Terms and Conditions ';

        $response->assertSeeText($value, $escxaped = true);
    }
}
