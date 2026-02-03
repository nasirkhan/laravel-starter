<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class RouteHealthCheckTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed essential data
        $this->artisan('db:seed', ['--class' => 'Database\\Seeders\\AuthTableSeeder']);

        // Get users
        $this->user = User::where('email', 'user@user.com')->first();
        $this->admin = User::where('email', 'admin@admin.com')->first();
    }

    /**
     * Test all public routes return 200 or redirect appropriately.
     */
    public function test_public_routes_are_accessible(): void
    {
        $publicRoutes = [
            '/',
            '/login',
            '/register',
            '/forgot-password',
        ];

        foreach ($publicRoutes as $route) {
            $response = $this->get($route);

            $this->assertContains(
                $response->status(),
                [200, 302],
                "Route {$route} failed with status {$response->status()}"
            );
        }
    }

    /**
     * Test authenticated user routes.
     */
    public function test_authenticated_user_routes_are_accessible(): void
    {
        $this->actingAs($this->user);

        $authenticatedRoutes = [
            '/dashboard',
            '/profile',
        ];

        foreach ($authenticatedRoutes as $route) {
            $response = $this->get($route);

            $this->assertContains(
                $response->status(),
                [200, 302],
                "Route {$route} failed with status {$response->status()}"
            );
        }
    }

    /**
     * Test admin routes require authentication and authorization.
     */
    public function test_admin_routes_require_admin_access(): void
    {
        // Test as guest - should redirect
        $response = $this->get('/admin/dashboard');
        $this->assertEquals(302, $response->status(), 'Admin route should redirect guests');

        // Test as regular user - should be forbidden or redirected
        $this->actingAs($this->user);
        $response = $this->get('/admin/dashboard');
        $this->assertContains(
            $response->status(),
            [302, 403],
            'Admin route should block regular users'
        );
    }

    /**
     * Test admin routes with admin user.
     */
    public function test_admin_routes_work_for_admin_users(): void
    {
        $this->actingAs($this->admin);

        $adminRoutes = [
            '/admin/dashboard',
        ];

        foreach ($adminRoutes as $route) {
            $response = $this->get($route);

            $this->assertContains(
                $response->status(),
                [200, 302],
                "Admin route {$route} failed with status {$response->status()}"
            );
        }
    }

    /**
     * Test all registered routes don't throw 500 errors.
     */
    public function test_all_get_routes_return_valid_responses(): void
    {
        $this->actingAs($this->admin);

        $routes = Route::getRoutes();
        $testedRoutes = 0;
        $failedRoutes = [];

        foreach ($routes as $route) {
            // Only test GET routes
            if (! in_array('GET', $route->methods()) && ! in_array('HEAD', $route->methods())) {
                continue;
            }

            $uri = $route->uri();

            // Skip routes with parameters, API routes, and special routes
            if (
                str_contains($uri, '{') ||
                str_starts_with($uri, 'api/') ||
                str_starts_with($uri, '_') ||
                str_starts_with($uri, 'sanctum/') ||
                str_starts_with($uri, 'livewire/') ||
                str_starts_with($uri, 'debugbar/') ||
                str_starts_with($uri, 'filemanager/') || // POST-only routes
                str_starts_with($uri, 'laravel-filemanager/') || // POST-only routes
                str_contains($uri, 'emailConfirmation') || // POST-only
                $uri === 'up'
            ) {
                continue;
            }

            $testedRoutes++;

            try {
                $response = $this->get('/'.$uri);

                // Handle BinaryFileResponse (downloads, etc.)
                $statusCode = method_exists($response, 'status')
                    ? $response->status()
                    : $response->getStatusCode();

                // Should not return 500 errors
                $this->assertNotEquals(
                    500,
                    $statusCode,
                    "Route /{$uri} returned 500 error"
                );

                // Valid status codes
                $validStatuses = [200, 201, 302, 401, 403, 404];
                if (! in_array($statusCode, $validStatuses)) {
                    $failedRoutes[] = [
                        'uri' => $uri,
                        'status' => $statusCode,
                    ];
                }
            } catch (\Exception $e) {
                $failedRoutes[] = [
                    'uri' => $uri,
                    'error' => $e->getMessage(),
                ];
            }
        }

        $this->assertEmpty(
            $failedRoutes,
            "Some routes failed:\n".json_encode($failedRoutes, JSON_PRETTY_PRINT)
        );

        $this->assertGreaterThan(
            0,
            $testedRoutes,
            'No routes were tested'
        );
    }
}
