<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Traits\AutoDiscoverModuleSeeders;

class DatabaseSeeder extends Seeder
{
    use AutoDiscoverModuleSeeders;
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        $this->call(AuthTableSeeder::class);
        
        // Automatically discover and call module seeders
        $this->callModuleSeeders();

        Schema::enableForeignKeyConstraints();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
