<?php

namespace App\Models;

use App\Models\BaseModel;

class HeroSection extends BaseModel
{
    protected $fillable = ['title', 'subtitle', 'description', 'profile_image', 'background_image', 'background_video', 'resume_file', 'is_active', 'sort_order'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function ctas()
    {
        return $this->hasMany(HeroCta::class, 'hero_section_id')->orderBy('sort_order');
    }

    public function professions()
    {
        return $this->hasMany(RotatingProfession::class, 'hero_section_id')->orderBy('sort_order');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public static function active(): ?static
    {
        return static::query()->active()->orderBy('sort_order')->first();
    }
}
