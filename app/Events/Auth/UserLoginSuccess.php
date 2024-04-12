<?php

namespace App\Events\Auth;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;

class UserLoginSuccess
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;

    public $request;

    /**
     * Login Success Event Construct.
     */
    public function __construct(Request $request, User $user)
    {
        $this->user = $user;
        $this->request = $this->prepareRequestData($request);
    }

    public function prepareRequestData($request)
    {
        $data = $request->all();

        $data['last_ip'] = request()->getClientIp();

        return $data;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
