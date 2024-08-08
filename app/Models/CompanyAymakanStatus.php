<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class CompanyAymakanStatus extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'new_order_id',
        'assigned_id',
        'en_route_id',
        'delivered_id',
        'pending_id',
        'delayed_id',
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
