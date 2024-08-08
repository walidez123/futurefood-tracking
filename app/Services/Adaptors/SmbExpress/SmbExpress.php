<?php

namespace App\Services\Adaptors\SmbExpress;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;
use App\Models\CompanyServiceProvider;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class SmbExpress
{
    public static function createShipment($order)
    {
         $company=CompanyServiceProvider::where('company_id',$order->company_id)->where('service_provider_id',908)->first();
         $token=$company->auth_token;

        if ($order->amount_paid == 0) {
            $paymentMethod = 'PREPAID';

            $paymentAmount = $order->amount;
            $is_cod = 1;

        } else {
            $paymentMethod = 'COD';
            $paymentAmount = $order->amount;
            $is_cod = 0;

        }
        if (substr($order->receved_phone, 0, 2) == '05') {
            $phone = '966'.$order->receved_phone;
        } elseif (substr($order->receved_phone, 0, 2) == '+9') {
            $phone = substr($order->receved_phone, 1);

        } else {
            $phone = $order->receved_phone;
        }
        $client = new Client();
        $headers = [
           'X-API-AUTH-TOKEN' => $token
        ];

        try {
            $url = config('SmbExpress.base_url') . 'shipments';

            $options = [

                'from_address' => [
                    'name' => $order->user->company->store_name,
                    'phone' => $order->address->phone,
                    'city' => !empty($order->address) ? $order->address->city->title : '',
                    'country' => 'SA',
                    'street' =>  !empty($order->address) ? $order->address->city->title : $order->address->city->title
                ],
                'to_address' => [
                    'name' => $order->receved_name,
                    'phone' => $phone, 
                    'city' => $order->recevedCity ?  $order->recevedCity->title : 'test',
                    'country' => 'SA',
                    'street' => $order->receved_address ?  $order->receved_address : $order->recevedCity->title ,
                ], 
                'parcels'=>[[
                    'qty'=>$order->number_count,
                    'weight'=>$order->order_weight,
                ]],  
                'cod_currency' => 'SAR',
                'reference' => $order->order_id,
                'cod' => $paymentAmount,
                'delivery_description' => $order->order_contents ? $order->order_contents : $order->user->company->store_name,
                'weight' => $order->order_weight ? $order->order_weight : '',
                'pieces' => $order->number_count,
                'qty' => $order->number_count ?$order->number_count : 1 ,
            ];

            $response = $client->post($url, [
                'headers' => $headers,
                'json' => $options,
            ]);
            $responseBody = $response->getBody()->getContents();
            return $response;

            // Log the response body
            \Log::info('SMB Express createShipment response: ' . $responseBody);
            return $response;

        } catch (RequestException $e) {
            \Log::error('SMB API request failed: ' );

            if ($e->hasResponse()) {
                $responseBody = $e->getResponse()->getBody()->getContents();
                $responseData = json_decode($responseBody, true);
                
                // Handle the error message here
                $errorMessage = isset($responseData['message']) ? $responseData['message'] : 'Unknown error';
                
                // Log the error message or handle it in any other appropriate way
                \Log::error('SMB API request failed: ' . $e);
            } else {
                // Handle other types of exceptions
                \Log::error('SMB API request failed: ' . $e->getMessage());
            }

            // Return a response indicating failure
            return response()->json(['error' => 'SMB API request failed ' . $errorMessage], 422);
        }

    }

   
    public static function cancelOrder($tracking_number)
    {
          // Find the order and company service provider
        $order = Order::where('consignmentNo', $tracking_number)->first();
        $company = CompanyServiceProvider::where('company_id', $order->company_id)->first();
        $token = $company->auth_token;

        // Prepare the client and headers
        $client = new Client();
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => config('SmbExpress.api_key'),
            'Content-Type' => 'application/json',
            'X-API-AUTH-TOKEN' => $token,
        ];

        // Prepare the URL
        $url = config('SmbExpress.base_url') . 'shipments/' . $tracking_number . '/cancel';

        // Send the request
        try {
            $response = $client->post($url, [
                'headers' => $headers,
            ]);

            // Log the response
            Log::info('Cancel Order Response:', [
                'tracking_number' => $tracking_number,
                'response_status' => $response->getStatusCode(),
                'response_body' => (string) $response->getBody(),
            ]);

            return $response;
        } catch (\Exception $e) {
            // Log the exception
            Log::error('Cancel Order Error:', [
                'tracking_number' => $tracking_number,
                'error_message' => $e->getMessage(),
            ]);

            // Optionally, rethrow the exception or handle it as needed
            throw $e;
        }
    }

    public static function confirmOrder($tracking_number){
        $order=Order::where('consignmentNo',$tracking_number)->first();
        $company=CompanyServiceProvider::where('company_id',$order->company_id)->where('service_provider_id',908)->first();
         $token=$company->auth_token;
         $client = new Client();
         $headers = [
            'X-API-AUTH-TOKEN' => $token
         ];
       
 
         $url = config('SmbExpress.base_url').'shipments/'.$tracking_number.'/confirm';
         $response = $client->post($url, [
             'headers' => $headers,
         ]);
         return $response;

    }

    public static function returnOrder($tracking_number){
        $order = Order::where('consignmentNo', $tracking_number)->first();
        $company = CompanyServiceProvider::where('company_id', $order->company_id)->first();
        $token = $company->auth_token;

        // Prepare the client and headers
        $client = new Client();
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => config('SmbExpress.api_key'),
            'Content-Type' => 'application/json',
            'X-API-AUTH-TOKEN' => $token,
        ];

        // Prepare the URL
        $url = config('SmbExpress.base_url') . 'shipments/' . $tracking_number . '/return';

        // Send the request
        try {
            $response = $client->post($url, [
                'headers' => $headers,
            ]);

            // Log the response
            Log::info('return Order Response:', [
                'tracking_number' => $tracking_number,
                'response_status' => $response->getStatusCode(),
                'response_body' => (string) $response->getBody(),
            ]);

            return $response;
        } catch (\Exception $e) {
            // Log the exception
            Log::error('return Order Error:', [
                'tracking_number' => $tracking_number,
                'error_message' => $e->getMessage(),
            ]);

            // Optionally, rethrow the exception or handle it as needed
            throw $e;
        }

    }

    public static function trackOrder($tracking_number)
    {
        $order=Order::where('consignmentNo',$tracking_number)->first();
        $company=CompanyServiceProvider::where('company_id',$order->company_id)->where('service_provider_id',908)->first();

         $token=$company->auth_token;
        $client = new Client();
        $headers = [
           'X-API-AUTH-TOKEN' => $token
        ];
      

        $url = config('SmbExpress.base_url').'web/media/shipments/'.$tracking_number.'/print';
        $response = $client->get($url, [
            'headers' => $headers,
        ]);



        return $response;
    }

   

}
