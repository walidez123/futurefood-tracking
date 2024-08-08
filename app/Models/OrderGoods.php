<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class OrderGoods extends Model
{
    // use SoftDeletes;

    protected $fillable = [
        'order_id', 'good_id', 'number',
    ];

    public function dateFormatted($filedDate = 'created_at', $showTimes = false)
    {
        $format = 'Y-m-d';
        if ($showTimes) {
            $format = $format.' h:i:s a';
        }

        return $this->$filedDate->format($format);

    }

    public function Order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function goods()
    {
        return $this->belongsTo(Good::class, 'good_id');
    }
}
