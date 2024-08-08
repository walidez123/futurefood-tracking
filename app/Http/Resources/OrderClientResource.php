<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class OrderClientResource extends JsonResource
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
        if ($user->work == 1) {

            return [
                'id' => $this->id,
                'order_id' => $this->order_id,
                'tracking_number' => $this->tracking_id,
                'delegate name' => ! empty($this->delegate) ? $this->delegate->name : '',

                'ship_date' => $this->pickup_date,
                'client_name' => $this->receved_name,
                'client_phone' => $this->receved_phone,
                'client_email' => $this->receved_email,
                'client_city' => $this->recevedCity->title,
                'client_address' => $this->receved_address,
                'address_details' => $this->receved_address_2,
                'amount' => $this->amount,
                'order_status' => $this->status->title,
                'amount_paid' => $this->amount_paid,

            ];

        } else {
            return [
                'id' => $this->id,
                'order_id' => $this->order_id,
                'tracking_number' => $this->tracking_id,
                'ship_date' => $this->updated_at,
                'store' => ! empty($this->user) ? $this->user->store_name : '',
                'store_image' => ! empty($this->user) ? $this->user->avatar : '',
                'store_phone' => $this->sender_phone,
                'store_email' => ! empty($this->user) ? $this->user->email : '',
                'store_branch' => ! empty($this->address) ? $this->address->description : '',
    
                'store_longitude' => ! empty($this->address) ? $this->address->longitude : '',
                'store_latitude' => ! empty($this->address) ? $this->address->latitude : '',
                'store_google_link' => !empty($data->address) ? $this->address->link : '',
                'delegate name' => ! empty($this->delegate) ? $this->delegate->name : '',

                'client_name' => $this->receved_name,
                'client_phone' => $this->receved_phone,
                'client_email' => $this->receved_email,
                'client_city' => ! empty($this->recevedCity) ? $this->recevedCity->title : '',
                'client_address' => $this->receved_address,
                'address_details' => $this->receved_address_2,
                'amount' => $this->amount,
                'order_status' => $this->status->title,
                'status_id' => $this->status_id,

                'amount_paid' => $this->amount_paid,
                'number_count' => $this->number_count, 
                'reference_number' => $this->reference_number, 
                'longitude' => $this->longitude,
                'latitude' => $this->latitude,

            ];
        }

    }
}
