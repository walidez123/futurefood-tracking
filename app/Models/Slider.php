<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Slider extends Model
{
    protected $fillable = [
        'image', 'title_en', 'title_ar', 'details_en', 'details_ar', 'btn_title_en', 'btn_title_ar', 'btn_link',
    ];

    public function dateFormatted($filedDate = 'created_at', $showTimes = false)
    {
        $format = 'Y-m-d';
        if ($showTimes) {
            $format = $format.' h:i:s a';
        }

        return $this->$filedDate->format($format);
    }

    public function Trans($text)
    {
        $locale = LaravelLocalization::getCurrentLocale();
        $column = $text.'_'.$locale;

        return $this->{$column};
    }
}
