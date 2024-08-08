<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DamagedGoods extends Model
{
    protected $fillable = [
        'client_id',
        'warehouse_branche_id',
        'good_id',
        'warehouse_content_id',
        'goods_status_id',
        'number',
        'company_id',
    ];

    public function client()
    {
        return $this->belongsTo(User::class);
    }

    public function warehouseBranch()
    {
        return $this->belongsTo(Warehouse_branche::class, 'warehouse_branche_id');
    }

    public function goods()
    {
        return $this->belongsTo(Good::class, 'good_id');
    }

    public function warehouseContent()
    {
        return $this->belongsTo(Warehouse_content::class);
    }

    public function goodsStatus()
    {
        return $this->belongsTo(GoodsStatus::class);
    }
}
