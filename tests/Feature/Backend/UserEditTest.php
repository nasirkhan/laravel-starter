<?php

namespace Tests\Feature\Backend;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserEditTest extends TestCase
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
     * Test that user edit form loads correctly.
     */
    public function test_user_edit_form_loads_successfully(): void
    {
        $user = User::factory()->create();

        $response = $this->get(route('backend.users.edit', $user));

        $response->assertStatus(200);
        $response->assertSee($user->name);
        $response->assertSee($user->email);
    }

    /**
     * Test that the form has Cancel button outside the form.
     */
    public function test_edit_form_has_cancel_button_outside_form(): void
    {
        $user = User::factory()->create();

        $response = $this->get(route('backend.users.edit', $user));

        $content = $response->getContent();

        // Check that we have a proper form structure
        $this->assertStringContainsString('</form>', $content);
        $this->assertStringContainsString('Cancel', $content);

        // Find the position of the form closing
        $formClosePosition = strpos($content, '</form>');
        $this->assertNotFalse($formClosePosition, 'Form closing tag should exist');

        // Look for Cancel button after form close
        $contentAfterFormClose = substr($content, $formClosePosition);
        $this->assertStringContainsString('Cancel', $contentAfterFormClose, 'Cancel button should appear after form close');
    }

    /**
     * Test that form structure prevents accidental submissions.
     */
    public function test_form_structure_prevents_accidental_role_loss(): void
    {
        $user = User::factory()->create();
        $role = Role::create(['name' => 'important-role']);
        $user->assignRole($role);

        $response = $this->get(route('backend.users.edit', $user));
        $content = $response->getContent();

        // Verify the form structure is correct
        $this->assertStringContainsString('method="POST"', $content);
        $this->assertStringContainsString('</form>', $content);

        // The Cancel button should be outside the form to prevent accidental submission
        $formClosePos = strpos($content, '</form>');
        $cancelButtonPos = strpos($content, 'Cancel');

        $this->assertGreaterThan(
            $formClosePos,
            $cancelButtonPos,
            'Cancel button should appear after the form closes to prevent accidental form submission'
        );
    }
}
