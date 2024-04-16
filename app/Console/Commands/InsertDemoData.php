<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\Category\Models\Category;
use Modules\Comment\Models\Comment;
use Modules\Post\Models\Post;
use Modules\Tag\Models\Tag;

use function Laravel\Prompts\confirm;

class InsertDemoData extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'starter:insert-demo-data {--fresh}';

    /**
     * The console command description.
     */
    protected $description = 'Insert demo data for posts, categories, tags, and comments. --fresh option will truncate the tables.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Auth::loginUsingId(1);

        $fresh = $this->option('fresh');

        if ($fresh) {
            $this->truncate_tables();
        }

        $this->insert_demo_data();
    }

    public function insert_demo_data()
    {
        $this->info('Inserting Demo Data');

        /**
         * Categories.
         */
        $this->components->task('Inserting Categories', function () {
            Category::factory()->count(5)->create();
        });

        /**
         * Tags.
         */
        $this->components->task('Inserting Tags', function () {
            Tag::factory()->count(10)->create();
        });

        /**
         * Posts.
         */
        $this->components->task('Inserting Posts', function () {
            Post::factory()->count(25)->create()->each(function ($post) {
                $post->tags()->attach(
                    Tag::inRandomOrder()->limit(rand(5, 10))->pluck('id')->toArray()
                );
            });
        });

        // /**
        //  * Comments.
        //  */
        // $this->components->task("Inserting Comments", function () {
        //     Comment::factory()->count(25)->create();
        // });

        $this->newLine(2);
        $this->info('-- Completed --');
        $this->newLine();
    }

    public function truncate_tables()
    {
        $tables_list = [
            'posts',
            'categories',
            'tags',
            'taggables',
            // 'comments',
            'activity_log',
        ];

        $confirmed = confirm(
            label: 'Database tables (posts, categories, tags, comments) will become empty. Confirm truncate tables?',
            default: false,
        );

        $this->info('Truncate tables');

        if ($confirmed) {
            // Disable foreign key checks!
            Schema::disableForeignKeyConstraints();

            foreach ($tables_list as $row) {
                $table_name = $row;

                $this->components->task("Truncate Table: {$table_name}", function () use ($table_name) {
                    DB::table($table_name)->truncate();
                });
            }

            // Enable foreign key checks!
            Schema::enableForeignKeyConstraints();
        } else {
            $this->warn('Skipped database truncate.');
        }
        $this->newLine();
    }
}
