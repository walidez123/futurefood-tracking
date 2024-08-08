<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestJoin extends Model
{
    protected $fillable = [
        'name', 'email', 'website', 'phone', 'store', 'address', 'is_readed',
    ];

    public function dateFormatted($filedDate = 'created_at', $showTimes = false)
    {
        $format = 'Y-m-d';
        if ($showTimes) {
            $format = $format.' h:i:s a';
        }

        return $this->$filedDate->format($format);

    }
}
