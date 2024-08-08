<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_work extends Model
{
    protected $fillable = [
        'user_id', 'work',
    ];
}
