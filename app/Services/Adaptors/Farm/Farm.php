<?php

namespace App\Services\Adaptors\Farm;

use GuzzleHttp\Client;
use App\Models\Order;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Client\RequestException as HttpClientRequestException;

class Farm
{
    public static function changeOrderStatusToDeliverd($reference_number)
    {
            $order=Order::where('reference_number',$reference_number)->first();
            $token="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJuYW1lIjoiZmFybSJ9.LQsG-G_24ssvvMPPKCUzhfHun83jTOYQ1NoMjrz_s6E";
            $url="https://stage.farm.com.sa/public/api/v1.0/orders/status";
            if($order->user_id==611)
            {
               $token="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJuYW1lIjoiZmFybSJ9.LNToX46HfyOJHTd3hEKFctRNH81O_YYpIfPwWKC8g0M";
               $url="https://go.farm.com.sa/public/api/v1.0/orders/status";
            }else{
               $token="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJuYW1lIjoiZmFybSJ9.LQsG-G_24ssvvMPPKCUzhfHun83jTOYQ1NoMjrz_s6E";
               $url="https://stage.farm.com.sa/public/api/v1.0/orders/status";
            }


        try {
            $client = new Client();
            $headers = [
                'Accept' => 'application/json',
                'Content-Language' => 'ar',
                'Authorization' => 'Bearer '.$token,
            ];

            $options = [
                'multipart' => [
                  [
                    'name' => 'order_id',
                    'contents' => $reference_number
                  ],
                  [
                    'name' => '_method',
                    'contents' => 'PUT'
                  ]
              ]];

            $request = new Request('POST', $url, $headers);
            $response = $client->sendAsync($request, $options)->wait();

            \Log::info('farm order change status to delivered: order_id ' . $reference_number);

            return $response->getBody()->getContents();
        } catch (HttpClientRequestException $e) {
            \Log::error('Farm API request failed: ' . $e->getMessage());
            return ['error' => 'Farm API request failed: ' . $e->getMessage()];
        } catch (RequestException $e) {
            
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $errorMessage = json_decode($response->getBody()->getContents(), true);
                return $errorMessage;
            } else {
                \Log::error('Farm API request failed: ' . $e->getMessage());
                return ['error' => 'Farm API request failed: ' . $e->getMessage()];
            }
        } catch (\Exception $e) {
            // Handle other exceptions
            \Log::error('Farm API request failed: ' . $e->getMessage());
            return ['error' => 'Farm API request failed: ' . $e->getMessage()];
        }
    }
}
