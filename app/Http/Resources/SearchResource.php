<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class SearchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user = Auth::user();
        $message = $user->company_setting->what_up_message;
        $bodytag = str_replace('[order_number]', $this->order_id, $message);
        $message_ar = $user->company_setting->what_up_message_ar;
        $bodytag_ar = str_replace('[order_number]', $this->order_id, $message_ar);

        if ($this->work_type == 1 || $this->work_type==4) {
            return [
                'id' => $this->id,
                'order_id' => $this->order_id,
                'tracking_number' => $this->tracking_id,
                'store' => ! empty($this->user) ? $this->user->store_name : '',
                'store_image' => asset('storage/'.$this->user->avatar),

                'store_phone' => ! empty($this->address) ? $this->address->phone : '',
                'store_email' => ! empty($this->user) ? $this->user->email : '',
                'client_name' => $this->receved_name,
                'client_phone' => $this->receved_phone,
                'client_email' => $this->receved_email,
                'client_city' => ! empty($this->recevedCity) ? $this->recevedCity->title : '',
                'client_city_ar' => ! empty($this->recevedCity) ? $this->recevedCity->title_ar : '',

                'client_address' => $this->receved_address,
                'address_details' => $this->receved_address_2,
                'amount' => $this->amount,
                'order_status' => ! empty($this->status) ? $this->status->title : '',
                'order_status_ar' => ! empty($this->status) ? $this->status->title_ar : '',

                'what_up_massage' => $bodytag,
                'what_up_massage_ar' => $bodytag_ar,

            ];
        } else {
            return [
                'id' => $this->id,
                'order_id' => $this->order_id,
                'tracking_number' => $this->tracking_id,
                'store' => ! empty($this->user) ? $this->user->store_name : '',
                'store_image' => asset('storage/'.$this->user->avatar),

                'store_phone' => ! empty($this->address) ? $this->address->phone : '',
                'store_email' => ! empty($this->user) ? $this->user->email : '',
                'client_name' => $this->receved_name,
                'client_phone' => $this->receved_phone,
                'client_email' => $this->receved_email,
                'client_city' => ! empty($this->recevedCity) ? $this->recevedCity->title : '',
                'client_city_ar' => ! empty($this->recevedCity) ? $this->recevedCity->title_ar : '',

                'client_address' => $this->receved_address,
                'address_details' => $this->receved_address_2,
                'amount' => $this->amount,
                'amount_paid' => $this->amount_paid,
                'longitude' => $this->longitude,
                'latitude' => $this->latitude,

                'order_status' => ! empty($this->status) ? $this->status->title : '',
                'order_status_ar' => ! empty($this->status) ? $this->status->title_ar : '',

                'what_up_massage_ar' => $bodytag_ar,
                'what_up_massage' => $bodytag,

            ];

        }
    }
}
