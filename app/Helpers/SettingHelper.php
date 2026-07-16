<?php

namespace App\Helpers;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;

class SettingHelper
{
    public static function get(string $key, mixed $default = null): mixed
    {
        $cacheKey = "setting_{$key}";

        return Cache::remember($cacheKey, 3600, function () use ($key, $default) {
            return SiteSetting::get($key, $default);
        });
    }

    public static function set(string $key, mixed $value): void
    {
        SiteSetting::set($key, $value);
        Cache::forget("setting_{$key}");
    }

    public static function getGroup(string $group): array
    {
        return Cache::remember("setting_group_{$group}", 3600, function () use ($group) {
            return SiteSetting::getGroupArray($group);
        });
    }

    public static function clearCache(): void
    {
        $settings = SiteSetting::all();
        foreach ($settings as $setting) {
            Cache::forget("setting_{$setting->key}");
        }
        Cache::forget('setting_group_*');
    }
}
