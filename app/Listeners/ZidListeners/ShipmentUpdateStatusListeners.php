<?php

namespace App\Listeners\ZidListeners;

use App\Events\ZidEvents\ShipmentUpdateStatusEvent;
use App\Models\ProviderOrder;
use App\Models\Order;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\CompanyZidStatus;

class ShipmentUpdateStatusListeners
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
    public function handle(ShipmentUpdateStatusEvent $event): void
    {
        $providerOrder = ProviderOrder::where('reference_id', $event->webHookPayloadObject->code)->first();
        if (is_null($providerOrder)) {
            return;
        }
        $order=Order::where('id',$providerOrder->provider_order_id)->first();
        $company_id=$order->company_id;
        $CompanyZidStatus=CompanyZidStatus::where('company_id',$company_id)->first();
        if($event->webHookPayloadObject->order_status->code == "preparing")
        {
            $order->update(['status_id' => $CompanyZidStatus->assigned_id]);

        }
        if($event->webHookPayloadObject->order_status->code == "inDelivery")
        {
            $order->update(['status_id' => $CompanyZidStatus->en_route_id]);

        }
        if($event->webHookPayloadObject->order_status->code == "delivered")
        {
            $order->update(['status_id' => $CompanyZidStatus->delivered_id]);

        }
    }
}
