<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name' => 'required',
            'email' => 'nullable|email|unique:users',
            'phone' => 'required|unique:users,phone',
            'password' => 'required|min:8|confirmed',
            'tax_Number' => 'nullable|starts_with:3|numeric',
            'store_name' => 'required',
            'city_id' => 'required',
        ];

        if ($this->work == 4) {
            $rules = array_merge($rules, [
                'default_status_id' => 'required',
                'available_edit_status' => 'required',
                'available_delete_status' => 'required',
                'available_collect_order_status' => 'required',
                'available_overweight_status' => 'required',
                'available_overweight_status_outside' => 'required',
                'calc_cash_on_delivery_status_id' => 'required',
                'cost_calc_status_id_outside' => 'required',
                'cost_calc_status_id' => 'required',
                'cost_reshipping_calc_status_id' => 'required',
                'sort_by_skus_status_id' => 'required',
                'pick_process_package_status_id' => 'required',
                'print_waybill_status_id' => 'required',
                'sort_by_city_status_id' => 'required',
                'store_return_shipment_status_id' => 'required',
                'reprocess_return_shipment_status_id' => 'required',
                'receive_palette' => 'required',
                'store_palette' => 'required',
                'sort_by_suku' => 'required',
                'pick_process_package' => 'required',
                'print_waybill' => 'required',
                'sort_by_city' => 'required',
                'store_return_shipment' => 'required',
                'reprocess_return_shipment' => 'required',
            ]);
        }

        return $rules;
    }
}
