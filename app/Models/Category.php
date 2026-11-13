<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
    ];

    // العلاقة: القسم الرئيسي يمتلك عدة أقسام فرعية
    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }
}
