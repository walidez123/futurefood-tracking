<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders_rules extends Model
{
    protected $dates = ['created_at'];

    protected $fillable = [
        'company_id', 'status', 'status_id', 'max', 'delegate_id', 'city_from', 'city_to', 'cod',
        'work_type', 'details', 'title', 'created_date', 'region_from', 'region_to', 'payment_method', 'client_id', 'type', 'address_id',
    ];

    public function dateFormatted($filedDate = 'created_at', $showTimes = false)
    {
        $format = 'Y-m-d';
        if ($showTimes) {
            $format = $format.' h:i:s a';
        }

        return $this->$filedDate->format($format);

    }

    public function getDateAttribute()
    {
        // condiotn for published date is null
        return is_null($this->created_at) ? '' : $this->created_at->diffForHumans();
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function delegate()
    {
        return $this->belongsTo(User::class, 'delegate_id');
    }

    public function orderNumber()
    {
        return $this->hasMany(rules_order_numbers::class, 'rule_id')->whereDate('created_at', date('Y-m-d'));
    }

    public function order_rules_details()
    {
        return $this->hasMany(OrderRulesDetail::class, 'order_rules_id');
    }
}
