<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class packages_goods extends Model
{
    // use SoftDeletes;
    protected $fillable = [
        'client_id', 'warehouse_id', 'total_goods', 'total_packages', 'company_id', 'work','good_id',

    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse_branche::class, 'warehouse_id');
    }

    public function client_packages_good()
    {

        return $this->hasMany(Client_packages_good::class, 'packages_good_id');

    }
}
