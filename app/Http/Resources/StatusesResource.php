<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Order;

class StatusesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'title' => $this->title,
            'title_ar' => $this->title_ar,
            'is_otp' => $this->otp_send_code,
            'send_image' => $this->send_image,
            'restaurant_appear' => $this->restaurant_appear,
            'store_appear' => $this->shop_appear,
            'fulfillment_appear'=>$this->fulfillment_appear,
            
            'description' => ! empty($this->description) ? $this->description : '',
            'sort' => $this->sort,
            'order_number' => Order::where('status_id',$this->id)->where('delegate_id', Auth()->user()->id)->count(),


        ];
    }
}
