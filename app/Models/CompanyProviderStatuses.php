<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class CompanyProviderStatuses extends Model
{
    use SoftDeletes;

    protected $table = 'company_provider_statuses';

    protected $fillable = [
        'provider_name',
        'company_id',
        'new_order_id',
        'assigned_id',
        'en_route_id',
        'delivered_id',
        'pending_id',
        'charged_id',
        'delayed_id',
        'closed_id',
        'returned_id',
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
