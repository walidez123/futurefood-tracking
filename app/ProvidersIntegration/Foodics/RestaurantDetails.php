<?php

namespace App\ProvidersIntegration\Foodics;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class RestaurantDetails extends Foodics
{
    public function getDetails($token)
    {
        $response = Http::withHeaders([
            'Authorization' => $this->tokenType.' '.$token,
        ])->get($this->baseUrl.'/v5/whoami');

        Storage::put('/foodicsRequests/'.$this->nowDate.'/getMerchantDetails/'.$this->nowTime.'getDetails.json',
            $response->body());

        return $response;
    }
}
