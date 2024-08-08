<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyCost extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'lastmile_cost',
        'food_delivery_cost',
        'warehouse_cost',
        'fulfillment_cost',
        'salla_cost',
        'foodics_cost',
        'zid_cost'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
