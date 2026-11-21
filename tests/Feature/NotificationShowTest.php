<?php

namespace Tests\Feature;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class NotificationShowTest extends TestCase
{
    use RefreshDatabase;

    private User $superAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed the database to get proper permissions and roles
        $this->seed();

        // Get the super admin user (ID 1) from seeders
        $this->superAdmin = User::whereId(1)->first();

        $this->actingAs($this->superAdmin);
    }

    /**
     * A notification whose data JSON is missing the expected keys (e.g. legacy
     * rows or rows created by other packages) must still render without a 500.
     */
    public function test_show_renders_notification_with_missing_data_keys(): void
    {
        $id = (string) Str::uuid();

        Notification::forceCreate([
            'id' => $id,
            'type' => 'App\\Notifications\\LegacyNotification',
            'notifiable_type' => User::class,
            'notifiable_id' => $this->superAdmin->id,
            // Deliberately missing title / text / url_backend / url_frontend
            'data' => json_encode(['foo' => 'bar']),
        ]);

        $response = $this->get(route('backend.notifications.show', $id));

        $response->assertStatus(200);
    }

    /**
     * A well-formed notification keeps rendering its values unchanged.
     */
    public function test_show_renders_notification_with_complete_data(): void
    {
        $id = (string) Str::uuid();

        Notification::forceCreate([
            'id' => $id,
            'type' => 'App\\Notifications\\CompleteNotification',
            'notifiable_type' => User::class,
            'notifiable_id' => $this->superAdmin->id,
            'data' => json_encode([
                'title' => 'Hello World',
                'text' => 'Some body text',
                'url_backend' => '',
                'url_frontend' => '',
            ]),
        ]);

        $response = $this->get(route('backend.notifications.show', $id));

        $response->assertStatus(200);
        $response->assertSee('Hello World');
        $response->assertSee('Some body text');
    }
}
