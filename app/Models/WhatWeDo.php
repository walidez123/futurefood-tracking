<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class WhatWeDo extends Model
{
    protected $fillable = [
        'icon_class', 'title_en', 'title_ar', 'details_en', 'details_ar',
    ];

    public function trans($text)
    {
        $locale = LaravelLocalization::getCurrentLocale();
        $column = $text.'_'.$locale;

        return $this->{$column};
    }
}
