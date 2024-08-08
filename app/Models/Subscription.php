<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    protected $fillable = [
        'service_name', 'company_name', 'industry', 'user_name', 'phone_number', 'email','additional_info','is_readed'
    ];
}
