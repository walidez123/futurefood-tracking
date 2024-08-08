<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Request_join_service extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'request_join_id', 'service_id',
    ];

    public function services()
    {
        return $this->belongsTo(Services::class, 'service_id');
    }
}
