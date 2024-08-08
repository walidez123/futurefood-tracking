<?php

namespace App\Jobs;

use App\Events\ZidEvents\AppUninstalledEvent;
use Illuminate\Support\Facades\Log;

use App\Events\ZidEvents\OrderShipmentReturnCreatingEvent;
use App\Events\ZidEvents\ShipmentCancelledEvent;
use App\Events\ZidEvents\ShipmentCreatingEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Events\ZidEvents\ShipmentUpdateStatusEvent;

use Spatie\WebhookClient\Jobs\ProcessWebhookJob;
use Spatie\WebhookClient\Models\WebhookCall;

class ZedWebHookJob extends ProcessWebhookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    // public function __construct(WebhookCall $webhookCall)
    // {
    //     parent::__construct(WebhookCall::find(6));
    // }

    public function __construct(WebhookCall $webhookCall)
    {
        parent::__construct($webhookCall);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $webHookPayloadObject = json_decode(json_encode($this->webhookCall->payload));
        Log::info($webHookPayloadObject);


        if (isset($webHookPayloadObject->event) && $webHookPayloadObject->event == 'app.market.application.uninstall') {
            event(new AppUninstalledEvent($webHookPayloadObject));
        } else {
            if (isset($webHookPayloadObject->order_status) || (is_array($webHookPayloadObject) && array_key_exists('order_status', $webHookPayloadObject))) {
                if ($webHookPayloadObject->order_status->code == 'ready') {
                    event(new ShipmentCreatingEvent($webHookPayloadObject));
                } elseif ($webHookPayloadObject->order_status->code == 'cancelled') {
                    event(new ShipmentCancelledEvent($webHookPayloadObject));
                } elseif ($webHookPayloadObject->order_status->code == 'refunded') {
                    event(new OrderShipmentReturnCreatingEvent($webHookPayloadObject));
                }
                elseif ($webHookPayloadObject->order_status->code == "reversed") {
                    event(new OrderShipmentReturnCreatingEvent($webHookPayloadObject));
                }
                elseif ($webHookPayloadObject->order_status->code == "inDelivery" || $webHookPayloadObject->order_status->code == "delivered" || $webHookPayloadObject->order_status->code == "preparing" ) {
                    event(new ShipmentUpdateStatusEvent($webHookPayloadObject));
                }
                
            }
        }
    }
}
