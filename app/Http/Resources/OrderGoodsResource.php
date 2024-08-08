<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderGoodsResource extends JsonResource
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
            'title_en' => ($this->goods) ? $this->goods->title_en : '',
            'title_ar' => ($this->goods) ? $this->goods->title_ar : '',
            'sku' => ($this->goods) ? $this->goods->SKUS : '',
            'number' => ($this->number) ? $this->number : '',
            'expire_date' =>($this->expiration_date) ? $this->expiration_date : '',


        ];
    }
}
