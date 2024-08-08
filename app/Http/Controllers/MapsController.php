<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class MapsController extends Controller
{
    public function showMap()
    {
        return view('show_map');
    }
    // public function getRoute(Request $request)
    // {
    //     $client = new Client();
    //     $locations = [
    //         '24.7136,46.6753', // Origin
    //         '24.7743,46.7386', // Destination
    //         '24.802988,46.756509', // Additional locations...
    //         '24.8011502,46.7465736',
    //         '24.7884927,46.7360454',
    //         '24.7885204,46.7359719',
    //         '24.7878866,46.7317636',
    //         '24.7868633,46.7287827',
    //         '24.786834,46.728606',
    //         '24.7871458,46.728333',
    //     ];

    //     $apiKey = 'AIzaSyDdda6Slpqu9mvk4PVUlP6858eETZ5saDw';

    //    try {
    //     // Use Distance Matrix API to get the route and duration
    //         $response = $client->request('GET', 'https://maps.googleapis.com/maps/api/distancematrix/json', [
    //             'query' => [
    //                 'origins' => implode('|', $locations),
    //                 'destinations' => implode('|', $locations),
    //                 'key' => $apiKey,
    //             ],
    //         ]);

    //         $body = $response->getBody();
    //         $data = json_decode($body, true);
    //         // dd( $data);

    //         // Pass data to the view
    //         return view('map', compact('data'));

    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }

    public function getRoute(Request $request)
    {
        if (count($request->input('waypoints')) > 8) {
            return back()->with('error', 'يجب ادخال عدد نقاط اضافيه 8 او اقل ');

        }
        $client = new Client();
        // Retrieve input from the form
        $origin = $request->input('origin');
        $destination = $request->input('destination');
        $waypoints = $request->input('waypoints');

        // Format the locations into an array
        $locations = [$origin, $destination];
        if ($waypoints) {
            $locations = array_merge($locations, $waypoints);
        }

        $apiKey = 'AIzaSyDdda6Slpqu9mvk4PVUlP6858eETZ5saDw';

        try {
            // Use Distance Matrix API to get the route and duration
            $response = $client->request('GET', 'https://maps.googleapis.com/maps/api/distancematrix/json', [
                'query' => [
                    'origins' => implode('|', $locations),
                    'destinations' => implode('|', $locations),
                    'key' => $apiKey,
                ],
            ]);

            $body = $response->getBody();
            $data = json_decode($body, true);

            // Pass data to the view
            return view('map', compact('data'));

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
