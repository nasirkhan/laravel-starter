<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
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
}
