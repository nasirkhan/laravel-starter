<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class LoginPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * The login form can be displayed.
     *
     * @test
     */
    public function visit_login_page()
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

    public function test_remember_me_functionality()
    {
        $user = factory(User::class)->create([
            'id'       => random_int(1, 100),
            'password' => bcrypt($password = 'bangladesh'),
        ]);

        $response = $this->post('/login', [
            'email'    => $user->email,
            'password' => $password,
            'remember' => 'on',
        ]);

        $response->assertStatus(302);

        // cookie assertion goes here
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function admin_can_access_admin_dashboard()
    {
        $this->loginAsAdmin();
        $this->get('/admin/dashboard')->assertStatus(200);
    }
}
