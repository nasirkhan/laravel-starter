<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BackendTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    /**
     * An Super Admin can access the admin dashboard.
     *
     * @test
     */
    public function super_admin_can_access_admin_dashboard()
    {
        $this->loginAsSuperAdmin();

        $response = $this->get('/admin/dashboard');

        $response->assertSeeText(app_name());

        $response->assertStatus(200);
    }

    /**
     * An Super Admin can access the Settings.
     *
     * @test
     */
    public function super_admin_can_access_settings()
    {
        $this->loginAsSuperAdmin();

        $response = $this->get('/admin/settings');

        $response->assertSeeText('Settings List');

        $response->assertStatus(200);
    }

    /**
     * An Super Admin can access the Backup.
     *
     * @test
     */
    public function super_admin_can_access_backups()
    {
        $this->loginAsSuperAdmin();

        $response = $this->get('/admin/backups');

        $response->assertSeeText('Backup List');

        $response->assertStatus(200);
    }

    /**
     * An Super Admin can access the users.
     *
     * @test
     */
    public function super_admin_can_access_users()
    {
        $this->loginAsSuperAdmin();

        $response = $this->get('/admin/users');

        $response->assertSeeText('Users List');

        $response->assertStatus(200);
    }

    /**
     * An Super Admin can access the Roles.
     *
     * @test
     */
    public function super_admin_can_access_roles()
    {
        $this->loginAsSuperAdmin();

        $response = $this->get('/admin/roles');

        $response->assertSeeText('Roles Data Table List');

        $response->assertStatus(200);
    }

    /**
     * An Super Admin can access the Log Viewer Dashboard.
     *
     * @test
     */
    public function super_admin_can_access_logs_dashboard()
    {
        $this->loginAsSuperAdmin();

        $response = $this->get('/admin/log-viewer');

        $response->assertSeeText('Log Viewer Dashboard');

        $response->assertStatus(200);
    }

    /**
     * An Super Admin can access the Log Viewer Dashboard logs.
     *
     * @test
     */
    public function super_admin_can_access_logs_list()
    {
        $this->loginAsSuperAdmin();

        $response = $this->get('/admin/log-viewer/logs');

        $response->assertSeeText('Log Viewer Dashboard');

        $response->assertStatus(200);
    }

    /**
     * An Super Admin can access the Notifications.
     *
     * @test
     */
    public function super_admin_can_access_notifications()
    {
        $this->loginAsSuperAdmin();

        $response = $this->get('/admin/notifications');

        $response->assertSeeText('Notifications Management Dashboard');

        $response->assertStatus(200);
    }
}
