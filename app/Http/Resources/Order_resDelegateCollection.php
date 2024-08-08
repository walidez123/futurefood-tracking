<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class Order_resDelegateCollection extends ResourceCollection
{
    public function toArray($request)
    {

        return [
            'data' => $this->collection->map(function ($data) {
                $user = Auth::user();
                $message = $user->company_setting->what_up_message;
                $message_ar = $user->company_setting->what_up_message_ar;

                $bodytag = str_replace('[order_number]', $data->order_id, $message);
                $bodytag_ar = str_replace('[order_number]', $data->order_id, $message_ar);

                $bodytag = str_replace('[store_name]', ! empty($data->user) ? $data->user->store_name : '', $bodytag);
                $bodytag_ar = str_replace('[store_name]', ! empty($data->user) ? $data->user->store_name : '', $bodytag_ar);

                $payment_method=__("app.cash");

        if($data->payment_method==1)
        {
            $payment_method=__("app.cash");
        }
        elseif($data->payment_method==2)
        {
            $payment_method=__("app.network");

        }
        elseif($data->payment_method==3)
        {
            $payment_method=__("app.online");

        }

                return [
                    'id' => $data->id,
                    'order_id' => $data->order_id,
                    'store' => ! empty($data->user) ? $data->user->store_name : '',
                    'store_image' => ! empty($data->user) ? $data->user->avatar : '',
                    'store_branch' => ! empty($data->address) ? $data->address->address : '',
                    'store_longitude' => !empty($data->address) ? $data->address->longitude : '',
                    'store_latitude' => !empty($data->address) ? $data->address->latitude : '',
                    'store_google_link' => !empty($data->address) ? $data->address->link : '',

                    'client_name' => $data->receved_name,
                    'client_phone' => $data->receved_phone,
                    'order_status' => ! empty($data->status) ? $data->status->title : '',
                    'order_status_ar' => ! empty($data->status) ? $data->status->title_ar : '',
                    'amount_paid' => $data->amount_paid,
                    'reference_number' => $data->reference_number, 
                    'amount' => $data->amount,
                    'longitude' => $data->longitude,
                    'latitude' => $data->latitude,
                    'what_up_massage' => $bodytag,
                    'what_up_massage_ar' => $bodytag_ar,
                    'payment_method'=>$payment_method,


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
