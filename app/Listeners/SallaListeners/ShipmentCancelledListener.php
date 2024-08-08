<?php

namespace App\Listeners\SallaListeners;

use App\Events\SallaEvents\ShipmentCancelled;
use App\Models\CompanySallaStatus;
use App\Helpers\OrderHistory;


use Illuminate\Support\Facades\Log;

use App\Models\ProviderOrder;
use App\Models\Order;


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
        if($event->webHookPayloadObject->data->type=='return')
        {            log::info('cancelled return');

            $providerOrder = Order::where('reference_number', $event->webHookPayloadObject->data->order_reference_id)->where('is_returned',1)->first();
    
            if (is_null($providerOrder)) {
                return;
            }
            $company = CompanySallaStatus::where('company_id', $providerOrder->company_id)
            ->first();
            log::info($company);
            $providerOrder->update(['status_id' => $company->closed_id]);
            OrderHistory::addToHistory($providerOrder->id, $providerOrder->status_id, $providerOrder->status->description);

            log::info($providerOrder->status_id);



        }else{

            $providerOrder = ProviderOrder::where('reference_id', $event->webHookPayloadObject->data->order_reference_id)->first();
            log::info($event->webHookPayloadObject->data->order_reference_id);
    
            if (is_null($providerOrder)) {
                return;
            }
    
            $company = CompanySallaStatus::where('company_id', $providerOrder->order->company_id)
            ->first();
            log::info($company);
    
    
    
            $providerOrder->order->update(['status_id' => $company->closed_id]);
            OrderHistory::addToHistory($providerOrder->order->id, $providerOrder->order->status_id, $providerOrder->order->status->description);


        }
       

    }
}