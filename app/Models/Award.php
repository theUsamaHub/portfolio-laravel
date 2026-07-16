<?php

namespace App\Models;

use App\Models\BaseModel;

class Award extends BaseModel
{
    protected $fillable = ['name', 'organization', 'date', 'description', 'image', 'url', 'is_active', 'sort_order'];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'is_active' => 'boolean',
        ];
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
