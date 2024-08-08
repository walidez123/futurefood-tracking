<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderClientCollection extends ResourceCollection
{
    public function toArray($request)
    {

        return [
            'data' => $this->collection->map(function ($data) {

                if ($data->work == 1) {
                    return [
                        'id' => $data->id,
                        'order_id' => $data->order_id,
                        'tracking_number' => $data->tracking_id,
                        'delegate name' => ! empty($data->delegate) ? $data->delegate->name : '',
                        'client_name' => $data->receved_name,
                        'client_phone' => $data->receved_phone,
                        'client_email' => $data->receved_email,
                        'client_city' => ! empty($data->recevedCity) ? $data->recevedCity->title : '',
                        'client_address' => $data->receved_address,
                        'address_details' => $data->receved_address_2,
                        'amount' => $data->amount,
                        'order_status' => $data->status->title,
                        'pickup_date' => $data->pickup_date,
                        'reference_number' => $data->reference_number,
                        'order_contents' => $data->order_contents,
                        'amount_paid' => $data->amount_paid,

                    ];

                } else {
                    return [
                        'id' => $data->id,
                        'order_id' => $data->order_id,
                        'tracking_number' => $data->tracking_id,
                        'delegate name' => ! empty($data->delegate) ? $data->delegate->name : '',
                        'client_name' => $data->receved_name,
                        'client_phone' => $data->receved_phone,
                        // 'client_email'                      => $data->receved_email,
                        'client_city' => ! empty($data->recevedCity) ? $data->recevedCity->title : '',
                        'client_region' => ! empty($data->region) ? $data->region->title : '',
                        'address_details' => $data->receved_address_2,
                        'order_status' => $data->status->title,
                        'is_finished' => $data->is_finished,
                        'amount_paid' => $data->amount_paid,
                        'amount' => $data->amount,
                        'status' => $data->status->title,
                        'products' => $data->product->map(function ($product) {
                            return [
                                'id' => $product->id,
                                'product_name' => $product->product_name,
                                'size' => $product->size,
                                'number' => $product->number,
                                'price' => $product->price,
                            ];
                        }),

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
