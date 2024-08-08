<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Status extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'title_ar', 'description', 'delegate_appear', 'restaurant_appear', 'shop_appear', 'otp_send_code', 'company_id', 'storehouse_appear', 'client_appear',
        'send_image', 'sort', 'otp_status_send','fulfillment_appear',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'status_id');
    }

    public function service_provider_order()
    {
        return $this->hasMany(Order::class, 'status_id');
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

    // public function foodicsStatus()
    // {
    //     return $this->hasOne(CompanyFoodicsStatus::class);
    // }

}
