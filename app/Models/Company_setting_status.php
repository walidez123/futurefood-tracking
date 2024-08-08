<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Company_setting_status extends Model
{
    protected $fillable = [
        'user_id',
        'status_pickup',
        'status_pickup_res',
        'status_return_shop',
        'status_return_res',
        'status_can_return_shop',
        'status_can_return_res ',
        'status_shop',
        'status_res',
        'cost_calc_status_Res',
        'default_status_id_Res',
        'calc_cash_delivery_status_Res',
        'cost_reshipping_status_Res',
        'cost_calc_status_inside_city',
        'cost_calc_status_outside_city',
        'default_status_id_store',
        'cost_reshipping_status_store',
        'edit_status_id_store',
        'delete_status_id_store',
        'overweight_status_inside_city',
        'overweight_status_outside_city',
        'available_collect_order_status',
        'calc_cash_delivery_fees_status',
        'cancel_order_service_provider_R',
        'cancel_order_service_provider',
        'Return_order_service_provider_R',
        'Return_order_service_provider',
        'send_order_service_provider_R',
        'send_order_service_provider'
      
     
    ];

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
}
