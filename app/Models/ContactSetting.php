<?php

namespace App\Models;

use App\Models\BaseModel;

class ContactSetting extends BaseModel
{
    public $timestamps = false;

    protected $fillable = ['email', 'phone', 'whatsapp', 'address', 'city', 'state', 'country', 'postal_code', 'latitude', 'longitude', 'working_hours', 'map_embed_url', 'is_active', 'created_at', 'updated_at'];

    protected function casts(): array
    {
        return [
            'working_hours' => 'array',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'is_active' => 'boolean',
        ];
    }

    public static function active(): ?static
    {
        return static::where('is_active', true)->first();
    }
}
