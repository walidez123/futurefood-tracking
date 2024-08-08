<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class TransactionType extends Model
{
    use HasFactory;

    protected $fillable = [
        'type', 'description', 'description_ar',

    ];

    public function trans($text)
    {

        $locale = LaravelLocalization::getCurrentLocale();
        if ($locale == 'ar') {
            $column = $text.'_'.$locale;

        } elseif ($locale == 'en') {
            $column = $text;

        }

        return $this->{$column};
    }

    public function clientTransaction()
    {
        return $this->hasOne(ClientTransaction::class);
    }

    public function companyTransaction()
    {
        return $this->hasOne(CompanyTransaction::class);
    }
}
