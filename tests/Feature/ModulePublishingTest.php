<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class ModulePublishingTest extends TestCase
{
    /**
     * Test that Post module config can be published
     */
    public function test_post_module_config_can_be_published(): void
    {
        $configPath = config_path('post.php');
        
        // Clean up if exists
        if (File::exists($configPath)) {
            File::delete($configPath);
        }
        
        // Publish config
        Artisan::call('vendor:publish', [
            '--tag' => 'post-config',
            '--force' => true,
        ]);
        
        // Assert config was published
        $this->assertFileExists($configPath);
        
        // Clean up
        if (File::exists($configPath)) {
            File::delete($configPath);
        }
    }
    
    /**
     * Test that Post module views can be published
     */
    public function test_post_module_views_can_be_published(): void
    {
        $viewPath = resource_path('views/vendor/post');
        
        // Clean up if exists
        if (File::isDirectory($viewPath)) {
            File::deleteDirectory($viewPath);
        }
        
        // Publish views
        Artisan::call('vendor:publish', [
            '--tag' => 'post-views',
            '--force' => true,
        ]);
        
        // Assert views were published
        $this->assertDirectoryExists($viewPath);
        
        // Clean up
        if (File::isDirectory($viewPath)) {
            File::deleteDirectory($viewPath);
        }
    }
    
    /**
     * Test that Category module config can be published
     */
    public function test_category_module_config_can_be_published(): void
    {
        $configPath = config_path('category.php');
        
        // Clean up if exists
        if (File::exists($configPath)) {
            File::delete($configPath);
        }
        
        // Publish config
        Artisan::call('vendor:publish', [
            '--tag' => 'category-config',
            '--force' => true,
        ]);
        
        // Assert config was published
        $this->assertFileExists($configPath);
        
        // Clean up
        if (File::exists($configPath)) {
            File::delete($configPath);
        }
    }
    
    /**
     * Test that Category module views can be published
     */
    public function test_category_module_views_can_be_published(): void
    {
        $viewPath = resource_path('views/vendor/category');
        
        // Clean up if exists
        if (File::isDirectory($viewPath)) {
            File::deleteDirectory($viewPath);
        }
        
        // Publish views
        Artisan::call('vendor:publish', [
            '--tag' => 'category-views',
            '--force' => true,
        ]);
        
        // Assert views were published
        $this->assertDirectoryExists($viewPath);
        
        // Clean up
        if (File::isDirectory($viewPath)) {
            File::deleteDirectory($viewPath);
        }
    }
    
    /**
     * Test that module:status command works
     */
    public function test_module_status_command_works(): void
    {
        $exitCode = Artisan::call('module:status');
        
        $this->assertEquals(0, $exitCode);
        
        $output = Artisan::output();
        $this->assertStringContainsString('Post', $output);
        $this->assertStringContainsString('Category', $output);
        $this->assertStringContainsString('Tag', $output);
        $this->assertStringContainsString('Menu', $output);
    }
    
    /**
     * Test that module config is merged correctly
     */
    public function test_module_config_merge_works(): void
    {
        // Post module config should be accessible
        $this->assertIsArray(config('post'));
        
        // Category module config should be accessible
        $this->assertIsArray(config('category'));
    }
    
    /**
     * Test that module views are loaded correctly
     */
    public function test_module_views_are_loaded(): void
    {
        // Post views should be accessible via namespace
        $this->assertTrue(view()->exists('post::backend.posts.index'));
        
        // Category views should be accessible via namespace
        $this->assertTrue(view()->exists('category::backend.categories.index'));
        
        // Tag views should be accessible via namespace
        $this->assertTrue(view()->exists('tag::backend.tags.index'));
        
        // Menu views should be accessible via namespace
        $this->assertTrue(view()->exists('menu::backend.menus.index'));
    }
    
    /**
     * Test that Tag module config can be published
     */
    public function test_tag_module_config_can_be_published(): void
    {
        $configPath = config_path('tag.php');
        
        // Clean up if exists
        if (File::exists($configPath)) {
            File::delete($configPath);
        }
        
        // Publish config
        Artisan::call('vendor:publish', [
            '--tag' => 'tag-config',
            '--force' => true,
        ]);
        
        // Assert config was published
        $this->assertFileExists($configPath);
        
        // Clean up
        if (File::exists($configPath)) {
            File::delete($configPath);
        }
    }
    
    /**
     * Test that Tag module views can be published
     */
    public function test_tag_module_views_can_be_published(): void
    {
        $viewPath = resource_path('views/vendor/tag');
        
        // Clean up if exists
        if (File::isDirectory($viewPath)) {
            File::deleteDirectory($viewPath);
        }
        
        // Publish views
        Artisan::call('vendor:publish', [
            '--tag' => 'tag-views',
            '--force' => true,
        ]);
        
        // Assert views were published
        $this->assertDirectoryExists($viewPath);
        
        // Clean up
        if (File::isDirectory($viewPath)) {
            File::deleteDirectory($viewPath);
        }
    }
    
    /**
     * Test that Menu module config can be published
     */
    public function test_menu_module_config_can_be_published(): void
    {
        $configPath = config_path('menu.php');
        
        // Clean up if exists
        if (File::exists($configPath)) {
            File::delete($configPath);
        }
        
        // Publish config
        Artisan::call('vendor:publish', [
            '--tag' => 'menu-config',
            '--force' => true,
        ]);
        
        // Assert config was published
        $this->assertFileExists($configPath);
        
        // Clean up
        if (File::exists($configPath)) {
            File::delete($configPath);
        }
    }
    
    /**
     * Test that Menu module views can be published
     */
    public function test_menu_module_views_can_be_published(): void
    {
        $viewPath = resource_path('views/vendor/menu');
        
        // Clean up if exists
        if (File::isDirectory($viewPath)) {
            File::deleteDirectory($viewPath);
        }
        
        // Publish views
        Artisan::call('vendor:publish', [
            '--tag' => 'menu-views',
            '--force' => true,
        ]);
        
        // Assert views were published
        $this->assertDirectoryExists($viewPath);
        
        // Clean up
        if (File::isDirectory($viewPath)) {
            File::deleteDirectory($viewPath);
        }
    }
    
    /**
     * Test all module configs are accessible
     */
    public function test_all_module_configs_are_accessible(): void
    {
        $this->assertIsArray(config('post'));
        $this->assertIsArray(config('category'));
        $this->assertIsArray(config('tag'));
        $this->assertIsArray(config('menu'));
    }

    /**
     * Test that module:check-migrations command works
     */
    public function test_module_check_migrations_command_works(): void
    {
        // Command should run without errors
        $exitCode = Artisan::call('module:check-migrations');

        $this->assertEquals(0, $exitCode);

        $output = Artisan::output();
        $this->assertStringContainsString('Checking for new migrations', $output);
    }
}
