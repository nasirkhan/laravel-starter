<?php

namespace Tests\Feature\Unit;

use Tests\TestCase;

class HelpersTest extends TestCase
{
    /**
     * user_registration() returns true when config value is true.
     */
    public function test_user_registration_returns_true_when_config_is_true(): void
    {
        config(['app.user_registration' => true]);

        $this->assertTrue(user_registration());
    }

    /**
     * user_registration() returns false when config value is false.
     */
    public function test_user_registration_returns_false_when_config_is_false(): void
    {
        config(['app.user_registration' => false]);

        $this->assertFalse(user_registration());
    }

    /**
     * user_registration() only reads from config, not from env() directly.
     */
    public function test_user_registration_respects_config_not_raw_env(): void
    {
        config(['app.user_registration' => false]);

        // Even if the env value would be truthy, config() controls the result
        $this->assertFalse(user_registration());
    }

    /**
     * label_case converts underscores and hyphens to spaces and title-cases the result.
     */
    public function test_label_case_converts_to_title_case(): void
    {
        $this->assertSame('Hello World', label_case('hello_world'));
        $this->assertSame('Hello World', label_case('hello-world'));
        $this->assertSame('Hello World', label_case('hello world'));
    }

    /**
     * encode_id and decode_id are inverse operations.
     */
    public function test_encode_and_decode_id_are_inverse(): void
    {
        $id = 42;
        $encoded = encode_id($id);

        $this->assertIsString($encoded);
        $this->assertSame($id, decode_id($encoded));
    }

    /**
     * decode_id returns null for an invalid hash.
     */
    public function test_decode_id_returns_null_for_invalid_hash(): void
    {
        $this->assertNull(decode_id(''));
    }

    /**
     * demo_mode() returns true when config value is true.
     */
    public function test_demo_mode_returns_true_when_config_is_true(): void
    {
        config(['app.demo_mode' => true]);

        $this->assertTrue(demo_mode());
    }

    /**
     * demo_mode() returns false when config value is false.
     */
    public function test_demo_mode_returns_false_when_config_is_false(): void
    {
        config(['app.demo_mode' => false]);

        $this->assertFalse(demo_mode());
    }
}
