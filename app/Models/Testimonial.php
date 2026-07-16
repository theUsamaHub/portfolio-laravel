<?php

namespace App\Models;

use App\Models\BaseModel;

class Testimonial extends BaseModel
{
    protected $fillable = ['client_name', 'client_position', 'client_company', 'client_image', 'content', 'rating', 'is_featured', 'is_active', 'sort_order'];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
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
