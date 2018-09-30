<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class LoginPageTest extends TestCase
{
    use DatabaseTransactions;

    // public function setUp()
    // {
    //     parent::setUp();
    //     \Artisan::call('migrate');
    //     \Artisan::call('db:seed');
    // }

    /**
     * The login form can be displayed.
     *
     * @test
     */
    public function visit_home_page()
    {
        $response = $this->get('/login');
        $response->assertSeeText(app_name());
        $response->assertSeeText('Login to Account');

        $response->assertStatus(200);
    }

    /**
     * A valid user can be logged in.
     *
     * @return void
     */
    public function testLoginAValidUser()
    {
        $user = User::find(1);

        $response = $this->post('/login', [
            'email'    => $user->email,
            'password' => $user->password,
        ]);

        $response->assertStatus(302);

        $response = $this->actingAs($user, 'web');
    }

    /** @test */
    public function admin_can_access_admin_dashboard()
    {
        $this->loginAsAdmin();
        $this->get('/admin/dashboard')->assertStatus(200);
    }

    // /**
    // * An invalid user cannot be logged in.
    // *
    // * @return void
    // */
    // public function testDoesNotLoginAnInvalidUser()
    // {
    //     $this->session();
    //     $user = factory(User::class)->create();
    //     $response = $this->post('/login', [
    //         'email' => $user->email,
    //         'password' => 'invalid'
    //     ]);
    //     $response->assertSessionHasErrors();
    //     $this->dontSeeIsAuthenticated();
    // }
    // /**
    // * A logged in user can be logged out.
    // *
    // * @return void
    // */
    // public function testLogoutAnAuthenticatedUser()
    // {
    //     $user = factory(User::class)->create();
    //     $response = $this->actingAs($user)->post('/logout');
    //     $response->assertStatus(302);
    //     $this->dontSeeIsAuthenticated();
    // }
}
