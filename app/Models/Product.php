<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
        'description_ar',
        'description_en',
        'price',
        'image',
        'sub_category_id',
    ];

    // العلاقة: المنتج يتبع قسم فرعي واحد
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    // العلاقة: المنتج يمتلك عدة صور فرعية (Gallery)
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    // العلاقة: المنتج يمتلك عدة مواصفات (حتى 5 مواصفات)
    public function specifications()
    {
        return $this->hasMany(ProductSpecification::class);
    }
}
