<?php

namespace App\Http\Controllers;

use App\Jobs\SaveMerchantDataFromProvider;
use App\Jobs\StoreBranchFromFoodics;
use App\ProvidersIntegration\Foodics\RestaurantDetails;
use App\Services\Adaptors\Foodics\Foodics;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class FoodicsController extends Controller
{
    public function callback()
    {
        $queries = http_build_query([
            'client_id' => config('foodics.client_id'),
            'redirect_uri' => route('foodics-new'), //callback
            'response_type' => 'code',
        ]);

        return redirect(config('foodics.base_url').'/authorize?'.$queries);
    }

    public function redirect()
    {
        $request = [
            'grant_type' => 'authorization_code',
            'client_id' => config('foodics.client_id'),
            'client_secret' => config('foodics.client_secrete'),
            'redirect_uri' => url('foodics-success'), //callback
            'code' => \request()->code, // grant code
        ];

        Storage::put('/foodicsRequests/'.now()->format('Y-m-d')
            .'/accessToken/'.now()->format('H-i-s').'tokenRQ.json',
            json_encode($request));

        $response = Http::post(config('foodics.base_url').'/oauth/token', $request);

        Storage::put('/foodicsRequests/'.now()->format('Y-m-d')
            .'/accessToken/'.now()->format('H-i-s').'token.json',
            $response->body());

        if ($response->ok()) {
            $responseData = $response->json();
            $accessToken = $responseData['access_token'];

            $restaurantDetails = new RestaurantDetails();
            $detailsResponse = $restaurantDetails->getDetails($accessToken);
            if ($detailsResponse->ok()) {
                $foodics = new Foodics();
                $merchantDetails = $foodics->restaurantDetails($detailsResponse->json(), $responseData);

                // dispatch((new SaveMerchantDataFromProvider($merchantDetails,$responseData)))->delay(2);
                dispatch((new SaveMerchantDataFromProvider($merchantDetails)))->delay(2);
                dispatch(new StoreBranchFromFoodics($responseData, $merchantDetails))->delay(4);
            }
        }

        return redirect('success-foodics');
    }
}
