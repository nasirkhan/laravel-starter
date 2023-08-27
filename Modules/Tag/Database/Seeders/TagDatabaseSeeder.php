<?php

namespace Modules\Tag\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Tag\Models\Tag;

class TagDatabaseSeeder extends Seeder
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
         * Tags Seed
         * ------------------
         */

        DB::table('taggables')->truncate();
        echo "Truncate: taggables \n";

        DB::table('tags')->truncate();
        echo "Truncate: tags \n";

        Tag::factory()->count(20)->create();
        $tags = Tag::all();
        echo " Insert: tags \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
