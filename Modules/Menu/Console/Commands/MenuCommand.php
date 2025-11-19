<?php

namespace Modules\Menu\Console\Commands;

use Illuminate\Console\Command;

class MenuCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:MenuCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menu Command description';

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
