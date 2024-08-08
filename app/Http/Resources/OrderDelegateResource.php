<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;


class OrderDelegateResource extends JsonResource
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

        if ($this->work_type == 1 ) {
            return [
                'id' => $this->id,
                'order_id' => $this->order_id,
                'tracking_number' => $this->tracking_id,
                'store' => ! empty($this->user) ? $this->user->store_name : '',
                'store_image' => ! empty($this->user) ? $this->user->avatar : '',
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

                'pickup_date' => $this->pickup_date,
                'available_collect_order_status' => $this->available_collect_order_status,
                'number_count' => $this->number_count,
                'reference_number' => $this->reference_number,
                'order_contents' => $this->order_contents,
                'call_count' => $this->call_count,
                'whatApp_count' => $this->whatApp_count,
                'is_finished' => $this->is_finished,
                'amount_paid' => $this->amount_paid,
                'order_weight' => $this->order_weight,
                'over_weight_price' => $this->over_weight_price,
                'cost_reshipping_out_city' => $this->cost_reshipping_out_city,
                'real_image_confirm' => $this->real_image_confirm,

                'what_up_massage' => $bodytag,
                'what_up_massage_ar' => $bodytag_ar,

            ];

        } elseif($this->work_type == 4) {
            return [
                'id' => $this->id,
                'order_id' => $this->order_id,
                'tracking_number' => $this->tracking_id,
                'store' => ! empty($this->user) ? $this->user->store_name : '',
                'store_image' => ! empty($this->user) ? $this->user->avatar : '',
                'store_phone' => ! empty($this->address) ? $this->address->phone : '',
                'store_email' => ! empty($this->user) ? $this->user->email : '',
                'client_name' => $this->receved_name,
                'client_phone' => $this->receved_phone,
                'client_email' => $this->receved_email,
                'client_city' => ! empty($this->recevedCity) ? $this->recevedCity->title : '',
                'client_city_ar' => ! empty($this->recevedCity) ? $this->recevedCity->title_ar : '',
                'client_region' => ! empty($this->region) ? $this->region->title : '',
                'client_region_ar' => ! empty($this->region) ? $this->region->title_ar : '',
                'address_details' => $this->receved_address_2,
                'order_status' => ! empty($this->status) ? $this->status->title : '',
                'order_status_ar' => ! empty($this->status) ? $this->status->title_ar : '',
                'available_collect_order_status' => $this->available_collect_order_status,
                'number_count' => $this->number_count,
                'call_count' => $this->call_count,
                'whatApp_count' => $this->whatApp_count,
                'is_finished' => $this->is_finished,
                'amount_paid' => $this->amount_paid,
                'amount' => $this->amount,
                'longitude' => $this->longitude,
                'latitude' => $this->latitude,
                'what_up_massage' => $bodytag,
                'what_up_massage_ar' => $bodytag_ar,
                'goods' => OrderGoodsResource::collection($this->goods()->get()),


            ];

        }

    }
}
