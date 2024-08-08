<?php

namespace App\Services\Adaptors\Foodics;

use App\ProvidersIntegration\Foodics\Enums\OrderDeliveryStatus;
use App\Services\Adaptors\MerchantDetails;

class Foodics
{
    public function restaurantDetails($restaurantResponse, $tokenResponse)
    {
        $restaurant = $restaurantResponse['data'];
        $merchantDetails = new MerchantDetails();
        $merchantDetails->setMerchantId($restaurant['business']['reference']);
        $merchantDetails->setName($restaurant['user']['name']);
        $merchantDetails->setProvider('foodics');
        $merchantDetails->setStoreId($restaurant['business']['id']);
        $merchantDetails->setStoreName($restaurant['business']['name']);
        $merchantDetails->setStoreOwnerName($restaurant['user']['name']);
        $merchantDetails->setAccessToken($tokenResponse['access_token']);
        $merchantDetails->setPhone($restaurant['user']['phone']);
        $merchantDetails->setEmail($restaurant['user']['email']);
        // $merchantDetails->setStoreType(2);
        $merchantDetails->setStoreType($restaurant['user']['company_id']);
        $merchantDetails->setRefreshToken($tokenResponse['refresh_token']);
        $merchantDetails->setAccessExpire(now()->addSeconds($tokenResponse['expires_in']));

        return $merchantDetails;
    }

    public static function mappingDeliveryStatus($foodicsDeliveryStatus, $company)
    {
        return match ($foodicsDeliveryStatus) {
            OrderDeliveryStatus::ASSIGNED->value => $company->companyFoodicsStatus->assigned_id, //16
            OrderDeliveryStatus::EN_ROUTE->value => $company->companyFoodicsStatus->en_route_id, //17,
            OrderDeliveryStatus::DELIVERED->value => $company->companyFoodicsStatus->delivered_id, //18,
            OrderDeliveryStatus::CLOSED->value => $company->companyFoodicsStatus->closed_id, //34,
            default => null
        };
    }

    public static function reverseMapDeliveryStatus($orderStatus, $company)
    {
        return match ($orderStatus) {
            $company->companyFoodicsStatus->assigned_id => OrderDeliveryStatus::ASSIGNED, //16
            $company->companyFoodicsStatus->en_route_id => OrderDeliveryStatus::EN_ROUTE, //17
            $company->companyFoodicsStatus->delivered_id => OrderDeliveryStatus::DELIVERED, //18
            $company->companyFoodicsStatus->closed_id => OrderDeliveryStatus::CLOSED, //34

            default => null
        };
    }
}
