<?php

namespace App\ProvidersIntegration\Zid;

use App\Models\Status;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\CompanyZidStatus;

class UpdateStatusOrderZid extends Zid
{
    public function updateOrderStatusZid($order)
    {
        $status_id=$order->status_id;
        $company=CompanyZidStatus::where('company_id',$order->company_id)->first();
        $status_code='indelivery';
        if($status_id==$company->new_order_id)
        {
            $status_code='ready';
        }
        if($status_id==$company->assigned_id)
        {
            $status_code='preparing';
        } if($status_id==$company->en_route_id)
        {
            $status_code='indelivery';
        } if($status_id==$company->delivered_id)
        {
            $status_code='delivered';
        } if($status_id==$company->closed_id)
        {
            $status_code='cancelled';
        }        
        $requestData = [
            'order_status' =>$status_code,
        ];
        Storage::put(
            'zidRequests/'.$this->nowDate.'/updateOrder/'.$this->nowTime.'updateRQ.json',
            json_encode($requestData)
        );

        $user=User::where('id',$order->user_id)->first();
        if ($user) {
        $refresh_token = $user->provider_refresh_token; 

        // $response = Http::post($this->baseUrl . '/oauth/token', [
        //     'grant_type' => 'refresh_token',
        //     'refresh_token' => $refresh_token,
        //     'client_id' =>  config('zid.client_id'), //application client id
        //     'client_secret' =>  config('zid.client_secrete') ,
        //     'redirect_uri' => 'http://client.test/oauth/callback',
        // ]);
        // Log::info($response);
        // enhance


        $token = $refresh_token;
        $access_token = $user->provider_access_token;
        $Authorization='Bearer '.$token;
        
        $response = Http::withHeaders(['order-id'=>$order->providerOrder->order_id,'Accept' => 'application/json', 'X-Manager-Token' => $access_token,'Authorization'=>$Authorization])
            ->post($this->baseUrl . '/v1/managers/store/orders/' . $order->providerOrder->order_id . '/change-order-status', $requestData);

        Log::info($response);
    } else {
    }
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
