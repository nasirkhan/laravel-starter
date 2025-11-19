<?php

namespace Modules\Category\database\seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Modules\Category\Models\Category;

class CategoryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Authenticate as the first user to satisfy BaseModel's created_by requirement
        $user = User::first();
        Auth::login($user);

        Category::factory()->count(20)->create();

        // Clear authentication after seeding
        Auth::logout();

        if (! app()->runningUnitTests()) {
            $this->command->info('Category Module Seeded');
        }
    }
}
