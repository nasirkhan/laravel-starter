<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Menu\Models\Menu;
use Modules\Menu\Models\MenuItem;
use Tests\TestCase;

class MenuDeletionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed the database
        $this->artisan('db:seed', ['--class' => 'Database\Seeders\AuthTableSeeder']);
    }

    /**
     * Test that a menu with items cannot be deleted.
     */
    public function test_cannot_delete_menu_with_items(): void
    {
        // Authenticate as super admin
        $user = User::find(1);
        $this->actingAs($user);

        // Create a menu
        $menu = Menu::factory()->create([
            'name' => 'Test Menu',
            'location' => 'test-location',
        ]);

        // Add menu items to the menu
        MenuItem::factory()->count(3)->create([
            'menu_id' => $menu->id,
        ]);

        // Attempt to delete the menu
        $response = $this->withSession([])->delete(route('backend.menus.destroy', $menu->id));

        // Assert redirect to menus index
        $response->assertRedirect(route('backend.menus.index'));

        // Assert the menu still exists
        $this->assertDatabaseHas('menus', [
            'id' => $menu->id,
            'name' => 'Test Menu',
        ]);

        // Assert menu items still exist
        $this->assertEquals(3, MenuItem::where('menu_id', $menu->id)->count());

        // Assert flash message about menu items
        $response->assertSessionHas('flash_notification');
    }

    /**
     * Test that a menu without items can be deleted.
     */
    public function test_can_delete_menu_without_items(): void
    {
        // Authenticate as super admin
        $user = User::find(1);
        $this->actingAs($user);

        // Create a menu without items
        $menu = Menu::factory()->create([
            'name' => 'Empty Test Menu',
            'location' => 'empty-location',
        ]);

        // Confirm no menu items exist
        $this->assertEquals(0, $menu->allItems()->count());

        // Delete the menu
        $response = $this->withSession([])->delete(route('backend.menus.destroy', $menu->id));

        // Assert redirect to menus index
        $response->assertRedirect(route('backend.menus.index'));

        // Assert the menu was soft deleted
        $this->assertSoftDeleted('menus', [
            'id' => $menu->id,
        ]);

        // Assert success flash message
        $response->assertSessionHas('flash_notification');
    }

    /**
     * Test that deleting all menu items allows menu deletion.
     */
    public function test_can_delete_menu_after_removing_all_items(): void
    {
        // Authenticate as super admin
        $user = User::find(1);
        $this->actingAs($user);

        // Create a menu with items
        $menu = Menu::factory()->create([
            'name' => 'Menu With Items',
            'location' => 'test-location',
        ]);

        // Add menu items
        $items = MenuItem::factory()->count(2)->create([
            'menu_id' => $menu->id,
        ]);

        // Try to delete menu - should fail
        $response = $this->withSession([])->delete(route('backend.menus.destroy', $menu->id));
        $response->assertRedirect(route('backend.menus.index'));
        $this->assertDatabaseHas('menus', ['id' => $menu->id]);

        // Delete all menu items
        foreach ($items as $item) {
            $item->delete();
        }

        // Now try to delete menu again - should succeed
        $response = $this->withSession([])->delete(route('backend.menus.destroy', $menu->id));
        $response->assertRedirect(route('backend.menus.index'));

        // Assert the menu was soft deleted
        $this->assertSoftDeleted('menus', [
            'id' => $menu->id,
        ]);
    }
}
