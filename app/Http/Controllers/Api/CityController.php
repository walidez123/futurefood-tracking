<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CitiesResource;
use App\Http\Resources\RegionsResource;
use App\Models\City;
use App\Models\Neighborhood;

class CityController extends Controller
{
    public function __construct()
    {

    }

    public function cities()
    {
        $user = Auth()->user();
        if ($user != null) {

            $cities = CitiesResource::collection(City::where('company_id', Auth()->user()->company_id)->orWhere('company_id', null)->get());
            if (count($cities) == 0) {
                return response()->json(
                    [
                        'success' => 0,
                        'message' => __('api_massage.No City found.'),

                    ]);
            } else {
                return response()->json($cities);
            }
        } else {

            $cities = CitiesResource::collection(City::where('company_id', null)->get());

            return response()->json(

                [
                    'success' => 1,
                    'message' => $cities,
                ]);

        }

    }

    public function regions($city_id)
    {
        if ($city_id) {
            $regions = RegionsResource::collection(Neighborhood::where('city_id', $city_id)->get());

            if (count($regions) == 0) {
                return response()->json([
                    'success' => 0,
                    'message' => __('api_massage.No Neighborhood found.'),
                ]);
            } else {
                return response()->json($regions);
            }
        } else {
            return response()->json([
                'success' => 0,
                'message' => __('api_massage.you shoud enter the city id'),

            ], 503);
        }

    }
}
