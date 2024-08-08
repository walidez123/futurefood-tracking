<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $store_name = '';
        if ($this->client != null) {
            $store_name = $this->client->name_store;

        }

        return [
            'id' => $this->id,
            'delegate_code' => $this->delegate->code,
            'delegate_city' => $this->delegate->city->title,
            'client_name' => $store_name,
            'Recipient' => $this->Recipient,
            'Received' => $this->Received,
            'Returned' => $this->Returned,
            'total' => $this->total,
            'date' => $this->date,

        ];
    }
}
