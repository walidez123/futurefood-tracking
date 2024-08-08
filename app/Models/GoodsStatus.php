<?php

namespace App\Models;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Database\Eloquent\Model;

class GoodsStatus extends Model
{
    protected $fillable = ['name_ar', 'name_en'];

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

    public function damagedGoods()
    {
        return $this->hasMany(DamagedGood::class);
    }
}
