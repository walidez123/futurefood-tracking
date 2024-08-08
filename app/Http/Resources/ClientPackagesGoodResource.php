<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientPackagesGoodResource extends JsonResource
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
            'packages_good_name'=>  1,
            'client_name'=> $this->client->name ,
            'warehouse_name'=>  $this->warehouse->trans('title'),
            'good_suk'=>  $this->good->SKUS,
            'good_title'=>  $this->good->trans('title'),

            'packages_name'=>  $this->package->title,
            'work'=>  $this->work,
            'created_at' => $this->created_at->format('Y-m-d'),
            'expiration_date' => $this->expiration_date ?  $this->expiration_date : '',
            'number'=>   $this->number,
        ];
    }
}
