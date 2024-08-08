<?php

namespace App\ProvidersIntegration\Foodics;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class Orders extends Foodics
{
    public function updateOrder($orderId, $token, $statusId, $retry = 0)
    {
        $request = [
            'delivery_status' => $statusId,
        ];

        Storage::put('/foodicsRequests/'.$this->nowDate.
            '/updateOrder/'.$this->nowTime.'updateOrderRQ.json',
            json_encode($request));

        $headers = [
            'Authorization' => $this->tokenType.' '.$token,
            'Accept' => 'application/json',
        ];

        $response = Http::withHeaders($headers)
            ->contentType('application/json')
            ->put($this->baseUrl.'/v5/orders/'.$orderId, $request);

        Storage::put('/foodicsRequests/'.$this->nowDate.
            '/updateOrder/'.$this->nowTime.'updateOrderRS.json',
            $response->body());

        if ($response->serverError() && $retry <= 3) {
            $retry += 1;
            $this->updateOrder($orderId, $token, $statusId, $retry);
        }

        return $response;
    }
}
