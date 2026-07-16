<?php

namespace App\Models;

use App\Models\BaseModel;

class Partner extends BaseModel
{
    protected $fillable = ['name', 'logo', 'url', 'description', 'is_active', 'sort_order'];

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
