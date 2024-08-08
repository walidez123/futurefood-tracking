<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderProduct extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'order_id', 'product_name', 'size', 'number', 'price','sku'
    ];

    protected $dates = ['name_field'];

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
}
