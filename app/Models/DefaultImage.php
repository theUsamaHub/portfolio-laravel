<?php

namespace App\Models;

use App\Models\BaseModel;

class DefaultImage extends BaseModel
{
    public $timestamps = false;

    protected $fillable = ['key', 'path', 'alt_text'];

    public static function getPath(string $key, ?string $default = null): ?string
    {
        $image = static::where('key', $key)->first();
        return $image?->path ?? $default;
    }

    public static function getUrl(string $key, ?string $default = null): string
    {
        $path = static::getPath($key, $default);
        return $path ? asset('storage/' . $path) : asset('images/defaults/' . $key . '.svg');
    }
}
