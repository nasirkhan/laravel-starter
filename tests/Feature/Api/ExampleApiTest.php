<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Builders\UserBuilder;
use Tests\TestCase;

/**
 * API Testing Examples
 *
 * These tests demonstrate best practices for testing REST APIs:
 * - Authentication testing
 * - CRUD operations
 * - Validation testing
 * - Response structure assertions
 * - Error handling
 */
class ExampleApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that API returns proper JSON structure
     */
    public function test_api_returns_json_response(): void
    {
        $response = $this->getJson('/api/health-check');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'timestamp',
            ])
            ->assertJson([
                'status' => 'ok',
            ]);
    }

    /**
     * Test API authentication with Sanctum token
     */
    public function test_api_requires_authentication(): void
    {
        // Without authentication
        $response = $this->getJson('/api/user');

        $response->assertStatus(401);
    }

    public function test_authenticated_user_can_access_api(): void
    {
        $user = UserBuilder::make()->create();

        // Create API token
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
            'Accept' => 'application/json',
        ])->getJson('/api/user');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'name',
                'email',
            ]);
    }

    /**
     * Test paginated API response
     */
    public function test_api_returns_paginated_results(): void
    {
        // Create test data
        UserBuilder::make()->count(25);

        $user = UserBuilder::make()->asAdmin()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->getJson('/api/users?page=1&per_page=10');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'email'],
                ],
                'meta' => [
                    'current_page',
                    'total',
                    'per_page',
                ],
                'links' => [
                    'first',
                    'last',
                    'prev',
                    'next',
                ],
            ])
            ->assertJsonPath('meta.per_page', 10);
    }

    /**
     * Test API validation errors
     */
    public function test_api_returns_validation_errors(): void
    {
        $user = UserBuilder::make()->asAdmin()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->postJson('/api/users', [
            'name' => '', // Empty name should fail
            'email' => 'invalid-email', // Invalid email format
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email'])
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'name',
                    'email',
                ],
            ]);
    }

    /**
     * Test CRUD operations through API
     */
    public function test_api_can_create_resource(): void
    {
        $user = UserBuilder::make()->asAdmin()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $data = [
            'name' => 'Test Resource',
            'description' => 'Test Description',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->postJson('/api/resources', $data);

        $response
            ->assertStatus(201)
            ->assertJsonPath('data.name', 'Test Resource')
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'description',
                    'created_at',
                ],
            ]);
    }

    public function test_api_can_update_resource(): void
    {
        $user = UserBuilder::make()->asAdmin()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        // Create a resource first
        $resource = $this->createTestResource();

        $updateData = [
            'name' => 'Updated Name',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->putJson("/api/resources/{$resource->id}", $updateData);

        $response
            ->assertStatus(200)
            ->assertJsonPath('data.name', 'Updated Name');
    }

    public function test_api_can_delete_resource(): void
    {
        $user = UserBuilder::make()->asAdmin()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $resource = $this->createTestResource();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->deleteJson("/api/resources/{$resource->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('resources', [
            'id' => $resource->id,
        ]);
    }

    /**
     * Test API rate limiting
     */
    public function test_api_has_rate_limiting(): void
    {
        $user = UserBuilder::make()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $headers = [
            'Authorization' => 'Bearer '.$token,
        ];

        // Make multiple requests to trigger rate limit
        for ($i = 0; $i < 61; $i++) {
            $response = $this->withHeaders($headers)->getJson('/api/user');
        }

        // The 61st request should be rate limited
        $response->assertStatus(429);
    }

    /**
     * Test API error handling
     */
    public function test_api_handles_not_found_errors(): void
    {
        $user = UserBuilder::make()->asAdmin()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->getJson('/api/resources/99999');

        $response
            ->assertStatus(404)
            ->assertJsonStructure([
                'message',
            ]);
    }

    /**
     * Test API versioning
     */
    public function test_api_supports_versioning(): void
    {
        $response = $this->getJson('/api/v1/version');

        $response
            ->assertStatus(200)
            ->assertJson([
                'version' => 'v1',
                'deprecated' => false,
            ]);
    }

    /**
     * Helper method to create test resource
     */
    private function createTestResource()
    {
        // This is a placeholder - replace with your actual resource creation
        return (object) [
            'id' => 1,
            'name' => 'Test Resource',
        ];
    }
}
