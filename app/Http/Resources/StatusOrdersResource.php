<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Order;

class StatusOrdersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $today = (new \Carbon\Carbon)->today();

        return [
            'id' => $this->id,
            'title' => $this->title,
            'title_ar' => $this->title_ar,
            'is_otp' => $this->otp_send_code,
            'send_image' => $this->send_image,
            'description' => ! empty($this->description) ? $this->description : '',
            'sort' => $this->sort, 
            'orders_count' => Order::where('status_id',$this->id)->where('updated_at', $today)->where('delegate_id',Auth()->user()->id)->where('work_type', 1)->count(),
            'order' => OrderDelegateResource::collection(Order::where('status_id',$this->id)->where('updated_at', $today)->where('delegate_id',Auth()->user()->id)->where('work_type', 1)->paginate(15)),       
        ];
    }
}
