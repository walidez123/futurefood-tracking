<?php

namespace App\Models;

use App\Jobs\UpdateOrderStatusInProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Pickup_orders_good extends Model
{

    // protected $dates = ['pickup_date', 'created_at'];
    protected $fillable = [
        'order_id', 'good_id', 'number', 'company_id','expiration_date'

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
    public function good()
    {
        return $this->belongsTo(Good::class);
    }
    public function goods()
    {
        return $this->belongsTo(Good::class);
    }


  

}
