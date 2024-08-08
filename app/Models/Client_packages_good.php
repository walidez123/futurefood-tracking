<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client_packages_good extends Model
{
    // use SoftDeletes;
    protected $fillable = [
        'client_id', 'warehouse_id', 'good_id', 'packages_id', 'company_id', 'work', 'packages_good_id', 'number', 'expiration_date','order_id'

    ];

    public function good()
    {
        return $this->belongsTo(Good::class, 'good_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function package()
    {
        return $this->belongsTo(Warehouse_content::class, 'packages_id');
    }
    public function warehouse()
    {
        return $this->belongsTo(Warehouse_branche::class, 'warehouse_id');
    }

    public function packages_goods()
    {
        return $this->belongsTo(packages_goods::class, 'packages_good_id');
    }

    // PaletteSubscription

    public function PaletteSubscription()
    {
        return $this->hasOne(PaletteSubscription::class);
    }
}
