<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Good extends Model
{
    protected $fillable = [
        'title_en', 'title_ar', 'description_en', 'description_ar', 'SKUS', 'category_id', 'company_id', 'length', 'width', 'height', 'client_id',
        'has_expire_date', 'expire_date', 'image',
    ];

    public function dateFormatted($filedDate = 'created_at', $showTimes = false)
    {
        $format = 'Y-m-d';
        if ($showTimes) {
            $format = $format.' h:i:s a';
        }

        return $this->$filedDate->format($format);
    }

    public function trans($text)
    {
        $locale = LaravelLocalization::getCurrentLocale();
        $column = $text.'_'.$locale;

        return $this->{$column};
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');

    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');

    }
    public function company(){
        return $this->belongsTo(User::class, 'company_id');

    }

    public function Client_packages_good()
    {
        return $this->hasOne(Client_packages_good::class);

    }

    //

    public function Client_packages_goods()
    {
        return $this->hasMany(Client_packages_good::class);

    }

    
}
