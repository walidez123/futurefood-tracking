<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Zone extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'title_ar', 'type', 'city_id', 'company_id',

    ];

    public function cites()
    {
        return $this->belongsToMany(City::class, 'city_zones', 'zone_id');
    }

    public function regions()
    {
        return $this->belongsToMany(Neighborhood::class, 'neighborhood_zones', 'zone_id');
    }

    public function trans($text)
    {

        $locale = LaravelLocalization::getCurrentLocale();
        if ($locale == 'ar') {
            $column = $text.'_'.$locale;

        } elseif ($locale == 'en') {
            $column = $text;

        }

        return $this->{$column};
    }
}
