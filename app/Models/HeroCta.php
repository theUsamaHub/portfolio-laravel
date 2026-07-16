<?php

namespace App\Models;

use App\Models\BaseModel;

class HeroCta extends BaseModel
{
    protected $fillable = ['hero_section_id', 'label', 'url', 'style', 'icon', 'sort_order', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function heroSection()
    {
        return $this->belongsTo(HeroSection::class);
    }
}
