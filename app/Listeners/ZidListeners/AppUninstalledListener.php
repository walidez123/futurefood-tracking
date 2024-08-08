<?php

namespace App\Listeners\ZidListeners;

use App\Events\ZidEvents\AppUninstalledEvent;
use App\Models\User;

class AppUninstalledListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AppUninstalledEvent $event)
    {
        $merchant = User::where('provider_store_id', $event->webHookPayloadObject->store_id)->first();
        if (! $merchant) {
            $merchant->update([
                'is_active' => 0,
            ]);
        }
    }
}
