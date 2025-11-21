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

        // Create a user for auth tests, ensuring username is set for profile routes
        /** @var \App\Models\User $user */
        $user = User::factory()->create([
            'username' => 'testuser',
        ]);
        $user = $user->fresh();

        // Create a category and post for post routes
        $category = Category::factory()->create([
            'slug' => 'test-category-slug',
        ]);
        $tag = Tag::factory()->create([
            'slug' => 'test-tag-slug',
        ]);
        $post = Post::factory()->create([
            'category_id' => $category->id,
            'slug' => 'test-post-slug',
            'name' => 'Test Post',
            'created_by_name' => 'Test User',
        ]);

        foreach ($routes as $route) {
            if (! in_array('GET', $route->methods())) {
                continue;
            }

            $uri = $route->uri();

            // Skip debugbar routes if present
            if (str_contains($uri, '_debugbar')) {
                continue;
            }

            // Skip ignition routes if present
            if (str_contains($uri, '_ignition')) {
                continue;
            }

            // Skip sanctum routes
            if (str_contains($uri, 'sanctum')) {
                continue;
            }

            // Skip livewire routes (often internal or POST)
            if (str_contains($uri, 'livewire')) {
                continue;
            }

            // Skip filemanager routes (known to cause issues/require specific setup)
            if (str_contains($uri, 'filemanager')) {
                continue;
            }

            // Skip download routes (return binary response)
            if (str_contains($uri, 'download')) {
                continue;
            }

            // Skip email confirmation resend route (throttled)
            if (str_contains($uri, 'emailConfirmationResend')) {
                continue;
            }

            // Handle parameterized routes
            if (str_contains($uri, '{')) {
                $uri = str_replace('{language}', 'en', $uri);

                if (str_contains($uri, 'posts')) {
                    $uri = str_replace('{id}', encode_id($post->id), $uri);
                    $uri = str_replace('{slug?}', $post->slug, $uri);
                } elseif (str_contains($uri, 'categories')) {
                    $uri = str_replace('{id}', encode_id($category->id), $uri);
                    $uri = str_replace('{slug?}', $category->slug, $uri);
                } elseif (str_contains($uri, 'tags')) {
                    $uri = str_replace('{id}', encode_id($tag->id), $uri);
                    $uri = str_replace('{slug?}', $tag->slug, $uri);
                } else {
                    $uri = str_replace('{id}', $user->id, $uri);
                }

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

                if ($status === 500) {
                    $exception = $response->exception ? $response->exception->getMessage() : 'Unknown error';
                    echo "\nFAILED ROUTE (500): {$uri} - {$exception}\n";
                } elseif ($status === 404) {
                    echo "\nFAILED ROUTE (404): {$uri}\n";
                }

                // Assert status is not 404 (Not Found) and not 500 (Server Error)
                $this->assertNotEquals(404, $status, "Route {$uri} returned 404.");
                $this->assertNotEquals(500, $status, "Route {$uri} returned 500.");
            } catch (\Exception $e) {
                echo "\nEXCEPTION ON ROUTE: {$uri} - ".$e->getMessage()."\n";
                $this->fail("Route {$uri} threw exception: ".$e->getMessage());
            }
        }
    }
}
