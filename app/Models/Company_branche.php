<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company_branche extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'company_id', 'city_id', 'title', 'is_repository',
        'phone', 'longitude', 'latitude', 'region_id',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function region()
    {
        return $this->belongsTo(Neighborhood::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
