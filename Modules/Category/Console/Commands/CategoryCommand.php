<?php

namespace Modules\Category\Console\Commands;

use Illuminate\Console\Command;

class CategoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:CategoryCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Category Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return Command::SUCCESS;
    }
}
