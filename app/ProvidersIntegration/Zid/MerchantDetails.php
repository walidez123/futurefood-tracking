<?php

namespace App\ProvidersIntegration\Zid;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class MerchantDetails extends Zid
{
    public function getDetails($token, $accessToken)
    {
        $response = Http::withHeaders([
            'X-Manager-Token' => $accessToken,
        ])
            ->withToken($token)
            ->get($this->baseUrl.'/v1/managers/account/profile');

        Storage::put('/zidRequests/'.$this->nowDate.'/getMerchantDetails/'.$this->nowTime.'getDetails.json',
            $response->body());

        return $response;
    }
}
