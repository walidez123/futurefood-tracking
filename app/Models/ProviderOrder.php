<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProviderOrder extends Model
{
    protected $fillable = [
        'provider_order_id', 'reference_id', 'shipping_id', 'status_id', 'status_name', 'provider_name',
        'order_id',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
