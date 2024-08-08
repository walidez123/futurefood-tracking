<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DailyReportCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function ($data) {

                return [
                    'id' => $data->id,
                    'delegate_code' => $data->delegate->code,
                    'delegate_city' => ! empty($data->delegate->city) ? $data->delegate->city->trans('title'):'',
                    'client_name' => ! empty($data->client) ? $data->client->store_name : '',
                    'delegate_name' => ! empty($data->delegate) ? $data->delegate->name : '',

                    'Recipient' => $data->Recipient,
                    'Received' => $data->Received,
                    'Returned' => $data->Returned,
                    'total' => $data->total,
                    'date' => $data->date,

                ];
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
