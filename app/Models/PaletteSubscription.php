<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaletteSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_packages_goods_id',
        'transaction_type_id',
        'user_id',
        'order_id',
        'cost',
        'description',
        'start_date',
        'type',
    ];

    public function clientPackagesGoods()
    {
        return $this->belongsTo(Client_packages_good::class, 'client_packages_goods_id');
    }

    public function pickupOrder()
    {
        return $this->belongsTo(Pickup_order::class, 'order_id');
    }

    public function transactionType()
    {
        return $this->belongsTo(TransactionType::class, 'transaction_type_id');
    }
}
