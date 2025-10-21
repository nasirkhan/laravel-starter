<?php

namespace Modules\Post\database\seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Modules\Post\Models\Post;

class PostDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Authenticate as the first user to satisfy BaseModel's created_by requirement
        $user = User::first();
        Auth::login($user);

        Post::factory()->count(20)->create();

        // Clear authentication after seeding
        Auth::logout();

        if (! app()->runningUnitTests()) {
            $this->command->info('Post Module Seeded');
        }
    }
}
