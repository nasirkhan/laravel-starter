<?php

namespace Modules\Menu\database\seeders;

use Illuminate\Database\Seeder;

class MenuDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            CurrentMenuDataSeeder::class,
        ]);
    }
}
