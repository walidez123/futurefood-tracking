<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyReport extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'Recipient', 'Received', 'Returned', 'total', 'delegate_id', 'date', 'client_id', 'company_id',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function delegate()
    {
        return $this->belongsTo(User::class, 'delegate_id');
    }
}
