<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class OrderResResource extends JsonResource
{
    public function toArray($request)
    {
        $user = Auth::user();
        $message = $user->company_setting->what_up_message;
        $message_ar = $user->company_setting->what_up_message_ar;

        $bodytag = str_replace('[order_number]', $this->order_id, $message);
        $bodytag_ar = str_replace('[order_number]', $this->order_id, $message_ar);
        $bodytag = str_replace('[store_name]', ! empty($this->user) ? $this->user->store_name : '', $bodytag);
        $bodytag_ar = str_replace('[store_name]', ! empty($this->user) ? $this->user->store_name : '', $bodytag_ar);
        $payment_method=__("app.cash");

        if($this->payment_method==1)
        {
            $payment_method=__("app.cash");
        }
        elseif($this->payment_method==2)
        {
            $payment_method=__("app.network");

        }
        elseif($this->payment_method==3)
        {
            $payment_method=__("app.online");

        }

        return [
            'id' => $this->id,
            'order_id' => $this->order_id,
            'tracking_number' => $this->tracking_id,
            'store' => ! empty($this->user) ? $this->user->store_name : '',
            'store_image' => ! empty($this->user) ? $this->user->avatar : '',
            'store_phone' => $this->sender_phone,
            'store_email' => ! empty($this->user) ? $this->user->email : '',
            'store_branch' => ! empty($this->address) ? $this->address->description : '',

            'store_longitude' => ! empty($this->address) ? $this->address->longitude : '',
            'store_latitude' => ! empty($this->address) ? $this->address->latitude : '',
            'store_google_link' => !empty($data->address) ? $data->address->link : '',


            'client_name' => $this->receved_name,
            'client_phone' => $this->receved_phone,
            // 'client_email'                      => $this->receved_email,
            'client_city' => ! empty($this->recevedCity) ? $this->recevedCity->title : '',
            'client_city_ar' => ! empty($this->recevedCity) ? $this->recevedCity->title_ar : '',

            'client_region' => ! empty($this->region) ? $this->region->title : '',
            'client_region_ar' => ! empty($this->region) ? $this->region->title_ar : '',

            'address_details' => $this->receved_address,
            'order_status' => ! empty($this->status) ? $this->status->title : '',
            'order_status_ar' => ! empty($this->status) ? $this->status->title_ar : '',

            'available_collect_order_status' => $this->available_collect_order_status,
            'number_count' => $this->number_count, 
            'reference_number' => $this->reference_number, 
            'call_count' => $this->call_count,
            'whatApp_count' => $this->whatApp_count,
            'is_finished' => $this->is_finished,
            'amount_paid' => $this->amount_paid,
            'amount' => $this->amount,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'real_image_confirm' => $this->real_image_confirm,
            'what_up_massage' => $bodytag,
            'what_up_massage_ar' => $bodytag_ar,
            'product' => ! empty($this->product) ? $this->product : '',
            'payment_method'=>$payment_method,

        ];

    }
}
