<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceProviderCost extends Model
{
    use HasFactory;

    protected $fillable = [
        'cost_last_mile',
        'cost_restaurant',
        'cost_fulfillment',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
