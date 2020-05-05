<?php

namespace Modules\Article\Database\Seeders;

use Artisan;
use Auth;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Article\Entities\Category;
use Modules\Article\Entities\Post;

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

        factory(Category::class, 5)->create();
        echo " Insert: categories \n";

        /*
         * Posts Seed
         * ------------------
         */
        DB::table('posts')->truncate();
        echo "Truncate: posts \n";

        // Populate the pivot table
        factory(Post::class, 25)->create()->each(function ($post) {
            // $post->tags()->attach(
            //     $tags->random(rand(1, 3))->pluck('id')->toArray()
            // );
        });
        echo " Insert: posts \n";

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
