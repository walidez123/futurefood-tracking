<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_package extends Model
{
    protected $fillable = [
        'user_id', 'package_id', 'area',
        'price', 'num_days', 'start_date', 'active', 'end_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }
}
