<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class IssueCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $issue;

    /**
     * Create a new event instance.
     *
     * @param $payload
     */
    public function __construct($payload)
    {
        $this->issue = $payload;
    }

}
