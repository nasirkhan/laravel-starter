<?php

namespace Modules\Gallery\Console\Commands;

use Illuminate\Console\Command;

class GalleryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:GalleryCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gallery Command description';

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
