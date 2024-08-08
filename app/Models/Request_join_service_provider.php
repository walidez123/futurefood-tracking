<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Request_join_service_provider extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'email', 'manger_phone', 'city_id', 'num_employees', 'num_cars', 'is_transport', 'is_read',
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}
