<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
        'category_id', // مفتاح الربط مع القسم الرئيسي
    ];

    // العلاقة: القسم الفرعي يتبع قسم رئيسي واحد
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // العلاقة: القسم الفرعي يمتلك عدة منتجات
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
