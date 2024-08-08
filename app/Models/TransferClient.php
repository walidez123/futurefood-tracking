<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferClient extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id', 'from_company_id', 'to_company_id',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function company()
    {
        return $this->belongsTo(User::class, 'to_company_id');
    }
}
