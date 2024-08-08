<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse_content extends Model
{
    protected $fillable = [
        'warehouse_id', 'title', 'type',
        'stand_id', 'floor_id', 'is_busy', 'work',
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse_branche::class, 'warehouse_id');
    }

    public function packages()
    {
        return $this->belongsTo(Warehouse_branche::class, 'warehouse_id');
    }
    public function stand()
    {
        return $this->belongsTo(Warehouse_content::class, 'stand_id');
    }

    public function floor()
    {
        return $this->belongsTo(Warehouse_content::class, 'floor_id');
    }
}
