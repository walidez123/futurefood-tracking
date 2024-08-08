<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Package extends Model
{
    protected $fillable = [
        'title_en', 'title_ar', 'description_en', 'description_ar', 'publish', 'num_days', 'price', 'area', 'publish', 'company_id',
    ];

    public function trans($text)
    {
        $locale = LaravelLocalization::getCurrentLocale();
        $column = $text.'_'.$locale;

        return $this->{$column};
    }
}
