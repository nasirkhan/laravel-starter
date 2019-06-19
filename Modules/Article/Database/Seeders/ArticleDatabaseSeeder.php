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
<<<<<<< HEAD
        // $this->info("Truncate: categories");

        factory(Category::class, 5)->create();
        // $this->info("Insert: categories");
=======
        $this->info('Truncate: categories');

        factory(Category::class, 5)->create();
        $this->info('Insert: categories');
>>>>>>> 5f3fa259a4678024ed77effb51a26431f0aeda58

        /*
         * Tags Seed
         * ------------------
         */

        DB::table('post_tag')->truncate();
<<<<<<< HEAD
        // $this->info("Truncate: post_tag");

        DB::table('tags')->truncate();
        // $this->info("Truncate: tags");

        factory(Tag::class, 10)->create();
        $tags = Tag::all();
        // $this->info("Insert: tags");
=======
        $this->info('Truncate: post_tag');

        DB::table('tags')->truncate();
        $this->info('Truncate: tags');

        factory(Tag::class, 10)->create();
        $tags = Tag::all();
        $this->info('Insert: tags');
>>>>>>> 5f3fa259a4678024ed77effb51a26431f0aeda58

        /*
         * Posts Seed
         * ------------------
         */
        DB::table('posts')->truncate();
<<<<<<< HEAD
        // $this->info("Truncate: posts");
=======
        $this->info('Truncate: posts');
>>>>>>> 5f3fa259a4678024ed77effb51a26431f0aeda58

        // Populate the pivot table
        factory(Post::class, 25)->create()->each(function ($post) use ($tags) {
            $post->tags()->attach(
                $tags->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
<<<<<<< HEAD
        // $this->info("Insert: posts");
=======
        $this->info('Insert: posts');
>>>>>>> 5f3fa259a4678024ed77effb51a26431f0aeda58

        /*
         * Comment Seed
         * ------------------
         */
        DB::table('comments')->truncate();
<<<<<<< HEAD
        // $this->info("Truncate: comments");

        factory(Comment::class, 50)->create();
        // $this->info("Insert: comments");
=======
        $this->info('Truncate: comments');

        factory(Comment::class, 50)->create();
        $this->info('Insert: comments');
>>>>>>> 5f3fa259a4678024ed77effb51a26431f0aeda58

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
