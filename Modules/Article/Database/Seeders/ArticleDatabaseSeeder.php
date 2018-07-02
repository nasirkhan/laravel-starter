<?php

namespace Modules\Article\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Article\Entities\Category;
use Modules\Article\Entities\Tag;
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
        // categories seed
        DB::table('categories')->truncate();
        $categories = factory(Category::class, 5)->create();

        // tags seed
        DB::table('tags')->truncate()
        $tags = factory(Tag::class, 10)->create();

        // // posts seed
        // DB::table('posts')->truncate()
        // // $posts = factory(Post::class, 15)->create();
        //
        //
        // factory(Post::class, 20)->create()->each(function ($u) {
        //     $u->post()->save(factory(App\Post::class)->make());
        // });

        // $this->call("OthersTableSeeder");
    }
}
