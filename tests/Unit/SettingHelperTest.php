<?php

namespace Tests\Unit;

use Illuminate\Database\QueryException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class SettingHelperTest extends TestCase
{
    use RefreshDatabase;

    public function test_setting_returns_default_when_settings_table_is_missing(): void
    {
        Schema::dropIfExists('settings');

        $this->assertSame('Fallback value', setting('app_name', 'Fallback value'));
    }

    public function test_setting_set_returns_null_when_settings_table_is_missing(): void
    {
        Schema::dropIfExists('settings');

        $this->assertNull(setting(['app_name', 'Fallback value']));
    }

    public function test_setting_set_stores_value_when_settings_table_exists(): void
    {
        setting(['app_name', 'Updated App Name']);

        $this->assertSame('Updated App Name', setting('app_name'));
    }

    public function test_setting_rethrows_non_missing_table_query_exception_when_reading(): void
    {
        $defaultConnection = config('database.default');
        $brokenConnection = 'sqlite_malformed_read';

        try {
            $this->useMalformedSettingsConnection($brokenConnection, 'malformed-settings-read');

            $this->expectException(QueryException::class);

            setting('app_name');
        } finally {
            config(['database.default' => $defaultConnection]);
            DB::setDefaultConnection($defaultConnection);
            DB::purge($brokenConnection);
        }
    }

    public function test_setting_rethrows_non_missing_table_query_exception_when_writing(): void
    {
        $defaultConnection = config('database.default');
        $brokenConnection = 'sqlite_malformed_write';

        try {
            $this->useMalformedSettingsConnection($brokenConnection, 'malformed-settings-write');

            $this->expectException(QueryException::class);

            setting(['app_name', 'Updated App Name']);
        } finally {
            config(['database.default' => $defaultConnection]);
            DB::setDefaultConnection($defaultConnection);
            DB::purge($brokenConnection);
        }
    }

    private function useMalformedSettingsConnection(string $connectionName, string $directoryName): void
    {
        $databasePath = $this->testingDatabasePath($directoryName);

        File::ensureDirectoryExists(dirname($databasePath));
        File::delete($databasePath);
        File::put($databasePath, '');

        config([
            'database.default' => $connectionName,
            "database.connections.$connectionName" => array_merge(
                config('database.connections.sqlite'),
                ['database' => $databasePath]
            ),
        ]);

        DB::purge($connectionName);
        DB::setDefaultConnection($connectionName);

        Schema::connection($connectionName)->create('settings', function (Blueprint $table): void {
            $table->id();
        });
    }

    private function testingDatabasePath(string $directoryName): string
    {
        return storage_path("framework/testing/{$directoryName}/database.sqlite");
    }
}
