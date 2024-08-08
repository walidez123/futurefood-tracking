<?php

namespace App\Listeners\ZidListeners;

use App\Events\ZidEvents\ShipmentCancelledEvent;
use App\Models\ProviderOrder;
use App\Models\Order;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\CompanyZidStatus;

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
    public function handle(ShipmentCancelledEvent $event): void
    {
        $providerOrder = ProviderOrder::where('reference_id', $event->webHookPayloadObject->code)->first();
        if (is_null($providerOrder)) {
            return;
        }
        $order=Order::where('id',$providerOrder->provider_order_id)->first();
        $company_id=$order->company_id;
        $CompanyZidStatus=CompanyZidStatus::where('company_id',$company_id)->first();
        $order->update(['status_id' => $CompanyZidStatus->closed_id]);
    }
}
