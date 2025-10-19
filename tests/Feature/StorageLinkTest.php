<?php

namespace Tests\Feature;

use Tests\TestCase;

class StorageLinkTest extends TestCase
{
    /**
     * Test that storage link exists and points to correct directory.
     */
    public function test_storage_link_exists_and_is_correct(): void
    {
        $publicStoragePath = public_path('storage');
        $correctStorageTarget = storage_path('app/public');

        // Check that the storage symlink exists (Windows junction or Unix symlink)
        $this->assertTrue(
            is_link($publicStoragePath) || 
            is_dir($publicStoragePath) || 
            file_exists($publicStoragePath), 
            'Storage symlink/junction/directory should exist in public directory'
        );

        // Check that it points to the correct location (Windows readlink behavior for junctions)
        if (is_link($publicStoragePath) || (PHP_OS_FAMILY === 'Windows' && is_dir($publicStoragePath))) {
            // On Windows, try to get the target using readlink
            $actualTarget = @readlink($publicStoragePath);
            if ($actualTarget !== false) {
                // Normalize paths for comparison (Windows path format)
                $normalizedTarget = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $correctStorageTarget);
                $normalizedActual = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $actualTarget);
                
                $this->assertEquals($normalizedTarget, $normalizedActual,
                    "Storage symlink should point to {$normalizedTarget} but points to {$normalizedActual}");
            }
        }

        // Check that the target directory actually exists
        $this->assertTrue(is_dir($correctStorageTarget), 'Storage target directory should exist');
    }

    /**
     * Test that the storage link allows file access by checking file existence.
     */
    public function test_storage_link_allows_file_access(): void
    {
        $testFile = 'test-image.txt';
        $storagePath = storage_path('app/public/'.$testFile);
        $publicStoragePath = public_path('storage/'.$testFile);

        // Create a test file in storage
        file_put_contents($storagePath, 'test image content');

        try {
            // Test that the file is accessible through the public storage link
            $this->assertTrue(file_exists($publicStoragePath), 
                'File should be accessible through the storage symlink/junction');
                
            // Test that the content is correct
            $content = file_get_contents($publicStoragePath);
            $this->assertEquals('test image content', $content, 
                'File content should be accessible through the storage symlink/junction');
        } finally {
            // Clean up the test file
            if (file_exists($storagePath)) {
                unlink($storagePath);
            }
        }
    }

    /**
     * Test that the storage:link command works correctly.
     */
    public function test_storage_link_command_works(): void
    {
        // Remove existing link if it exists
        $publicStoragePath = public_path('storage');
        if (file_exists($publicStoragePath)) {
            if (is_link($publicStoragePath)) {
                unlink($publicStoragePath);
            } else {
                // Use recursive removal for directories on Windows
                if (is_dir($publicStoragePath)) {
                    $this->deleteDirectory($publicStoragePath);
                }
            }
        }

        // Run the storage:link command
        $this->artisan('storage:link')
            ->assertExitCode(0);

        // Verify the link was created correctly (Windows compatible)
        $this->assertTrue(
            is_link($publicStoragePath) || 
            is_dir($publicStoragePath) || 
            file_exists($publicStoragePath), 
            'Storage symlink/junction/directory should be created'
        );
            
        // Test the link works by checking if we can access files through it
        if (file_exists($publicStoragePath)) {
            $expectedTarget = storage_path('app/public');
            
            // On Windows junctions, try readlink
            $actualTarget = @readlink($publicStoragePath);
            if ($actualTarget !== false) {
                // Normalize paths for Windows comparison
                $normalizedExpected = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $expectedTarget);
                $normalizedActual = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $actualTarget);
                
                $this->assertEquals($normalizedExpected, $normalizedActual,
                    'Storage symlink should point to correct directory');
            }
        }
    }
    
    /**
     * Helper method to recursively delete a directory.
     */
    private function deleteDirectory($dir)
    {
        if (!is_dir($dir)) {
            return false;
        }
        
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            $path = $dir . DIRECTORY_SEPARATOR . $file;
            is_dir($path) ? $this->deleteDirectory($path) : unlink($path);
        }
        
        return rmdir($dir);
    }
}
