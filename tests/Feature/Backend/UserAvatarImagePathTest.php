<?php

namespace Tests\Feature\Backend;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserAvatarImagePathTest extends TestCase
{
    use RefreshDatabase;

    public function test_image_path_from_url_strips_scheme_and_host(): void
    {
        $this->assertSame(
            '/users/7/avatar.jpg',
            User::imagePathFromUrl('https://example.com/users/7/avatar.jpg')
        );
    }

    public function test_media_url_is_reduced_to_a_host_relative_avatar_path(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $media = $user->addMedia(UploadedFile::fake()->image('avatar.jpg'))
            ->toMediaCollection('users');

        $user->update(['avatar' => User::imagePathFromUrl($media->getUrl())]);
        $user->refresh();

        $this->assertNotEmpty($user->avatar);
        $this->assertStringNotContainsString('://', $user->avatar);
        $this->assertSame(parse_url($media->getUrl(), PHP_URL_PATH), $user->avatar);
    }
}
