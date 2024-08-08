<?php


namespace App\Listeners\SallaListeners;

use App\Events\SallaEvents\AppStoreAuthorize;
use App\Jobs\SaveMerchantDataFromProvider;
use App\Models\User;
use App\ProvidersIntegration\Salla\MerchantDetail;
use App\Services\Adaptors\Salla\Salla;
use Illuminate\Support\Facades\Log;

class AppStoreAuthorizeListener
{
    /**
     * Handle the event.
     *
     * @param AppStoreAuthorize $event
     * @return void
     */
    public function handle(AppStoreAuthorize $event)
    {
        try {
            $merchantId = $event->webHookPayloadObject->merchant ?? null;
            $appData = $event->webHookPayloadObject->data ?? null;


            if (is_null($merchantId) || is_null($appData)) {
                Log::error('Invalid webhook payload: missing merchant or data.');
                return;
            }

            $merchant = User::where('provider_store_id', $merchantId)->first();
            $appId = $appData->id;

            if (is_null($merchant)) {
                $merchantDetail = new MerchantDetail($appId);
                $merchantDetails = $merchantDetail->getDetails($appData->access_token);

                if (is_null($merchantDetails)) {
                    Log::error('Failed to retrieve merchant details.');
                    return;
                }

                $sallaAdaptor = new Salla($appId);
                $merchantDataDetails = $sallaAdaptor->merchantDetails($merchantDetails, $appData);
                
                if ($merchantDataDetails) {
                    dispatch(new SaveMerchantDataFromProvider($merchantDataDetails, $appId));
                } else {
                    Log::error('Failed to adapt merchant details.');
                }
            } else {
                $merchant->update([
                    'is_active' => 1,
                    'provider_access_token' => $appData->access_token,
                    'provider_refresh_token' => $appData->refresh_token,
                    'provider_access_expiry' => gmdate('Y-m-d H:i:s', $appData->expires),
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error handling AppStoreAuthorize event: ' . $e->getMessage());
        }
    }
}

