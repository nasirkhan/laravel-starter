<?php

namespace Modules\Newsletter\Console;

use App\Models\Role;
use Illuminate\Console\Command;
use Modules\Article\Entities\Newsletter;
use Modules\Newsletter\Events\DispatchNewsletter;

class DispatchNewsletterCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'newsletter:dispatch-newsletter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Displatch published newsletters at the publish time. ';

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
        $newsletters = Newsletter::notDelivered()->get();
        echo "\n\n";
        echo 'Total Newsletters which are yet to deliver: '.$newsletters->count();
        echo "\n\n";

        foreach ($newsletters as $newsletter) {
            echo "\n";
            echo 'Name: '.$newsletter->name;
            echo "\n";
            echo 'Time: '.$newsletter->published_at;
            echo "\n";
            echo 'User Group: '.$newsletter->role_name.' (Id:'.$newsletter->role_id.')';
            echo "\n";
            echo 'Status: '.$newsletter->status.' ('.$newsletter->status_label.')';
            echo "\n\n";

            if ($newsletter->role_id > 0) {
                $role = Role::findOrFail($newsletter->role_id);
                $users = $role->users;

                foreach ($users as $user) {
                    echo "\n";
                    echo ' User: '.$user->name.' (Id:'.$user->id.')';

                    event(new DispatchNewsletter($newsletter, $user));
                }
            }

            echo "\n\n\n";
        }

        echo '---';
        echo "\n\n";
    }
}
