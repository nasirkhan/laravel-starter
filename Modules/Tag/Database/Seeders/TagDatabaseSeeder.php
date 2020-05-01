<?php

namespace Modules\Tag\Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use Modules\Tag\Entities\Tag;

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

        factory(Tag::class, 10)->create();
        $tags = Tag::all();
        echo " Insert: tags \n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
