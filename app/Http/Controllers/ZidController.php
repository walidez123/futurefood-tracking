<?php

namespace App\Http\Controllers;

use App\Jobs\SaveMerchantDataFromProvider;
use App\Models\User;
use App\ProvidersIntegration\Zid\MerchantDetails;
use App\Services\Adaptors\Zid\Zid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ZidController extends Controller
{
    public function redirect()
    {
        $queries = http_build_query([
            'client_id' => config('zid.client_id'),
            'redirect_uri' => url('/zid/callback'),
            'response_type' => 'code',
        ]);

        return redirect(config('zid.auth_url').'/oauth/authorize?'.$queries);
    }

    public function callback(Request $request)
    {
        $response = Http::post(config('zid.auth_url').'/oauth/token', [
            'grant_type' => 'authorization_code',
            'client_id' => config('zid.client_id'),
            'client_secret' => config('zid.client_secrete'),
            'redirect_uri' => url('/zid/callback'),
            'code' => $request->code, // grant code
        ]);
        if ($response->ok()) {
            $responseData = $response->json();
            $merchantDetails = new MerchantDetails();
            $details = $merchantDetails->getDetails($responseData['authorization'], $responseData['access_token']);
            if ($details->ok()) {
                $data = json_decode($details, true);
                $merchant = User::where('merchant_id', $data['user']['store']['id'])->first();
                if (is_null($merchant)) {
                    $zidAdaptor = new Zid();
                    $merchantDataDetails = $zidAdaptor->merchantDetails($details, $responseData);
                    dispatch((new SaveMerchantDataFromProvider($merchantDataDetails, $data)));
                    $merchant = User::where('merchant_id', $data['user']['store']['id'])->first();
                } else {
                    $merchant->is_active = 1;
                    $merchant->provider_access_token = $responseData['access_token'];
                    $merchant->provider_refresh_token = $responseData['authorization'];
                    $merchant->provider_access_expiry = gmdate('Y-m-d H:i:s', $responseData['expires_in']);
                    $merchant->save();
                }
            }
        }

        return redirect('/');
    }
}
