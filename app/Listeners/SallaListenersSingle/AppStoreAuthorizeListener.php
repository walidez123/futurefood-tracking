<?php

namespace App\Listeners\SallaListeners;

use App\Events\SallaEvents\AppStoreAuthorize;
use App\Jobs\SaveMerchantDataFromProvider;
use App\Models\User;
use App\ProvidersIntegration\Salla\MerchantDetail;
use App\Services\Adaptors\Salla\Salla;

class AppStoreAuthorizeListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(AppStoreAuthorize $event)
    {
        $merchant = User::where('provider_store_id', $event->webHookPayloadObject->merchant)->first();
        if (is_null($merchant)) {
            $merchantDetail = new MerchantDetail();
            $merchantDetails = $merchantDetail->getDetails($event->webHookPayloadObject->data->access_token);
            $sallaAdaptor = new Salla();
            $merchantDataDetails = $sallaAdaptor->merchantDetails($merchantDetails, $event->webHookPayloadObject->data);
            dispatch((new SaveMerchantDataFromProvider($merchantDataDetails)));
        } else {
            $merchant->update([
                'is_active' => 1,
                'provider_access_token' => $event->webHookPayloadObject->data->access_token,
                'provider_refresh_token' => $event->webHookPayloadObject->data->refresh_token,
                'provider_access_expiry' => gmdate('Y-m-d H:i:s', $event->webHookPayloadObject->data->expires),
            ]);
        }
    }
}
