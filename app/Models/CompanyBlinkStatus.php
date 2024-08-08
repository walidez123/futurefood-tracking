<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyBlinkStatus extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'new_order_id',
        'assigned_id',
        'en_route_id',
        'delivered_id',
        'closed_id',
    ];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function company()
    {
        return $this->belongsTo(User::class, 'company_id');
    }
}
