<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Warehouse_branche extends Model
{
    protected $fillable = [
        'city_id', 'title', 'area', 'company_id', 'title_ar',
        'longitude', 'latitude', 'work',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
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
