<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Request_join_service_provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Request_join_service_providerController extends Controller
{
    public function __construct()
    {
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:request_join_service_providers',
            'manger_phone' => 'required|max:10|starts_with:05|unique:request_join_service_providers,manger_phone',
            'city_id' => 'required|numeric',
            'num_employees' => 'required|numeric',
            'num_cars' => 'required|numeric',
            'is_transport' => 'required|numeric',

        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            // Validation failed
            return response()->json([
                'message' => $validator->messages(),
            ]);
        } else {
            $delegateData = $request->all();
            $delegateData['manger_phone'] = '966'.$request->manger_phone;

            $delegate = Request_join_service_provider::create($delegateData);
            if ($delegate) {
                return response()->json([
                    'success' => 1,
                    'message' => __('api_massage.Your application to join has been successfully registered.'),
                ], 200);
            }

            return response()->json([
                'success' => 0,
                'message' => __('api_massage.try again'),
            ], 500);
        }

    }
}
