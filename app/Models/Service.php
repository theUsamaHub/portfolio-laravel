<?php

namespace App\Models;

use App\Models\BaseModel;

class Service extends BaseModel
{
    protected $fillable = ['name', 'slug', 'description', 'icon', 'features', 'price', 'price_unit', 'is_featured', 'is_active', 'sort_order'];

    protected function casts(): array
    {
        return [
            'features' => 'array',
            'price' => 'decimal:2',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
