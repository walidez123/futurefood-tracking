<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Testimoinal extends Model
{
    protected $fillable = [
        'image', 'description', 'title', 'description_ar', 'title_ar',
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
