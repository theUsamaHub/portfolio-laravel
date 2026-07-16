<?php

namespace App\Models;

use App\Models\BaseModel;

class AboutSection extends BaseModel
{
    protected $fillable = ['title', 'subtitle', 'description', 'highlights', 'profile_image', 'experience_years', 'location', 'languages', 'cv_file', 'is_active'];

    protected function casts(): array
    {
        return [
            'highlights' => 'array',
            'languages' => 'array',
            'is_active' => 'boolean',
            'experience_years' => 'integer',
        ];
    }

    public static function active(): ?static
    {
        return static::where('is_active', true)->first();
    }
}
