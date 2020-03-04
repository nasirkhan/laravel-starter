<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class LoginPageTest extends TestCase
{
    use DatabaseMigrations;
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

        $response->assertSeeText('Login');

        $response->assertStatus(200);
    }

    /**
     * A valid user can be logged in.
     *
     * @return void
     */
    public function testLoginAValidUser()
    {
        $user = factory(User::class)->create();

        $response = $this->post('/login', [
            'email'    => $user->email,
            'password' => $user->password,
        ]);

        $response->assertStatus(302);

        $response = $this->actingAs($user, 'web');
    }

    /**
     * Remember Me Check.
     */
    public function test_remember_me_functionality()
    {
        $user = factory(User::class)->create();

        $response = $this->post('/login', [
            'email'    => $user->email,
            'password' => $user->password,
            'remember' => 'on',
        ]);

        $response->assertStatus(302);

        $this->be($user);
    }
}
