<?php

namespace Tests\Feature\Backend;

use App\Models\Permission;
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
        
        // Create necessary permissions
        $editUsersPermission = Permission::firstOrCreate(['name' => 'edit_users']);
        $editUsersPermissionsPermission = Permission::firstOrCreate(['name' => 'edit_users_permissions']);
        
        // Create the super admin role if it doesn't exist (super admin has all permissions)
        $superAdminRole = Role::firstOrCreate(['name' => 'super admin']);
        $superAdminRole->givePermissionTo([$editUsersPermission, $editUsersPermissionsPermission]);
        
        // Create a super admin user to perform the tests
        $this->superAdmin = User::factory()->create();
        $this->superAdmin->assignRole($superAdminRole);
        
        // Double check: Give permissions directly to the user as well (in case role doesn't inherit properly)
        $this->superAdmin->givePermissionTo([$editUsersPermission, $editUsersPermissionsPermission]);
        
        $this->actingAs($this->superAdmin);
    }

    /**
     * Test that user edit form loads correctly
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
     * Test that the form has two Cancel buttons but only one outside the form
     */
    public function test_edit_form_has_cancel_button_outside_form(): void
    {
        $user = User::factory()->create();
        
        $response = $this->get(route('backend.users.edit', $user));
        
        $content = $response->getContent();
        
        // Check that the Cancel button appears after the form closing tag
        $this->assertStringContainsString('html()->closeModelForm()', $content);
        
        // Find the position of the form closing
        $formClosePosition = strpos($content, 'html()->closeModelForm()');
        $this->assertNotFalse($formClosePosition, 'Form closing tag should exist');
        
        // Look for Cancel button after form close
        $contentAfterFormClose = substr($content, $formClosePosition);
        $this->assertStringContainsString('Cancel', $contentAfterFormClose, 'Cancel button should appear after form close');
    }

    /**
     * Test that users don't lose roles when updating profile
     */
    public function test_user_roles_preserved_on_profile_update(): void
    {
        // Create a test role
        $role = Role::create(['name' => 'test-role']);
        
        // Create a user with the role
        $user = User::factory()->create();
        $user->assignRole($role);
        
        $this->assertTrue($user->hasRole('test-role'), 'User should have the test role initially');
        
        // Simulate updating the user profile (without changing roles)
        $response = $this->patch(route('backend.users.update', $user), [
            'first_name' => 'Updated',
            'last_name' => 'Name',
            'email' => $user->email,
            'roles' => ['test-role'], // Explicitly include the role
        ]);
        
        // Check that the update was successful
        $response->assertRedirect();
        
        // Refresh the user and check roles are preserved
        $user->refresh();
        $this->assertTrue($user->hasRole('test-role'), 'User should still have the test role after update');
    }

    /**
     * Test that updating profile without roles parameter doesn't remove existing roles
     */
    public function test_user_roles_preserved_when_roles_not_in_request(): void
    {
        // Create a test role
        $role = Role::create(['name' => 'preserved-role']);
        
        // Create a user with the role
        $user = User::factory()->create();
        $user->assignRole($role);
        
        $this->assertTrue($user->hasRole('preserved-role'), 'User should have the role initially');
        
        // Simulate updating the user profile WITHOUT roles in the request
        // This simulates what would happen if the Cancel button accidentally submits the form
        $response = $this->patch(route('backend.users.update', $user), [
            'first_name' => 'Updated',
            'last_name' => 'Name', 
            'email' => $user->email,
            // Note: No 'roles' parameter - this should not remove existing roles
        ]);
        
        // The update might redirect or have validation errors, but roles should be preserved
        // Refresh the user and check roles are still there
        $user->refresh();
        $this->assertTrue($user->hasRole('preserved-role'), 'User should still have the role even when roles not in request');
    }

    /**
     * Test that form structure prevents accidental submissions
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
        $this->assertStringContainsString('html()->closeModelForm()', $content);
        
        // The Cancel button should be outside the form to prevent accidental submission
        $formClosePos = strpos($content, 'html()->closeModelForm()');
        $cancelButtonPos = strpos($content, 'Cancel');
        
        $this->assertGreaterThan($formClosePos, $cancelButtonPos, 
            'Cancel button should appear after the form closes to prevent accidental form submission');
    }
}
