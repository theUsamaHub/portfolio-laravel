<?php

namespace App\Models;

use App\Models\BaseModel;

class Experience extends BaseModel
{
    protected $fillable = ['company', 'position', 'description', 'company_logo', 'company_url', 'location', 'employment_type', 'start_date', 'end_date', 'is_current', 'achievements', 'is_active', 'sort_order'];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'is_current' => 'boolean',
            'achievements' => 'array',
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
