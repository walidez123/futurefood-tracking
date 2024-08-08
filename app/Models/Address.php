<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'city_id', 'address', 'description', 'main_address',
        'phone', 'longitude', 'latitude', 'neighborhood_id', 'branch', 'link', 'map_or_link',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function neighborhood()
    {
        return $this->belongsTo(Neighborhood::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
