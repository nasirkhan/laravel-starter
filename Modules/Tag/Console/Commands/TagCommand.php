<?php

namespace Modules\Tag\Console\Commands;

use Illuminate\Console\Command;

class TagCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:TagCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tag Command description';

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
