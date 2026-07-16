<?php

namespace App\Models;

use App\Models\BaseModel;

class SeoSetting extends BaseModel
{
    public $timestamps = false;

    protected $fillable = [
        'page', 'meta_title', 'meta_description', 'keywords',
        'og_image', 'canonical_url', 'robots', 'schema_markup',
        'og_type', 'twitter_card', 'schema_type',
    ];

    protected function casts(): array
    {
        return ['schema_markup' => 'array'];
    }

    public static function forPage(string $page): ?static
    {
        return static::where('page', $page)->first();
    }
}
