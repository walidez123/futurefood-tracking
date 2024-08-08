<?php

namespace App\Events\AymakanEvents;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ShipmentUpdateStatusEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $webHookPayloadObject;

    /**
     * Create a new event instance.
     */
    public function __construct($webHookPayloadObject)
    {
        $this->webHookPayloadObject = $webHookPayloadObject;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
