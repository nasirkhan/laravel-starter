<?php

namespace Modules\Article\Database\Seeders;

use Artisan;
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
        // Disable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        /*
         * Category Seed
         * ------------------
         */
        DB::table('categories')->truncate();
        echo "\n Truncate: categories";
        factory(Category::class, 5)->create();
        echo "\n Insert: categories";

        /*
         * Tags Seed
         * ------------------
         */
        DB::table('post_tag')->truncate();
        DB::table('tags')->truncate();
        factory(Tag::class, 10)->create();
        $tags = Tag::all();

        /*
         * Posts Seed
         * ------------------
         */
        DB::table('posts')->truncate();

        // Populate the pivot table
        factory(Post::class, 25)->create()->each(function ($post) use ($tags) {
            $post->tags()->attach(
                $tags->random(rand(1, 3))->pluck('id')->toArray()
            );
        });

        /*
         * Comment Seed
         * ------------------
         */
        DB::table('comments')->truncate();
        factory(Comment::class, 50)->create();

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
