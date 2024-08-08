<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $dates = ['created_at'];

    protected $fillable = [
        'notification_from', 'title', 'message', 'notification_type', 'notification_to', 'notification_to_type', 'is_readed', 'order_id',
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

    public function scopeUnread($query)
    {
        return $query->where('is_readed', 0);
    }

    public function scopeRead($query)
    {
        return $query->where('is_readed', 1);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'notification_from');
    }

    public function recipient()
    {
        return $this->belongsTo(User::class, 'notification_to');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
