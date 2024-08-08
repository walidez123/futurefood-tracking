<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company_work extends Model
{
    protected $fillable = [
        'company_id', 'work',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'company_id');
    }
}
