<?php

namespace App\Services\Adaptors\Salla;

use App\Services\Adaptors\MerchantDetails;

class Salla
{
    public function merchantDetails($merchantDetails, $webHookData)
    {
        $merchantDataDetails = new MerchantDetails();
        $merchantDataDetails->setMerchantId($merchantDetails->data->merchant->id);
        $merchantDataDetails->setAvatar($merchantDetails->data->merchant->avatar);
        $merchantDataDetails->setEmail($merchantDetails->data->email);
        $merchantDataDetails->setLogo($merchantDetails->data->merchant->avatar);
        if (isset($merchantDetail->data->mobile)) {
            $merchantDataDetails->setPhone($merchantDetails->data->mobile);
        }
        $merchantDataDetails->setStoreId($merchantDetails->data->id);
        $merchantDataDetails->setStoreName($merchantDetails->data->merchant->name);
        $merchantDataDetails->setStoreOwnerName($merchantDetails->data->merchant->username);
        $merchantDataDetails->setWebsite($merchantDetails->data->merchant->domain);
        $merchantDataDetails->setName($merchantDetails->data->name);
        $merchantDataDetails->setProvider('salla');
        $merchantDataDetails->setAccessToken($webHookData->access_token);
        $merchantDataDetails->setRefreshToken($webHookData->refresh_token);
        $merchantDataDetails->setAccessExpire(gmdate('Y-m-d H:i:s', $webHookData->expires));

        return $merchantDataDetails;
    }
}
