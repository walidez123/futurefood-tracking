<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WarehouseBrancheResource extends JsonResource
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
            'city_id' => $this->city_id , 
            'area' => $this->area,
            'longitude' => $this->longitude, 
            'latitude' => $this->latitude,
            'work' => $this->work,

        ];
    }
}
