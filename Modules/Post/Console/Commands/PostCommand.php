<?php

namespace Modules\Post\Console\Commands;

use Illuminate\Console\Command;

class PostCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:PostCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Post Command description';

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
