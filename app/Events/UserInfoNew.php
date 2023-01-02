<?php

namespace App\Events;

use App\Models\UserInfo;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserInfoNew
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user_info;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(UserInfo $user_info)
    {
        $this->user_info = $user_info;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        //return new PrivateChannel('channel-name');
    }
}
