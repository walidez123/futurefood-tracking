<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Order;
use App\Models\Address;


class DistanceMatrixController extends Controller
{
    public function calculateDistance(Request $request)
    {
        $request->validate([
            'order_id' => 'required|numeric',
            'destination_location' =>'required|string',
           
        ]);
        $order = Order::where('id', $request->order_id)->first();

        $address = Address::where('id', $order->store_address_id)->first();

        if($address->map_or_link == 'map'){
            $restaurantLatitude = $address->latitude;
            $restaurantLongitude = $address->longitude;
        }
            
        else{
            $restaurantCoordinates = $this->extractCoordinatesFromUrl($address->link);
            $restaurantLatitude = $restaurantCoordinates['latitude'];
            $restaurantLongitude = $restaurantCoordinates['longitude'];
        }

        $recipientUrl = $request->destination_location;

        // Extract latitude and longitude from recipient URL
        $recipientCoordinates = $this->extractCoordinatesFromUrl($recipientUrl);
        $recipientLatitude = $recipientCoordinates['latitude'];
        $recipientLongitude = $recipientCoordinates['longitude'];

        // Call the distance matrix API with extracted coordinates
        $apiKey = 'AIzaSyDdda6Slpqu9mvk4PVUlP6858eETZ5saDw';

        $client = new Client();
        $response = $client->get("https://maps.googleapis.com/maps/api/distancematrix/json?origins=$restaurantLatitude,$restaurantLongitude&destinations=$recipientLatitude,$recipientLongitude&key=$apiKey");

        $data = json_decode($response->getBody(), true);

        // Check if response data is valid
        if (isset($data['rows'][0]['elements'][0]['distance']['text'])) {
            // Extract distance from the response
            $distance = $data['rows'][0]['elements'][0]['distance']['text'];
            return response()->json(['success' => 200,
            'distance' => $distance]);
        } else {
            // Log error and return response indicating failure
            Log::error('Distance not found in API response', ['response' => $data]);
            return response()->json(['error' => 'Distance not found in API response'], 500);
        }
    }

    private function extractCoordinatesFromUrl($url)
    {
        preg_match('/@([-0-9.]+),([-0-9.]+)/', $url, $matches);
        return [
            'latitude' => $matches[1],
            'longitude' => $matches[2]
        ];
    }
}