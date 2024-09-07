<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;


class DelegateLocationUpdated implements ShouldBroadcastNow
{
    use InteractsWithSockets, SerializesModels;

    public $delegateId;
    public $latitude;
    public $longitude;

    public function __construct($delegateId, $latitude, $longitude)
    {
        $this->delegateId = $delegateId;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function broadcastOn()
    {
        return ['delegate-location-channel'];
    }

    public function broadcastAs()
    {
        return 'delegate-location-updated';
    }
}

