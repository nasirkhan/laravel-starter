<?php

namespace Modules\Article\Database\Seeders;

use Artisan;
use Auth;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Article\Entities\Category;
use Modules\Article\Entities\Comment;
use Modules\Article\Entities\Post;
use Modules\Article\Entities\Tag;

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
         * Tags Seed
         * ------------------
         */

        DB::table('post_tag')->truncate();
        echo "Truncate: post_tag \n";

        DB::table('tags')->truncate();
        echo "Truncate: tags \n";

        factory(Tag::class, 10)->create();
        $tags = Tag::all();
        echo " Insert: tags \n";

        /*
         * Posts Seed
         * ------------------
         */
        DB::table('posts')->truncate();
        echo "Truncate: posts \n";

        // Populate the pivot table
        factory(Post::class, 25)->create()->each(function ($post) use ($tags) {
            $post->tags()->attach(
                $tags->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
        echo " Insert: posts \n";

        /*
         * Comment Seed
         * ------------------
         */
        DB::table('comments')->truncate();
        echo "Truncate: comments \n";

        factory(Comment::class, 50)->create();
        echo " Insert: comments \n";

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
