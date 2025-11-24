<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class TestTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // seed the database
        $this->seed();
        // Artisan::call('db:seed');

        // Get Super Admin
        $user = User::whereId(1)->first();

        $this->actingAs($user);
    }

    /**
     * Backend Dashboard Test.
     *
     * ---------------------------------------------------------------
     */
    public function test_super_admin_user_can_view_backend(): void
    {
        $response = $this->get('/admin');
        $response->assertStatus(200);

        $response = $this->get('/admin/dashboard');
        $response->assertStatus(200);
    }

    public function test_super_admin_user_can_udpate_settings(): void
    {
        $fields_data = [];

        foreach (config('setting_fields') as $section => $fields) {
            foreach ($fields['elements'] as $field) {
                $name = $field['name'];
                $value = $field['value'];

                $fields_data[$name] = $value;
            }
        }

        $fields_data['app_name'] = 'Awesome Laravel Starter';

        $response = $this->postJson(route('backend.settings.store'), $fields_data);

        $response->assertStatus(302);

        // dump(setting('app_name'));
        // $response->assertSeeText('Awesome Laravel Starter');
        // $response->assertSeeText('Settings has been saved.');

        // $response->assertRedirect(route('backend.settings'));
        $response->assertRedirect(route('frontend.index'));

        // dump($response->getContent());
    }
}
