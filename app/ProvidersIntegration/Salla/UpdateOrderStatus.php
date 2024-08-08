<?php

namespace App\ProvidersIntegration\Salla;

use App\Models\Order;
use App\Models\CompanySallaStatus;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UpdateOrderStatus extends Salla
{
    public function updateStatus($order)
    {
        if (! $this->isSallaOrder($order)) {
            return '';
        }

        $status_id = $order->status_id;
        $company = CompanySallaStatus::where('company_id', $order->company_id)->first();

        if (!$company) {
            return 'error'; // Handle this case appropriately
        }

        $sallaStatus = null;

        switch ($status_id) {
            case $company->new_order_id:
                $sallaStatus = 'created';
                break;
            case $company->assigned_id:
                $sallaStatus = 'in_progress';
                break;
            case $company->en_route_id:
                $sallaStatus = 'delivering';
                break;
            case $company->delivered_id:
                $sallaStatus = 'delivered';
                break;
            case $company->charged_id:
                $sallaStatus = 'shipped';
                break;
            case $company->closed_id:
                $sallaStatus = 'cancelled';
                break;
            default:
                return 'error'; // Handle unknown status_id
        }

        $token = $this->getAccessToken($order->user);

        $requestData = [
            'shipment_number' => $order->order_id,
            'status' => $sallaStatus,
            'tracking_link' => route('track.order', ['tracking_id' => $order->tracking_id]),
            'pdf_label' => 'http://future-ex.com/public/orders/' . $order->order_id . '.pdf',
        ];

        $response = Http::withToken($token)
            ->put($this->baseUrl . '/admin/v2/shipments/' . $order->providerOrder->shipping_id, $requestData);

        Log::info($response);

        Storage::put('sallaRequests/' . $this->nowDate . '/' . 'updateOrderStatus/' . $this->nowTime . 'updateStatusRs.json', $response);

        if (json_decode($response)->status == 201) {
            return 'success';
        }

        return 'error'; 
    }

    private function isSallaOrder($order)
    {
        return !is_null($order->providerOrder) && $order->providerOrder->provider_name == 'salla';
    }
}
