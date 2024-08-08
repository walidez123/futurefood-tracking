<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'default_status_id',
        'available_edit_status',
        'available_delete_status',
        'available_collect_order_status',
        'available_overweight_status',
        'available_overweight_status_outside',
        'calc_cash_on_delivery_status_id',
        'cost_calc_status_id_outside',
        'cost_calc_status_id',
        'cost_reshipping_calc_status_id',
        'receive_palette_status_id',
        'store_palette_status_id',
        'sort_by_skus_status_id',
        'pick_process_package_status_id',
        'print_waybill_status_id',
        'sort_by_city_status_id',
        'store_return_shipment_status_id',
        'reprocess_return_shipment_status_id',
        'shortage_order_quantity_f_stock',
        'restocking_order_quantity_to_stock',
        'pallet_shipping_status_id','return_pallet_status_id','wooden_pallet_status_id','palletization_status_id','segregation_pallet_status_id','packging_pallet_status_id','pallet_out_status_id','pallet_in_status_id'

    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
