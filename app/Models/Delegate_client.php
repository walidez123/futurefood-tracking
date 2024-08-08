<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Delegate_client extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'delegate_id', 'client_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function delegate()
    {
        return $this->belongsTo(User::class, 'delegate_id');
    }
}
