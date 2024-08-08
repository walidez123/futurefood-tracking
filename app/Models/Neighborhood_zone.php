<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Neighborhood_zone extends Model
{
    // use SoftDeletes;

    protected $fillable = [
        'zone_id', 'neighborhood_id', 'company_id',

    ];

    public function trans($text)
    {
        $locale = LaravelLocalization::getCurrentLocale();
        $column = $text.'_'.$locale;

        return $this->{$column};
    }

    public function Zone()
    {
        return $this->belongsTo(Zone::class, 'zone_id');
    }
}
