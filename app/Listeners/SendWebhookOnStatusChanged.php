<?php

namespace App\Listeners;

use App\Events\StatusChanged;
use GuzzleHttp\Client;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;


class SendWebhookOnStatusChanged implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(StatusChanged $event)
    {
        $client = new Client();
        $user_weebhook=$event->model->user->webhook_url;
        $url = 'https://webhook.site/a53893f2-198f-405f-96ba-04d55b629503'; // Replace with your webhook URL


        $response = $client->post($user_weebhook, [
            'json' => [
                'order_id' => $event->model->id,
                'new_status' => $event->model->status_id ,
                'delegate_name' =>  ! empty($event->model->delegate) ? $event->model->delegate->name : '',
                'delegate_phone' => ! empty($event->model->delegate) ? $event->model->delegate->phone : '',
                'tracking_link' => route('track.order', ['tracking_id' => $event->model->tracking_id]),



            ],
        ]);
        Log::info('Webhook Response: '.json_encode($response));


        return $response->getStatusCode();
    }
}
