<?php

namespace App\ProvidersIntegration\Zid;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UpdateOrderZid extends Zid
{
    public function updatePolicyZid($order)
    {
        if (! $this->isZidOrder($order)) {
            return '';
        }
        // if($order->status==null)
        // {   $status = 'ready';

        // }else{
        //     $status = $order->status->title;

        // }
        // $status=

        $requestData = [
            'order_status' => 'ready',
            'tracking_number' => $order->providerOrder->order_id,
            'tracking_url' => route('track.order', ['tracking_id' => $order->tracking_id]),
            'waybill_url' => asset('orders/' . $order->providerOrder->order_id . '.pdf'),
        ];
        Storage::put(
            'zidRequests/'.$this->nowDate.'/updateOrder/'.$this->nowTime.'updateRQ.json',
            json_encode($requestData)
        );
        $token = $order->user->provider_refresh_token;
        $access_token = $order->user->provider_access_token;

        $client = Http::withHeaders(['Accept' => 'application/json', 'X-Manager-Token' => $access_token])->withToken($token)

            ->post($this->baseUrl . '/v1/managers/store/orders/' . $order->providerOrder->order_id . '/change-order-status', $requestData);

        // $response = $client->json();

        Log::info($client);

        // Storage::put(
        //     'zidRequests/' . $this->nowDate . '/updateOrder/' . $this->nowTime . 'updateRS.json',
        //     $response->getBody()->getContents()
        // );

        // return  $response;
    }

    private function isZidOrder($order)
    {
        if (! is_null($order->providerOrder)) {
            if ($order->providerOrder->provider_name == 'zid') {
                return true;
            }
        }

        return false;
    }
}
