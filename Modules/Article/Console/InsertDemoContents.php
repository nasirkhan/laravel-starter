<?php

namespace Modules\Article\Console;

use Auth;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Facades\DB;
use Modules\Article\Entities\Category;
use Modules\Article\Entities\Post;
use Modules\Tag\Entities\Tag;

class InsertDemoContents extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'starter:insert-demo-data {--fresh}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert demo data for posts, categories, tags, and comments. --fresh option will truncate the tables.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Auth::loginUsingId(1);

        $fresh = $this->option('fresh');
        // $this->info("a $fresh");

        if($fresh) {
            if ($this->confirm('Database tables (posts, categories, tags, comments) will become empty. Confirm truncate tables?')) {
                // Disable foreign key checks!
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');

                /**
                 * posts table truncate
                 */
                DB::table("posts")->truncate();
                $this->info("Truncate Table: posts");

                /**
                 * Categories table truncate
                 */
                DB::table("categories")->truncate();
                $this->info("Truncate Table: categories");

                /**
                 * Tags table truncate
                 */
                DB::table("tags")->truncate();
                $this->info("Truncate Table: tags");

                /**
                 * Comments table truncate
                 */
                DB::table("comments")->truncate();
                $this->info("Truncate Table: comments");

                // Enable foreign key checks!
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            }
        }

        /**
         * Categories
         */
        $this->info("Inserting Categories");
        factory(Category::class, 5)->create();

        /**
         * Tags
         */
        $this->info("Inserting Tags");
        factory(Tag::class, 10)->create();

        /**
         * Posts
         */
        $this->info("Inserting Posts");
        factory(Post::class, 25)->create()->each(function ($post) {
            $post->tags()->attach(
                Tag::inRandomOrder()->limit(rand(5, 10))->pluck('id')->toArray()
            );
        });

        $this->info("-- END --");
    }
}
