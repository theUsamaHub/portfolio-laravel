<?php

namespace App\Models;

use App\Models\BaseModel;

class GalleryImage extends BaseModel
{
    protected $fillable = ['image', 'title', 'caption', 'alt_text', 'category', 'is_active', 'sort_order'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    public function scopeOfCategory($query, string $category)
    {
        return $query->where('category', $category);
    }
}
