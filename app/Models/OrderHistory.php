<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    protected $dates = ['created_at'];

    protected $fillable = [
        'order_id', 'status_id', 'notes', 'user_id', 'latitude', 'longitude',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');

    }
}
