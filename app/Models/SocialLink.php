<?php

namespace App\Models;

use App\Models\BaseModel;

class SocialLink extends BaseModel
{
    protected $fillable = ['platform', 'url', 'icon', 'username', 'is_active', 'sort_order', 'color'];

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
}
