<?php

namespace App\Services\Adaptors\LaBaih;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class LaBaih
{
    public static function send_order($order)
    {
        if ($order->amount_paid == 0) {
            $paymentMethod = 'PREPAID';
            $paymentAmount = 0;

        } else {
            $paymentMethod = 'COD';
            $paymentAmount = $order->amount;

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
            'Content-Type' => 'application/x-www-form-urlencoded',
            'cache-control' => 'no-cache',
        ];
        $options = [
            'form_params' => [
                'api_key' => config('labaih.api_key'),
                'customerOrderNo' => $order->id,
                'noOfPieces' => $order->number_count,
                'crates' => $order->number_count,
                'weightKgs' => $order->order_weight != null ? $order->order_weight : 1,
                // 'dimensionsCm' => '',
                'itemDescription' => $order->order_contents,
                'paymentMethod' => $paymentMethod,
                'paymentAmount' => $paymentAmount,
                'consigneeName' => $order->receved_name,
                'consigneeMobile' => $phone,
                // 'consigneePhone' => $order->receved_phone,
                'consigneeEmail' => $order->receved_email,
                'consigneeCity' => ! empty($order->recevedCity) ? $order->recevedCity->title : '',
                'consigneeCommunity' => ! empty($order->region) ? $order->region->title : '',
                'consigneeAddress' => $order->receved_address,
                // 'consigneeFlatFloor' => '',
                'consigneeLatLong' => $order->latitude.','.$order->longitude,
                // 'consigneeSplInstructions' => '',
                'store' => 'future express',
                'shipperName' => 'future express',
                'shipperMobile' => '966531938000',
                'shipperEmail' => 'info@futuretech-co.com',
                'shipperCity' => ! empty($order->senderCity) ? $order->senderCity->title : '',
                'shipperDistrict' => ! empty($order->address->neighborhood) ? $order->address->neighborhood->title : '',
                'shipperAddress' => ! empty($order->address) ? $order->address->address : '',
                'shipperLatLong' => ! empty($order->address) ? $order->address->latitude.','.$order->address->longitude : '',
                // 'pickuppoint_id' => '',
            ]];
        $url = config('labaih.base_url').'create';
        $request = new Request('POST', $url, $headers);
        $res = $client->sendAsync($request, $options)->wait();
        // echo $res->getBody();

        return $res;

    }

    public static function get_order($consignmentNo)
    {
        $client = new Client();
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'cache-control' => 'no-cache',
        ];
        $options = [
            'multipart' => [
                [
                    'name' => 'api_key',
                    'contents' => '',
                ],
            ]];
        $request = new Request('GET', config('labaih.base_url').'get?api_key='.config('labaih.api_key').'&consignmentNo='.$consignmentNo.'', $headers);
        $res = $client->sendAsync($request, $options)->wait();

        return $res;
    }

    public static function Print_Shipment_Label($consignmentNo)
    {
        $client = new Client();
        $request = new Request('GET', config('labaih.base_url').'printlabel?api_key='.config('labaih.api_key').'&consignmentNo='.$consignmentNo.'');
        $res = $client->sendAsync($request)->wait();

        return $res;

    }

    public static function Pickup_Points_Lists()
    {
        $client = new Client();
        $request = new Request('GET', config('labaih.base_url').'pickupPoints.php?api_key='.config('labaih.api_key').'');
        $res = $client->sendAsync($request)->wait();

        return $res;

    }

    public static function Cancel_order($consignmentNo)
    {

        $client = new Client();
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'cache-control' => 'no-cache',
        ];
        $options = [
            'form_params' => [
                'api_key' => config('labaih.api_key'),
                'consignmentNo' => $consignmentNo,
            ]];
        $request = new Request('POST', config('labaih.base_url').'cancel', $headers);
        $res = $client->sendAsync($request, $options)->wait();

        return $res;

    }

    public static function Return_order($consignmentNo)
    {
        $client = new Client();
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'cache-control' => 'no-cache',
        ];
        $options = [
            'form_params' => [
                'api_key' => config('labaih.api_key'),
                'consignmentNo' => $consignmentNo,
            ]];
        $request = new Request('POST', config('labaih.base_url').'return', $headers);
        $res = $client->sendAsync($request, $options)->wait();

        return $res;

    }

    public static function Trace_order($consignmentNo)
    {

        $client = new Client();
        $request = new Request('GET', config('labaih.base_url').'track?api_key='.config('labaih.api_key').'&consignmentNo='.$consignmentNo);
        $res = $client->sendAsync($request)->wait();

        return $res;
        // echo $res->getBody();

    }

    public static function print_order($consignmentNo)
    {

        $client = new Client();

        $request = new Request('GET', config('labaih.base_url').'printlabel?api_key='.config('labaih.api_key').'&consignmentNo='.$consignmentNo);
        $res = $client->sendAsync($request)->wait();

        dd($res->getBody());
        // return $res()->download('https://dev.mylabaih.com/partners/api/order/printlabel?api_key=ef1a3633146e8496fea7dcff4222fa5c0878ef9e&consignmentNo={{$order->consignmentNo}}');

        // dd($res);        echo $res->getBody();

    }
}
