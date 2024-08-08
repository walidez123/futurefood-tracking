<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderRulesDetail extends Model
{
    use HasFactory;

    protected $table = 'order_rules_details';

    protected $fillable = ['city_from', 'city_to', 'cod', 'details', 'title', 'region_from', 'region_to', 'client_id',
    ];

    public function city_from_rel()
    {
        return $this->belongsTo(City::class, 'city_from');
    }

    public function city_to_rel()
    {
        return $this->belongsTo(City::class, 'city_to');
    }

    public function region_from_rel()
    {
        return $this->belongsTo(Neighborhood::class, 'region_from');
    }

    public function region_to_rel()
    {
        return $this->belongsTo(Neighborhood::class, 'region_to');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }
}
