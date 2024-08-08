<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolePermissions extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'permission_id', 'role_id',
    ];
}
