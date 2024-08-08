<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlinkStatusesResource extends JsonResource
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
            // "company_id": 2,
            // "new_order_id": 41,
            // "assigned_id": 43,
            // "en_route_id": 46,
            // "delivered_id": 48,
            // "closed_id": 54,
            'new_order' => $this->new_order_id,
            'assigned' => $this->assigned_id,
            'en_route' => $this->en_route_id,
            'delivered' => $this->delivered_id,
            'closed' => $this->closed_id,

        ];
    }
}
