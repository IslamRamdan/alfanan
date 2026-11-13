<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSpecification extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'key_ar',
        'key_en',
        'value_ar',
        'value_en',
    ];

    // العلاقة: المواصفة تتبع منتج واحد
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
