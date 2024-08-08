<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Box extends Model
{
    protected $fillable = ['name_en', 'name_ar', 'box_number', 'width', 'height', 'length', 'description_en', 'description_ar', 'company_id'];

    use HasFactory;

    public function trans($text)
    {
        $locale = LaravelLocalization::getCurrentLocale();
        $column = $text.'_'.$locale;

        return $this->{$column};
    }
}
