<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class City extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'title_ar', 'longitude', 'latitude', 'abbreviation', 'company_id',
        'smb','aymakan','labiah','jandt','province_id',

    ];

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

    public function city_zones()
    {
        return $this->belongsTo(City_zone::class, 'city_id');
    }

    public function zone()
    {
        return $this->belongsToMany(Zone::class, 'city_zones', 'city_id');
    }
}
