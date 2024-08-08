<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RateOrder extends Model
{
    protected $fillable = [
        'name', 'mobile', 'rate', 'review', 'order_id', 'order_no', 'type',
    ];

    public function dateFormatted($filedDate = 'created_at', $showTimes = false)
    {
        $format = 'Y-m-d';
        if ($showTimes) {
            $format = $format.' h:i:s a';
        }

        return $this->$filedDate->format($format);

    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
