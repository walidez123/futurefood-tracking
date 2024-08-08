<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Request_join_user extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'email', 'type', 'phone', 'city_id', 'region_id', 'work_type', 'Residency_number', 'type_vehicle', 'Num_vehicle', 'avatar', 'vehicle_photo', 'residence_photo', 'license_photo',
        'nationality', 'expiry_date',
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function region()
    {
        return $this->belongsTo(Neighborhood::class, 'region_id');
    }
}
