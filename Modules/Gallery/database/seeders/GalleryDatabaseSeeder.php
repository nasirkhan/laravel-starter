<?php

namespace Modules\Gallery\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Gallery\Models\Gallery;

class GalleryDatabaseSeeder extends Seeder
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
         * Galleries Seed
         * ------------------
         */

        // DB::table('galleries')->truncate();
        // echo "Truncate: galleries \n";

        Gallery::factory()->count(20)->create();
        $rows = Gallery::all();
        echo " Insert: galleries \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
