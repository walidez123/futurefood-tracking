<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GoodsResource extends JsonResource
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
            'title' => $this->trans('title'),
            'description' => $this->trans('description'),
            'SKUS' => $this->SKUS,
            'category' =>! empty($this->category) ? $this->category->trans('title') : '',
            'length' => $this->length,
            'width' => $this->width,
            'height' => $this->height,
            'has_expire_date'=>$this->has_expire_date,
            'expire_date' => $this->expire_date,
            'in_stock'  =>$this->Client_packages_goods->sum('number')

        ];

    }
}
