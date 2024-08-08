<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class WebSetting extends Model
{
    protected $fillable = [
        'title_en', 'title_ar', 'logo', 'description_en', 'description_ar', 'email', 'phone',
        'address_en', 'address_ar', 'about_title_en', 'about_title_ar', 'about_description_en', 'meta_keywords', 'about_description_ar',
        'image', 'facebook', 'twitter', 'instgram', 'youtube', 'linked_in', 'longitude', 'latitude', 'google_analytics_id', 'overweight_price', 'standard_weight',
        'des_Objectives_ar', 'title_Objectives_ar', 'des_Objectives_en', 'title_Objectives_en', 'image_Objectives', 'des_vision_ar', 'title_vision_ar', 'des_vision_en', 'title_vision_en', 'image_vision',
        'terms_en','terms_ar'
    ];

    public function Trans($text)
    {
        $locale = LaravelLocalization::getCurrentLocale();
        $column = $text.'_'.$locale;

        return $this->{$column};
    }
}
