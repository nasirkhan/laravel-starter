<?php

namespace Modules\Category\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Category\Models\Category;

class CategoryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Disable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        /*
         * Categories Seed
         * ------------------
         */

        // DB::table('categories')->truncate();
        // echo "Truncate: categories \n";

        Category::factory()->count(20)->create();
        $rows = Category::all();
        echo " Insert: categories \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
