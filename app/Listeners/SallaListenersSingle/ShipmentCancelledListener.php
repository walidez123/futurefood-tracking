<?php

namespace App\Listeners\SallaListeners;

use App\Events\SallaEvents\ShipmentCancelled;
use App\Models\ProviderOrder;

class ShipmentCancelledListener
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
    public function handle(ShipmentCancelled $event): void
    {
        $providerOrder = ProviderOrder::where('shipping_id', $event->webHookPayloadObject->data->id)->first();
        if (is_null($providerOrder)) {
            return;
        }

        $providerOrder->order->update(['status_id' => 54]);
        // $providerOrder->order->update(['status_id' => $providerOrder->order->user->company->companySallaStatus->closed_id]);

    }
}
