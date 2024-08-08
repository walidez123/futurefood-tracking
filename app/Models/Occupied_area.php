<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Occupied_area extends Model
{
    protected $fillable = [
        'warehouse_id', 'cell', 'floor',
    ];
}
