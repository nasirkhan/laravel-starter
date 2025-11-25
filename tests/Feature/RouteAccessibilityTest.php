<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Modules\Category\Models\Category;
use Modules\Post\Models\Post;
use Modules\Tag\Models\Tag;
use Tests\TestCase;

class RouteAccessibilityTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that all registered GET routes are accessible.
     *
     * @return void
     */
    public function test_all_registered_get_routes_are_accessible()
    {
        $routes = Route::getRoutes();

        // Create a user for auth tests
        /** @var \App\Models\User $user */
        $user = User::factory()->create([
            'username' => 'testuser',
        ]);

        // Create role if it doesn't exist
        if (! \Spatie\Permission\Models\Role::where('name', 'super-admin')->exists()) {
            \Spatie\Permission\Models\Role::create(['name' => 'super-admin']);
        }

        $user->assignRole('super-admin'); // Ensure user has access to everything
        $user = $user->fresh();

        // Create necessary data for route parameters
        $category = Category::factory()->create(['slug' => 'test-category-slug']);
        $tag = Tag::factory()->create(['slug' => 'test-tag-slug']);
        $post = Post::factory()->create([
            'category_id' => $category->id,
            'slug' => 'test-post-slug',
            'name' => 'Test Post',
            'created_by_name' => 'Test User',
        ]);

        // Create a menu with nested items to test lazy loading fix
        $menu = \Modules\Menu\Models\Menu::factory()->create(['location' => 'backend-sidebar-1']);
        $parentItem = \Modules\Menu\Models\MenuItem::factory()->create(['menu_id' => $menu->id, 'name' => 'Parent']);
        $childItem = \Modules\Menu\Models\MenuItem::factory()->create(['menu_id' => $menu->id, 'parent_id' => $parentItem->id, 'name' => 'Child']);
        $grandChildItem = \Modules\Menu\Models\MenuItem::factory()->create(['menu_id' => $menu->id, 'parent_id' => $childItem->id, 'name' => 'Grandchild']);

        foreach ($routes as $route) {
            if (! in_array('GET', $route->methods())) {
                continue;
            }

            $uri = $route->uri();

            // Skip debugbar, ignition, sanctum, etc.
            if (
                str_contains($uri, '_debugbar') ||
                str_contains($uri, '_ignition') ||
                str_contains($uri, 'sanctum') ||
                str_contains($uri, 'livewire') ||
                str_contains($uri, 'filemanager') ||
                str_contains($uri, 'log-viewer') ||
                str_contains($uri, 'download') ||
                str_contains($uri, 'emailConfirmationResend')
            ) {
                continue;
            }

            // Handle parameterized routes
            if (str_contains($uri, '{')) {
                $uri = str_replace('{language}', 'en', $uri);

                // Module specific replacements
                if (str_contains($uri, 'posts')) {
                    $uri = str_replace('{id}', encode_id($post->id), $uri);
                    $uri = str_replace('{slug?}', $post->slug, $uri);
                } elseif (str_contains($uri, 'categories')) {
                    $uri = str_replace('{id}', encode_id($category->id), $uri);
                    $uri = str_replace('{slug?}', $category->slug, $uri);
                } elseif (str_contains($uri, 'tags')) {
                    $uri = str_replace('{id}', encode_id($tag->id), $uri);
                    $uri = str_replace('{slug?}', $tag->slug, $uri);
                } elseif (str_contains($uri, 'menus')) {
                    $uri = str_replace('{id}', $menu->id, $uri);
                    $uri = str_replace('{slug?}', 'dummy-slug', $uri);
                } elseif (str_contains($uri, 'menuitems')) {
                    $uri = str_replace('{id}', $parentItem->id, $uri);
                } else {
                    // Generic fallback
                    $uri = str_replace('{id}', $user->id, $uri);
                }

                // Common parameters
                $uri = str_replace('{slug?}', 'dummy-slug', $uri);
                $uri = str_replace('{username?}', $user->username, $uri);
                $uri = str_replace('{file_name}', 'dummy.txt', $uri);

                // If there are still parameters, skip to avoid 404s
                if (str_contains($uri, '{')) {
                    continue;
                }
            }

            try {
                $response = $this->actingAs($user)->get($uri);

                $status = $response->getStatusCode();

                // Assert status is not 404 (Not Found) and not 500 (Server Error)
                $this->assertNotEquals(404, $status, "Route {$uri} returned 404.");
                $this->assertNotEquals(500, $status, "Route {$uri} returned 500. Exception: ".$response->exception?->getMessage());

                // Specifically check for lazy loading violations if enabled in test environment
                if ($response->exception) {
                    $this->assertStringNotContainsString('LazyLoadingViolationException', $response->exception->getMessage(), "Route {$uri} caused LazyLoadingViolationException.");
                }
            } catch (\Exception $e) {
                dump("Route {$uri} failed: ".$e->getMessage());
                $this->fail("Route {$uri} threw exception: ".$e->getMessage());
            }
        }
    }
}
