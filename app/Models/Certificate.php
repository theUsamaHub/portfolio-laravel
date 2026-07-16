<?php

namespace App\Models;

use App\Models\BaseModel;

class Certificate extends BaseModel
{
    protected $fillable = ['name', 'organization', 'issue_date', 'expiry_date', 'credential_id', 'credential_url', 'image', 'description', 'is_active', 'sort_order'];

    protected function casts(): array
    {
        return [
            'issue_date' => 'date',
            'expiry_date' => 'date',
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
