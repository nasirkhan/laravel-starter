<?php

namespace Tests\Feature\Modules;

use Illuminate\Support\Facades\File;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * Smoke tests confirming that all 8 modules load correctly from the
 * nasirkhan/module-manager vendor package in a clean install.
 *
 * ModuleManagerServiceProvider::registerModules() reads modules_statuses.json
 * on every boot and registers whichever ServiceProvider it finds — preferring a
 * published local copy (Modules\*) over the vendor copy.
 */
class ModuleLoadingTest extends TestCase
{
    /** The canonical list of modules that ship with the package. */
    private const MODULES = [
        'Backup',
        'Category',
        'FileManager',
        'LogViewer',
        'Menu',
        'Post',
        'Settings',
        'Tag',
    ];

    /**
     * modules_statuses.json must exist in the application root and list all 8
     * modules with a boolean true value so they are loaded on boot.
     */
    public function test_modules_statuses_json_exists_and_is_correct(): void
    {
        $path = base_path('modules_statuses.json');

        $this->assertFileExists($path, 'modules_statuses.json must exist in the application root');

        $statuses = json_decode(File::get($path), true);

        $this->assertIsArray($statuses, 'modules_statuses.json must decode to an array');

        foreach (self::MODULES as $module) {
            $this->assertArrayHasKey($module, $statuses, "modules_statuses.json must contain an entry for the {$module} module");
            $this->assertTrue($statuses[$module], "The {$module} module must be enabled (true) in modules_statuses.json");
        }
    }

    /**
     * Each of the 8 vendor ServiceProvider classes must exist on disk so that
     * registerModules() can resolve and boot them.
     */
    #[DataProvider('moduleProvider')]
    public function test_vendor_service_provider_class_exists(string $module): void
    {
        $class = "Nasirkhan\\ModuleManager\\Modules\\{$module}\\Providers\\{$module}ServiceProvider";

        $this->assertTrue(
            class_exists($class),
            "Vendor ServiceProvider {$class} must exist for the {$module} module"
        );
    }

    /**
     * After the application boots, the ServiceProvider for each module must have
     * been registered.  We verify this by checking that the provider class is
     * present in the collection the application tracks.
     */
    #[DataProvider('moduleProvider')]
    public function test_module_service_provider_is_registered_after_boot(string $module): void
    {
        // Prefer published provider, fall back to vendor provider
        $publishedClass = "Modules\\{$module}\\Providers\\{$module}ServiceProvider";
        $vendorClass = "Nasirkhan\\ModuleManager\\Modules\\{$module}\\Providers\\{$module}ServiceProvider";

        $expectedClass = class_exists($publishedClass) ? $publishedClass : $vendorClass;

        $loadedProviderKeys = array_keys($this->app->getLoadedProviders());

        $this->assertContains(
            $expectedClass,
            $loadedProviderKeys,
            "ServiceProvider {$expectedClass} must be registered for the {$module} module"
        );
    }

    /**
     * When a module is disabled in modules_statuses.json its ServiceProvider
     * must NOT be registered in the application container.
     */
    public function test_disabled_module_service_provider_is_not_registered(): void
    {
        // Re-run registerModules() against a temporary status file with Post=false
        $tempFile = base_path('modules_statuses_test_temp.json');

        File::put($tempFile, json_encode(['Post' => false], JSON_PRETTY_PRINT));

        $statusFile = base_path('modules_statuses.json');
        $backup = File::get($statusFile);

        try {
            // Swap the real file for the temp one
            File::put($statusFile, json_encode(['Post' => false], JSON_PRETTY_PRINT));

            // Trigger re-registration in a fresh container
            $app = $this->createApplication();

            $vendorClass = 'Nasirkhan\\ModuleManager\\Modules\\Post\\Providers\\PostServiceProvider';
            $loadedKeys = array_keys($app->getLoadedProviders());

            $this->assertNotContains(
                $vendorClass,
                $loadedKeys,
                'PostServiceProvider must not be registered when Post is disabled in modules_statuses.json'
            );
        } finally {
            // Always restore the original file
            File::put($statusFile, $backup);

            if (File::exists($tempFile)) {
                File::delete($tempFile);
            }
        }
    }

    /**
     * Verifies that the application boots without errors when all 8 modules are
     * enabled — the highest-risk integration check.
     */
    public function test_application_boots_successfully_with_all_modules_enabled(): void
    {
        // If we got here the app booted; assert basic health indicators
        $this->assertTrue(true, 'Application booted successfully with all 8 modules enabled');

        // Verify each module's config is loaded
        foreach (self::MODULES as $module) {
            $key = strtolower($module);

            // Not every module publishes a config — only assert when a config exists
            $vendorConfigPath = base_path(
                "vendor/nasirkhan/module-manager/src/Modules/{$module}/Config/{$key}.php"
            );

            if (File::exists($vendorConfigPath)) {
                $this->assertNotNull(
                    config($key),
                    "Config for module {$module} must be loaded after boot"
                );
            }
        }
    }

    /**
     * Data provider supplying each of the 8 module names.
     *
     * @return array<int, array{0: string}>
     */
    public static function moduleProvider(): array
    {
        return array_map(fn (string $m) => [$m], self::MODULES);
    }
}
