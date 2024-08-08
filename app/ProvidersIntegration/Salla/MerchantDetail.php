<?php

namespace App\ProvidersIntegration\Salla;

use Illuminate\Support\Facades\Storage;

class MerchantDetail extends Salla
{
    public function getDetails($token)
    {
        $response = $this->httpClient->executeGetCall($this->authUrl, '/user/info', '', $token);
        Storage::put('/sallaRequests/'.$this->nowDate.'/getMerchantDetails/'.$this->nowTime.'getDetails.json',
            $response);

        return json_decode($response);
    }
}
