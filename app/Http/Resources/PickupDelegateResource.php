<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;


class PickupDelegateResource extends JsonResource
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

            return [
                        'id' => $this->id,
                        'order_id' => $this->order_id,
                        'store' => ! empty($this->user) ? $this->user->store_name : '',
                        'store_image' => ! empty($this->user) ? $this->user->avatar : '',
                        'warehouse' =>  ! empty($this->warehouse) ? warehouseResource::collection($this->warehouse()->get()) : '',
                        'order_status' =>  ! empty($this->status) ? StatusResource::collection($this->status()->get()) : '',
                        'storage_types'=>$this->storage_types==1 ? __('admin_message.tablia') : __('admin_message.Carton'),
                        'size' =>  ! empty($this->size) ? SizeResource::collection($this->size()->get()) : '',
                        'delivery_service'=>$this->delivery_service==1 ? __('admin_message.Yes') : __('admin_message.No'),
                        'what_up_massage' => $bodytag,
                        'what_up_massage_ar' => $bodytag_ar,
                        'goods' => OrderGoodsResource::collection($this->Pickup_orders_good()->get()),


            ];

       

    }
}
