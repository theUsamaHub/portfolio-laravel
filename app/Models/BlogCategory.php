<?php

namespace App\Models;

use App\Models\BaseModel;

class BlogCategory extends BaseModel
{
    protected $fillable = ['name', 'slug', 'description', 'icon', 'color', 'sort_order', 'is_active', 'meta_title', 'meta_description'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
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
