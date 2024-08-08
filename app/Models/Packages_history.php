<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Packages_history extends Model
{
    // use SoftDeletes;
    protected $fillable = [
        'Client_packages_good', 'number', 'type', 'order_id', 'user_id',

    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');

    }

    public function Pickup_order()
    {
        return $this->belongsTo(Pickup_order::class, 'order_id');

    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse_branche::class, 'warehouse_id');
    }

    public function Client_packages_good()
    {

        return $this->belongsTo(Client_packages_good::class, 'packages_good_id');

    }
}
