<?php

namespace Tests\Unit;

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use PDOException;
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

    public function test_setting_set_stores_value_from_key_value_pair_when_settings_table_exists(): void
    {
        $settingPair = ['app_name', 'Updated App Name'];

        setting($settingPair);

        $this->assertSame($settingPair[1], setting($settingPair[0]));
    }

    public function test_setting_returns_default_for_missing_key_when_settings_table_exists(): void
    {
        $this->assertSame('Fallback value', setting('missing-setting-key', 'Fallback value'));
    }

    public function test_settings_table_is_missing_recognizes_sqlite_missing_table_query_exception(): void
    {
        $previous = new PDOException('SQLSTATE[HY000]: General error: 1 no such table: settings');
        $previous->errorInfo = ['HY000', 1, 'no such table: settings'];

        $exception = new QueryException('sqlite', 'select * from "settings"', [], $previous);

        $this->assertTrue(settings_table_is_missing($exception));
    }

    public function test_setting_rethrows_non_missing_table_query_exception_when_reading(): void
    {
        $defaultConnection = config('database.default');
        $brokenConnection = 'sqlite_broken_read';
        $originalBrokenConnectionConfig = config("database.connections.$brokenConnection");

        try {
            $this->useBrokenDefaultConnection($brokenConnection, 'broken-settings-read');

            $this->expectException(QueryException::class);

            setting('app_name');
        } finally {
            config(['database.default' => $defaultConnection]);
            config(["database.connections.$brokenConnection" => $originalBrokenConnectionConfig]);
            DB::setDefaultConnection($defaultConnection);
            DB::purge($brokenConnection);
        }
    }

    public function test_setting_rethrows_non_missing_table_query_exception_when_writing(): void
    {
        $defaultConnection = config('database.default');
        $brokenConnection = 'sqlite_broken_write';
        $originalBrokenConnectionConfig = config("database.connections.$brokenConnection");

        try {
            $this->useBrokenDefaultConnection($brokenConnection, 'broken-settings-write');

            $this->expectException(QueryException::class);

            setting(['app_name', 'Updated App Name']);
        } finally {
            config(['database.default' => $defaultConnection]);
            config(["database.connections.$brokenConnection" => $originalBrokenConnectionConfig]);
            DB::setDefaultConnection($defaultConnection);
            DB::purge($brokenConnection);
        }
    }

    private function useBrokenDefaultConnection(string $connectionName, string $directoryName): void
    {
        $databasePath = $this->testing_database_path($directoryName);

        File::ensureDirectoryExists(dirname($databasePath));
        File::delete($databasePath);
        File::put($databasePath, 'not a sqlite database');

        config([
            'database.default' => $connectionName,
            "database.connections.$connectionName" => array_merge(
                config('database.connections.sqlite'),
                ['database' => $databasePath]
            ),
        ]);

        DB::purge($connectionName);
        DB::setDefaultConnection($connectionName);
    }

    private function testing_database_path(string $directoryName): string
    {
        return storage_path("framework/testing/{$directoryName}/database.sqlite");
    }
}
