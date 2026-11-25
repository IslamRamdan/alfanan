<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'icon',
        'name',
        'name_en',
        'description',
        'description_en',
        'price',
        'currency',
        'badge',
        'badge_en',
        'is_featured',
        'is_active',
        'features',
        'features_en',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'features' => 'array',
        'features_en' => 'array',
    ];
}
