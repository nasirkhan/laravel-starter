<?php

namespace Modules\Article\Console;

use Illuminate\Console\Command;
use Modules\Article\Models\Post;
use Modules\Category\Models\Category;

class UpdateCategoryNameInPosts extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'article:UpdateCategoryNameInPosts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the Category name in all the posts. It will be useful when we change the name of any category.';

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
        echo "\n\n UpdateCategoryNameInPosts \n\n";

        // get all categories
        $categories = Category::all();

        $total_update_count = 0;

        // loop trhough the categories
        foreach ($categories as $category) {
            // update posts when find a category_id match
            $count = Post::where('category_id', $category->id)->update(['category_name' => $category->name]);

            // show total updated rows per category
            echo "\n ".$category->name.'| '.$count.' Posts Updated.';

            $total_update_count += $count;
        }

        // end note, show total updated rows in total
        echo "\n\n Total {$total_update_count} posts updated.";

        echo "\n\n";
    }
}
