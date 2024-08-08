<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Company_setting extends Model
{
    protected $fillable = [
        'title', 'title_ar',
        'company_id', 'sms_username', 'sms_password', 'sms_mobile', 'sms_sender_name', 'logo', 'email', 'phone', 'address', 'status_pickup', 'status_pickup_res', 'status_return_shop',
        'status_return_res', 'status_can_return_shop', 'status_can_return_res', 'status_shop', 'status_res', 'token', 'terms_en', 'terms_ar', 'term_en_res', 'term_ar_res', 'what_up_message',
         'what_up_message_ar', 'Message_service_provider', 'term_en_warehouse', 'term_ar_warehouse',
        'cost_calc_status_Res', 'default_status_id_Res', 'calc_cash_delivery_status_Res', 'cost_reshipping_status_Res',
        'stutus_fulfilment',

        'cost_calc_status_inside_city', 'cost_calc_status_outside_city', 'default_status_id_store', 'calc_cash_delivery_fees_status_store', 'cost_reshipping_status_store', 'edit_status_id_store',
        'delete_status_id_store', 'overweight_status_inside_city', 'overweight_status_outside_city', 'available_collect_order_status',
        'cancel_order_service_provider_R','cancel_order_service_provider_F', 'cancel_order_service_provider','Return_order_service_provider_F', 'Return_order_service_provider_R', 'Return_order_service_provider', 'send_order_service_provider_R','send_order_service_provider_F', 'send_order_service_provider', 'stand_number_characters', 'floor_number_characters', 'package_number_characters', 'term_en_fulfillment', 'term_ar_fulfillment', 'shelves_number_characters',
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
