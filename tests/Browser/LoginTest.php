<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Builders\UserBuilder;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test user can view login page.
     */
    public function test_user_can_view_login_page(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->assertSee('Log in to your account')
                ->assertSee('Email Address')
                ->assertSee('Password')
                ->assertSee('Log in');
        });
    }

    /**
     * Test user can login with valid credentials.
     */
    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = UserBuilder::make()
            ->withEmail('test@example.com')
            ->withPassword('password')
            ->verified()
            ->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Log in')
                ->waitForLocation('/dashboard', 10)
                ->assertPathIs('/dashboard')
                ->assertAuthenticated();
        });
    }

    /**
     * Test user cannot login with invalid credentials.
     */
    public function test_user_cannot_login_with_invalid_credentials(): void
    {
        $user = UserBuilder::make()
            ->withEmail('test@example.com')
            ->verified()
            ->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'wrong-password')
                ->press('Log in')
                ->waitForText('These credentials do not match our records', 5)
                ->assertPathIs('/login')
                ->assertGuest();
        });
    }

    /**
     * Test remember me functionality.
     */
    public function test_remember_me_functionality(): void
    {
        $user = UserBuilder::make()
            ->withEmail('test@example.com')
            ->withPassword('password')
            ->verified()
            ->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->check('remember')
                ->press('Log in')
                ->waitForLocation('/dashboard', 10)
                ->assertPathIs('/dashboard');

            // Check if remember me cookie is set
            $browser->assertHasCookie('remember_web_'.sha1(User::class));
        });
    }

    /**
     * Test user can logout.
     */
    public function test_user_can_logout(): void
    {
        $user = UserBuilder::make()
            ->verified()
            ->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/dashboard')
                ->assertAuthenticated()
                ->clickLink('Logout')
                ->waitForLocation('/', 10)
                ->assertGuest();
        });
    }

    /**
     * Test validation errors are displayed.
     */
    public function test_validation_errors_are_displayed(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->press('Log in')
                ->waitForText('The email field is required', 5)
                ->assertSee('The email field is required')
                ->assertSee('The password field is required');
        });
    }
}
