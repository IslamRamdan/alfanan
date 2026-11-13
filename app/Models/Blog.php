<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_ar',
        'title_en',
        'description_ar',
        'description_en',
        'image',
        'meta_title_ar',
        'meta_title_en',
        'meta_description_ar',
        'meta_description_en',
        'meta_keywords_ar',
        'meta_keywords_en',
        'slug',
    ];

    // لتوليد الـ Slug تلقائياً من العنوان الإنجليزي (اختياري، يسهل عليك الإنشاء)
    public function setTitleEnAttribute($value)
    {
        $this->attributes['title_en'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
}
