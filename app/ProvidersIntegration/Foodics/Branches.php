<?php

namespace App\ProvidersIntegration\Foodics;

use App\ProvidersIntegration\Foodics\Enums\TagType;
use App\Services\Adaptors\MerchantDetails;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class Branches extends Foodics
{
    public function getBranches($tokenData, MerchantDetails $restaurantDetails, $page = 1)
    {
        $request = [
            'filter' => [
                'reference' => $restaurantDetails->merchant_id,
                // 'tags.id'    => TagType::ORDER_TAG,
                'receives_online_orders' => true,
            ],
            'page' => $page,
        ];

        Storage::put('/foodicsRequests/'.$this->nowDate.
            '/branchDetails/'.$this->nowTime.'getDetailsRQ.json',
            json_encode($request));

        $response = Http::withHeaders([
            'Authorization' => $this->tokenType.' '.$tokenData['access_token'],
        ])->get($this->baseUrl.'/v5/branches');

        Storage::put('/foodicsRequests/'.$this->nowDate.
            '/branchDetails/'.$this->nowTime.'getDetailsRS.json',
            $response->body());

        return $response;
    }

    public function getBranchDetails($branchId, $token)
    {
        $response = Http::withHeaders([
            'Authorization' => $this->tokenType.' '.$token,
        ])->get($this->baseUrl.'/v5/branches/'.$branchId);

        Storage::put('/foodicsRequests/'.$this->nowDate.
            '/oneBranchDetails/'.$this->nowTime.'getDetailsRS.json',
            $response->body());

        return $response;
    }
}
