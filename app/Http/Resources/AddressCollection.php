<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AddressCollection extends ResourceCollection
{
    public function toArray($request)
    {

        return [
            'data' => $this->collection->map(function ($data) {

                if ($data->work == 1) {
                    return [
                        'id' => $data->id,
                        'branch' => $data->branch,
                        'address' => $data->address,
                        'description' => $data->description,
                        'phone' => $data->phone,
                        'longitude' => $data->longitude,
                        'latitude' => $data->latitude,
                        // 'created_at' => $data->created_at,
                    ];

                } else {
                    return [
                        'id' => $data->id,
                        // 'branch' => $data->branch,
                        'address' => $data->address,
                        'description' => ! empty($data->description) ? $data->description : '',
                        'phone' => ! empty($data->phone) ? $data->phone : '',
                        'city' => ! empty($data->city_id) ? $data->city->title : '',
                        // 'neighborhood' => !empty( $data->neighborhood_id) ? $data->neighborhood->title : '',
                        'main_address' => ! empty($data->main_address) ? $data->main_address : '',
                        'longitude' => ! empty($data->longitude) ? $data->longitude : '',
                        'latitude' => ! empty($data->latitude) ? $data->latitude : '',
                        // 'created_at' => $data->created_at,
                    ];

                }
            }),
        ];
    }

    public function with($request)
    {
        return [
            'success' => true,
            'status' => 200,
        ];
    }
}
