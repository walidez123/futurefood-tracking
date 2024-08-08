<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BalanceResource extends JsonResource
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
            'description' => $this->description,
            'debtor' => $this->debtor,
            'creditor' => $this->creditor,
            'order' => ($this->order) ? $this->order->order_id : '',
            'date' => $this->dateFormatted('created_at', false),
        ];
    }
}
