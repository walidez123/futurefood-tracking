<?php

namespace App\Services\Adaptors\Zid;

use App\Services\Adaptors\MerchantDetails;
use App\ProvidersIntegration\Zid\Enums\OrderStatus;


class Zid
{
    public function merchantDetails($merchantDetails, $webHookData)
    {
        $data = json_decode($merchantDetails, true);
        $merchantDataDetails = new MerchantDetails();
        $merchantDataDetails->setMerchantId($data['user']['store']['id']);
        $merchantDataDetails->setAvatar($data['user']['store']['theme']['main_image']);
        $merchantDataDetails->setEmail($data['user']['email']);
        $merchantDataDetails->setLogo($data['user']['store']['theme']['main_image']);
        $merchantDataDetails->setPhone($data['user']['mobile']);
        $merchantDataDetails->setStoreId($data['user']['store']['id']);
        $merchantDataDetails->setStoreName($data['user']['store']['username']);
        $merchantDataDetails->setStoreOwnerName($data['user']['username']);
        $merchantDataDetails->setWebsite($data['user']['store']['website']);
        $merchantDataDetails->setName($data['user']['name']);
        $merchantDataDetails->setProvider('zid');
        $merchantDataDetails->setAccessToken($webHookData['access_token']);
        $merchantDataDetails->setRefreshToken($webHookData['authorization']);
        $merchantDataDetails->setAccessExpire(gmdate('Y-m-d H:i:s', $webHookData['expires_in']));

        return $merchantDataDetails;
    }

    public static function mappingDeliveryStatus($zidDeliveryStatus,$company)
    {
        return match ($zidDeliveryStatus){
            OrderStatus::processingReverse->value => $company->CompanyZidStatus->assigned_id,
            OrderStatus::inDelivery->value => $company->CompanyZidStatus->en_route_id, 
            OrderStatus::delivered->value => $company->CompanyZidStatus->delivered_id, 
            OrderStatus::canceled->value => $company->CompanyZidStatus->closed_id, 
            default => null
        };
    }
}
