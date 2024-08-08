<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'currency', 'order_number_characters',
        'term_en_d_1','term_ar_d_1'
    ];
}
