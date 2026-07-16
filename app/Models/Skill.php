<?php

namespace App\Models;

use App\Models\BaseModel;

class Skill extends BaseModel
{
    protected $fillable = ['skill_category_id', 'name', 'slug', 'icon', 'percentage', 'description', 'is_featured', 'is_active', 'sort_order'];

    protected function casts(): array
    {
        return [
            'percentage' => 'integer',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function category()
    {
        return $this->belongsTo(SkillCategory::class, 'skill_category_id');
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
