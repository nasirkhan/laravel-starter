<?php

namespace Tests\Unit;

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
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
        $brokenConnection = 'sqlite_broken_read';

        config([
            'database.default' => $brokenConnection,
            "database.connections.$brokenConnection" => array_merge(
                config('database.connections.sqlite'),
                ['database' => '/tmp/missing-settings-read/database.sqlite']
            ),
        ]);

        DB::purge($brokenConnection);
        DB::setDefaultConnection($brokenConnection);

        $this->expectException(QueryException::class);

        setting('app_name');
    }

    public function test_setting_rethrows_non_missing_table_query_exception_when_writing(): void
    {
        $brokenConnection = 'sqlite_broken_write';

        config([
            'database.default' => $brokenConnection,
            "database.connections.$brokenConnection" => array_merge(
                config('database.connections.sqlite'),
                ['database' => '/tmp/missing-settings-write/database.sqlite']
            ),
        ]);

        DB::purge($brokenConnection);
        DB::setDefaultConnection($brokenConnection);

        $this->expectException(QueryException::class);

        setting(['app_name', 'Updated App Name']);
    }
}
