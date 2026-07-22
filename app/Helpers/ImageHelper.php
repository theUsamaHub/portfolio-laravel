<?php

namespace App\Helpers;

use App\Models\DefaultImage;
use Illuminate\Support\Facades\Cache;

class ImageHelper
{
    public static function url(?string $path, string $fallbackKey = 'default'): string
    {
        if ($path && \Storage::disk('public')->exists($path)) {
            return asset('storage/' . $path);
        }

        if (DefaultImage::tableExists()) {
            return DefaultImage::getUrl($fallbackKey);
        }

        return asset('images/defaults/' . $fallbackKey . '.svg');
    }

    public static function render(string $path, string $fallbackKey = 'default', string $alt = '', string $class = '', array $attributes = []): string
    {
        $url = self::url($path, $fallbackKey);
        $attrString = collect($attributes)->map(fn($v, $k) => "{$k}=\"{$v}\"")->implode(' ');

        return "<img src=\"{$url}\" alt=\"{$alt}\" class=\"{$class}\" loading=\"lazy\" {$attrString}>";
    }

    public static function exists(?string $path): bool
    {
        return $path && \Storage::disk('public')->exists($path);
    }
}
