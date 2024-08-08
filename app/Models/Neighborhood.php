<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Neighborhood extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'title_ar', 'city_id', 'longitude', 'latitude', 'zone_id', 'company_id',
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
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

    public function Zone()
    {
        return $this->belongsTo(Zone::class, 'zone_id');
    }
}
