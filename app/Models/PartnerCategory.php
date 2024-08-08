<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerCategory extends Model
{
    protected $fillable = [
        'image', 'title', 'details',
    ];


    public function partners()
    {
        return $this->hasMany(Partner::class, 'partner_category_id');
    }
}
