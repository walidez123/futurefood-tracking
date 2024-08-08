<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Zone_account extends Model
{
    protected $fillable = [
        'zone_id', 'user_id', 'cost_inside_zone', 'cost_outside_zone', 'cost_reshipping_zone', 'cost_reshipping_out_zone', 'fees_cash_on_delivery_zone', 'fees_cash_on_delivery_out_zone',
        'pickup_fees_zone', 'over_weight_per_kilo_zone', 'over_weight_per_kilo_outside_zone', 'standard_weight_zone', 'standard_weight_outside_zone',

    ];

    public function Zone()
    {
        return $this->belongsTo(Zone::class, 'zone_id');
    }

    public function regions()
    {
        return $this->belongsToMany(Neighborhood::class, 'neighborhood_zones', 'zone_id');
    }

    public function trans($text)
    {
        $locale = LaravelLocalization::getCurrentLocale();
        $column = $text.'_'.$locale;

        return $this->{$column};
    }
}
