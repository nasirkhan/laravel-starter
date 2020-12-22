<?php

namespace Modules\Article\Database\Seeders;

use Artisan;
use Auth;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Article\Entities\Category;
use Modules\Article\Entities\Post;
use Modules\Tag\Entities\Tag;

class ArticleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Auth::loginUsingId(1);

        // Disable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        /*
         * Category Seed
         * ------------------
         */
        DB::table('categories')->truncate();
        echo "\nTruncate: categories \n";

        Category::factory()->count(5)->create();
        echo " Insert: categories \n\n";

        /*
         * Posts Seed
         * ------------------
         */
        DB::table('posts')->truncate();
        echo "Truncate: posts \n";

        // Populate the pivot table
        Post::factory()
                ->has(Tag::factory()->count(rand(1, 5)))
                ->count(25)
                ->create();
        echo " Insert: posts \n\n";

        // Artisan::call('auth:permission', [
        //     'name' => 'posts',
        // ]);
        // Artisan::call('auth:permission', [
        //     'name' => 'categories',
        // ]);
        // Artisan::call('auth:permission', [
        //     'name' => 'tags',
        // ]);

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
