<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fcm_notification_delegate extends Model
{
    protected $fillable = [
        'fcm_notification_id', 'to',
    ];

    public function recipient()
    {
        return $this->belongsTo(User::class, 'to');
    }
}
