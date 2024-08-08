<?php

namespace App\ProvidersIntegration\Salla;

use Illuminate\Support\Facades\Storage;

class UpdateOrder extends Salla
{
    public function updatePolicy($order)
    {
        if (! $this->isSallaOrder($order)) {
            return '';
        }

        $requestData = [
            '_method' => 'PUT',
            'shipment_type' => 'shipment',
            'shipment_number' => $order->providerOrder->shipping_id,
            'tracking_link' => route('track.order', ['tracking_id' => $order->tracking_id]),
            'pdf_label' => asset('orders/'.$order->order_id.'.pdf'),
        ];

        Storage::put('sallaRequests/'.$this->nowDate.'/updateOrder/'.$this->nowTime.'updateRQ.json',
            json_encode($requestData));

        $token = $this->getAccessToken($order->user);

        $response = $this->httpClient->executePostCall($this->baseUrl, '/admin/v2/orders/'.$order->providerOrder->provider_order_id.'/update-shipment',
            json_encode($requestData), $token);

        Storage::put('sallaRequests/'.$this->nowDate.'/updateOrder/'.$this->nowTime.'updateRS.json',
            $response);

        return $response;
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
