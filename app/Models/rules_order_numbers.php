<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class rules_order_numbers extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'order_id', 'rule_id',
    ];
}
