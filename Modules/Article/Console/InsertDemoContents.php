<?php

namespace Modules\Article\Console;

use Auth;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\Article\Entities\Category;
use Modules\Article\Entities\Post;
use Modules\Comment\Entities\Comment;
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

        if ($fresh) {
            if ($this->confirm('Database tables (posts, categories, tags, comments) will become empty. Confirm truncate tables?')) {

                // Disable foreign key checks!
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');

                /**
                 * posts table truncate.
                 */
                DB::table('posts')->truncate();
                $this->info('Truncate Table: posts');

                /**
                 * Categories table truncate.
                 */
                DB::table('categories')->truncate();
                $this->info('Truncate Table: categories');

                /**
                 * Tags table truncate.
                 */
                DB::table('tags')->truncate();
                $this->info('Truncate Table: tags');

                /**
                 * Comments table truncate.
                 */
                DB::table('comments')->truncate();
                $this->info('Truncate Table: comments');

                // Enable foreign key checks!
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            }
        }

        $this->newLine();

        /**
         * Categories.
         */
        $this->info('Inserting Categories');
        Category::factory()->count(5)->create();

        /**
         * Tags.
         */
        $this->info('Inserting Tags');
        Tag::factory()->count(10)->create();

        /**
         * Posts.
         */
        $this->info('Inserting Posts');
        Post::factory()->count(25)->create()->each(function ($post) {
            $post->tags()->attach(
                Tag::inRandomOrder()->limit(rand(5, 10))->pluck('id')->toArray()
            );
        });

        /**
         * Comments.
         */
        $this->info('Inserting Comments');
        Comment::factory()->count(25)->create();

        $this->newLine(2);
        $this->info('-- Completed --');
        $this->newLine();
    }
}
