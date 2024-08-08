<?php

namespace App\Listeners\AymakanListeners;

use App\Events\AymakanEvents\ShipmentUpdateStatusEvent;
use App\Models\ProviderOrder;
use App\Models\Order;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\CompanyAymakanStatus;

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
        
        $order=Order::where('consignmentNo',$event->webHookPayloadObject->tracking)->first();

        $company_id=$order->company_id;

        $CompanyAymakanStatus=CompanyAymakanStatus::where('company_id',$company_id)->first();

        if($event->webHookPayloadObject->status == "AY-0004")
        {
            $order->update(['status_id' => $CompanyAymakanStatus->en_route_id]);

        }
        if($event->webHookPayloadObject->status == "AY-0026")
        {
            $order->update(['status_id' => $CompanyAymakanStatus->en_route_id]);

        }
        if($event->webHookPayloadObject->status == "AY-0032")
        {
            $order->update(['status_id' => $CompanyAymakanStatus->pending_id]);

        }
        if($event->webHookPayloadObject->status == "AY-0005")
        {
            $order->update(['status_id' => $CompanyAymakanStatus->delivered_id]);

        }
    }
}
