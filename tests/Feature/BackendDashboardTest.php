<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BackendDashboardTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;
    /**
     * An admin can access the admin dashboard.
     *
     * @test
     */
    public function admin_can_access_admin_dashboard()
    {
        $this->loginAsSuperAdmin();

        $response = $this->get('/admin/dashboard');

        $response->assertSeeText(app_name());

        $response->assertStatus(200);
    }
}
