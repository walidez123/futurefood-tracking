<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Otp_code extends Model
{
    protected $fillable = [
        'code', 'order_id', 'is_used', 'validate_to', 'status_id', 'delegate_id',
    ];
    //

    public function delegate()
    {
        return $this->belongsTo(User::class, 'delegate_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
}
