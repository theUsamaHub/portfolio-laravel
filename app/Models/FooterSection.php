<?php

namespace App\Models;

use App\Models\BaseModel;

class FooterSection extends BaseModel
{
    protected $fillable = ['title', 'content', 'type', 'is_active', 'sort_order'];

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
