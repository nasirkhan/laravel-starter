<?php

namespace Modules\Newsletter\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Article\Entities\Newsletter;

class NewsletterDatabaseSeeder extends Seeder
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

        // categories seed
        DB::table('newsletters')->truncate();
        factory(Newsletter::class, 10)->create();

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
