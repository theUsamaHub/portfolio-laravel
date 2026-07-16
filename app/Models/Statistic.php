<?php

namespace App\Models;

use App\Models\BaseModel;

class Statistic extends BaseModel
{
    protected $fillable = ['label', 'value', 'suffix', 'icon', 'is_active', 'sort_order'];

    protected function casts(): array
    {
        return [
            'value' => 'integer',
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
