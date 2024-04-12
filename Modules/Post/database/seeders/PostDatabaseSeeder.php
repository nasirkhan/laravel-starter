<?php

namespace Modules\Post\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Post\Models\Post;

class PostDatabaseSeeder extends Seeder
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
         * Posts Seed
         * ------------------
         */

        // DB::table('posts')->truncate();
        // echo "Truncate: posts \n";

        Post::factory()->count(20)->create();
        $rows = Post::all();
        echo " Insert: posts \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
