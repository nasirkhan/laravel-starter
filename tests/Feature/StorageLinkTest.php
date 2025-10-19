<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StorageLinkTest extends TestCase
{
    /**
     * Test that storage link exists and points to correct directory
     */
    public function test_storage_link_exists_and_is_correct(): void
    {
        $publicStoragePath = public_path('storage');
        $correctStorageTarget = storage_path('app/public');
        
        // Check that the storage symlink exists
        $this->assertTrue(is_link($publicStoragePath), 'Storage symlink should exist in public directory');
        
        // Check that it points to the correct location
        $actualTarget = readlink($publicStoragePath);
        $this->assertEquals($correctStorageTarget, $actualTarget, 
            "Storage symlink should point to {$correctStorageTarget} but points to {$actualTarget}");
        
        // Check that the target directory actually exists
        $this->assertTrue(is_dir($correctStorageTarget), 'Storage target directory should exist');
    }

    /**
     * Test that images can be accessed through the storage link
     */
    public function test_storage_link_allows_file_access(): void
    {
        $testFile = 'test-image.txt';
        $storagePath = storage_path('app/public/' . $testFile);
        $publicUrl = '/storage/' . $testFile;
        
        // Create a test file in storage
        file_put_contents($storagePath, 'test image content');
        
        try {
            // Test that the file is accessible through the public URL
            $response = $this->get($publicUrl);
            $response->assertStatus(200);
            $response->assertSee('test image content');
            
        } finally {
            // Clean up the test file
            if (file_exists($storagePath)) {
                unlink($storagePath);
            }
        }
    }
    
    /**
     * Test that the storage:link command works correctly
     */
    public function test_storage_link_command_works(): void
    {
        // Remove existing link if it exists
        $publicStoragePath = public_path('storage');
        if (file_exists($publicStoragePath)) {
            if (is_link($publicStoragePath)) {
                unlink($publicStoragePath);
            } else {
                rmdir($publicStoragePath);
            }
        }
        
        // Run the storage:link command
        $this->artisan('storage:link')
            ->assertExitCode(0)
            ->expectsOutput('The [' . $publicStoragePath . '] link has been connected to [' . storage_path('app/public') . '].');
            
        // Verify the link was created correctly
        $this->assertTrue(is_link($publicStoragePath), 'Storage symlink should be created');
        $this->assertEquals(storage_path('app/public'), readlink($publicStoragePath), 
            'Storage symlink should point to correct directory');
    }
}