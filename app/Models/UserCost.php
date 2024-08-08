<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCost extends Model
{
    use HasFactory;

    protected $fillable = [
        'cost_inside_city',
        'cost_outside_city',
        'cost_reshipping',
        'cost_reshipping_out_city',
        'fees_cash_on_delivery',
        'fees_cash_on_delivery_out_city',
        'pickup_fees',
        'over_weight_per_kilo',
        'over_weight_per_kilo_outside',
        'standard_weight',
        'standard_weight_outside',
        'receive_palette',
        'pallet_subscription_type',
        'store_palette',
        'sort_by_suku',
        'pick_process_package',
        'print_waybill',
        'sort_by_city',
        'store_return_shipment',
        'reprocess_return_shipment',
        'kilos_number',
        'additional_kilo_price',
        'user_id',
        'pallet_shipping','return_pallet','wooden_pallet','palletization','segregation_pallet','packging_pallet','pallet_out','pallet_in'

    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
