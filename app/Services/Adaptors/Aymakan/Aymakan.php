<?php

namespace App\Services\Adaptors\Aymakan;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;


class Aymakan
{
    public static function createShipment($order)
    {
        try {
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
                'Accept' => 'application/json',
                'Authorization' => config('aymakan.api_key'),
                'Content-Type' => 'application/json',
            ];
            $body = [
                    'requested_by' => "SSL",
                    'declared_value' => $paymentAmount,
                    'declared_value_currency' => 'SAR',
                    'reference' => $order->order_id,
                    'is_cod' => $is_cod,
                    'cod_amount' => $paymentAmount,
                    'currency' => 'SAR',
                    'delivery_name' => $order->receved_name,
                    'delivery_email' => $order->receved_email,
                    'delivery_city' =>  !empty($order->recevedCity) ? $order->recevedCity->title : '',
                    'delivery_neighbourhood' => ! empty($order->region) ? $order->region->title : '',
                    'delivery_address' => $order->receved_address ?  $order->receved_address : $order->recevedCity->title ,
                    'delivery_country' => 'SA',
                    'delivery_phone' =>$phone, 
                    'delivery_description' => $order->order_contents,
                    'collection_name' => $order->user->name,
                    'collection_email' => $order->user->email, 
                    'collection_city' => 'Riyadh',
                    'collection_address' => 'Almashael',
                    'collection_neighbourhood' => 'Almashael',
                    'collection_country' => 'SA',
                    'collection_phone' => '966551099216',
                    'weight' => $order->order_weight ? $order->order_weight : '',
                    'pieces' => $order->number_count,
                    'items_count' => $order->number_count,
            ];
            $url = config('aymakan.base_url').'shipping/create';

            $response = $client->post($url, [
                'headers' => $headers,
                'json' => $body,
            ]);
            return $response;

        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $responseBody = $e->getResponse()->getBody()->getContents();
                $responseData = json_decode($responseBody, true);
                
                // Handle the error message here
                $errorMessage = isset($responseData['message']) ? $responseData['message'] : 'Unknown error';
                
                // Log the error message or handle it in any other appropriate way
                \Log::error('API request failed: ' . $e);
            } else {
                // Handle other types of exceptions
                \Log::error('API request failed: ' . $e->getMessage());
            }

            // Return a response indicating failure
            return response()->json(['error' => 'API request failed ' . $errorMessage], 422);
        }

    }

    // public static function updateShipmentDeliveryAddress($order)
    // // {
    //     $client = new Client();;
    //     $headers = [
    //         'Accept' => 'application/json',
    //         'Authorization' => config('aymakan.api_key'),
    //     ];
    //     $body = [
    //         'parameters' => [
    //             'tracking' => $order->tracking_number,
    //             'delivery_name' => $order->receved_name,
    //             'delivery_city' => $order->receved_email,
    //             'delivery_phone' => ! empty($order->recevedCity) ? $order->recevedCity->title : '',
    //             'delivery_address' => $order->receved_address,

    //         ]];
    //     $url = config('aymakan.base_url').'shipping/update/delivery_address';
    //     $request = new Request('POST', $url, $headers);
    //     $response = $client->sendAsync($request, $body)->wait();

    //     return $response;

    // }

    public static function cancelOrder($tracking_number)
    {

        $client = new Client();
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => config('aymakan.api_key'),
        ];

        $options = [ 'tracking' => $tracking_number ];

        $url = config('aymakan.base_url').'shipping/';

        $request = new Request('POST', $url.'cancel', $headers);
        $response = $client->sendAsync($request, $options)->wait();

        return $response;

    }

    public static function trackOrder($tracking_number)
    {
        $client = new Client();
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => config('aymakan.api_key'),
        ];

        $url = config('aymakan.base_url').'shipping/track/'.$tracking_number;

        $request = new Request('GET', $url, $headers);

        $response = $client->sendAsync($request)->wait();

        return $response;
    }

    public static function getPulk($tracking_number)
    {
        $client = new Client();;
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => config('aymakan.api_key'),
        ];

        $options = [ 'tracking_codes' => $tracking_number ];

        $url = config('aymakan.base_url').'shipping/bulk_awb/trackings/'.$tracking_number;

        $request = new Request('GET', $url, $headers);

        $response = $client->sendAsync($request)->wait();

        return $response;
    }

}
