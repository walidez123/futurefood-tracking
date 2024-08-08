<?php

namespace App\ProvidersIntegration\Salla;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class UpdateShipment extends Salla
{
    public function updatePolicy($order)
    {
        if (! $this->isSallaOrder($order)) {
            return '';
        }

        $requestData = [
            'shipment_number' => $order->order_id,
            'tracking_link' => route('track.order', ['tracking_id' => $order->tracking_id]),
            'pdf_label' => asset('orders/'.$order->order_id.'.pdf'),
        ];

        Storage::put('sallaRequests/'.$this->nowDate.'/updateShipment/'.$this->nowTime.'updateRQ.json',
            json_encode($requestData));

        $token = $this->getAccessToken($order->user);

        $response = Http::withToken($token)
            ->put($this->baseUrl.'/admin/v2/shipments/'.
                $order->providerOrder->shipping_id, $requestData);

        Storage::put('sallaRequests/'.$this->nowDate.'/updateShipment/'.$this->nowTime.'updateRS.json',
            $response->body());

        return $response->json();
    }

    private function isSallaOrder($order)
    {
        if (! is_null($order->providerOrder)) {
            if ($order->providerOrder->provider_name == 'salla') {
                return true;
            }
        }

        return false;
    }
}