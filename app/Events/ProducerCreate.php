<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Hyn\Tenancy\Queue\TenantAwareJob;

class ProducerCreate
{
    use Dispatchable, InteractsWithSockets,TenantAwareJob;
    public $reply;
    public $openid;
    public $app;
    public $token;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($reply,$openid,$token)
    {
        $this->reply = $reply;
        $this->openid = $openid;
        $this->token = $token;
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
