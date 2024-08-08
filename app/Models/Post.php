<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Post extends Model
{
    protected $fillable = [
        'slug', 'title_en', 'title_ar', 'excerpt_en', 'excerpt_ar', 'content_en', 'content_ar',
        'post_type', 'status', 'category_id', 'image', 'meta_description', 'meta_keywords', 'user_id',
    ];

    public function dateFormatted($filedDate = 'created_at', $showTimes = false)
    {
        $format = 'Y-m-d';
        if ($showTimes) {
            $format = $format.' h:i:s a';
        }

        return $this->$filedDate->format($format);

    }

    public function trans($text)
    {
        $locale = LaravelLocalization::getCurrentLocale();
        $column = $text.'_'.$locale;

        return $this->{$column};
    }

    public function scopePublished($query)
    {
        // scope for Display posts on published date <= today
        return $query->where('status', 'published');
    }

    public function scopePage($query)
    {
        // scope for Display posts on published date <= today
        return $query->where('post_type', 'page');
    }

    public function scopePost($query)
    {
        // scope for Display posts on published date <= today
        return $query->where('post_type', 'post');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
