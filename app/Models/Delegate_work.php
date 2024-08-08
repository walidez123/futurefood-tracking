<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delegate_work extends Model
{
    protected $fillable = [
        'delegate_id', 'work',
    ];
}