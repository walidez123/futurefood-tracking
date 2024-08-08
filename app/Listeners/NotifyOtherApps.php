<?php

namespace App\Listeners;

use App\Events\OrderStatusUpdated;
use Illuminate\Support\Facades\Log;
use Spatie\WebhookServer\WebhookCall;

class NotifyOtherApps
{
    /**
     * Handle the event.
     */
    public function handle(OrderStatusUpdated $event)
    {
        $orderId = $event->orderId;
        $newStatus = $event->newStatus;
        $url = $event->url;

        $payload = [
            'order_id' => $orderId,
            'new_status' => $newStatus,
         
        ];

        try {

            $webhookCall = WebhookCall::create()->url($url)
                ->payload($payload)
                ->useSecret(config('app.webhook_secret'));

            Log::info("Webhook Call Details: URL: {$url}, Payload: ".json_encode($payload));

            // Dispatch the webhook call
            $webhookResponse = $webhookCall->dispatch();

            // Log the response
            Log::info('Webhook Response: '.json_encode($webhookResponse));

            Log::info("Order status updated: OrderID $orderId, New Status: $newStatus");
        } catch (\Exception $e) {

            Log::error('Error sending webhook request: '.$e->getMessage());
        }
    }
}
