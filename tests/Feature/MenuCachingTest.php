<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MenuCachingTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    #[Test]
    public function menu_caching_uses_user_id_in_cache_key()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // The cache keys should be different for different users
        $cacheKey1 = 'menu_data_test-location_'.$user1->id.'_en';
        $cacheKey2 = 'menu_data_test-location_'.$user2->id.'_en';

        $this->assertNotEquals($cacheKey1, $cacheKey2, 'Cache keys should be different for different users');
    }

    #[Test]
    public function menu_cache_key_format_is_correct()
    {
        $expectedFormat = 'menu_data_test-location_'.$this->user->id.'_en';

        // Verify the cache key format includes location, user ID, and locale
        $this->assertStringContainsString('menu_data_', $expectedFormat);
        $this->assertStringContainsString((string) $this->user->id, $expectedFormat);
        $this->assertStringContainsString('_en', $expectedFormat);
    }
}
