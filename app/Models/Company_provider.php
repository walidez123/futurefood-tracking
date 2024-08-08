<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Company_provider extends Model
{

    protected $fillable = [
        'user_id', 'provider_name', 'client_id', 'client_secrete', 'auth_base_url', 'base_url','tag_name',
        'active','app_id','SALLA_WEBHOOK_CLIENT_SECRET','app_type'

    ];

    

   
}
