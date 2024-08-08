<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class OrderPickupDelegateCollection extends ResourceCollection
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
                    return [
                        'id' => $data->id,
                        'order_id' => $data->order_id,
                        'store' => ! empty($data->user) ? $data->user->store_name : '',
                        'store_image' => ! empty($data->user) ? $data->user->avatar : '',
                        'warehouse' =>  ! empty($data->warehouse) ? warehouseResource::collection($data->warehouse()->get()) : '',
                        'order_status' =>  ! empty($data->status) ? StatusResource::collection($data->status()->get()) : '',
                        'storage_types'=>$data->storage_types==1 ? __('admin_message.tablia') : __('admin_message.Carton'),
                        'size' =>  ! empty($data->size) ? SizeResource::collection($data->size()->get()) : '',
                        'delivery_service'=>$data->delivery_service==1 ? __('admin_message.Yes') : __('admin_message.No'),
                        'what_up_massage' => $bodytag,
                        'what_up_massage_ar' => $bodytag_ar,

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
