<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyServiceProvider extends Model
{

    protected $fillable = [
        'company_id',
        'service_provider_id',
        'is_active',
        'auth_token',
    ];

    public function company()
    {
        return $this->belongsTo(User::class, 'company_id');
    }

    public function serviceProvider()
    {
        return $this->belongsTo(User::class, 'service_provider_id');
    }

    public function user_works()
    {
        return $this->hasMany(User_work::class, 'user_id','service_provider_id');
    }

}
