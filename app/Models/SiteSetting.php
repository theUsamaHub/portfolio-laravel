<?php

namespace App\Models;

use App\Models\BaseModel;

class SiteSetting extends BaseModel
{
    public $timestamps = false;

    protected $fillable = ['key', 'value', 'type', 'group', 'sort_order'];

    public static function get(string $key, mixed $default = null): mixed
    {
        $setting = static::where('key', $key)->first();
        if (!$setting) return $default;
        return $setting->castValue();
    }

    public static function set(string $key, mixed $value, string $type = 'text'): static
    {
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => is_array($value) ? json_encode($value) : $value, 'type' => $type]
        );
    }

    public static function getGroup(string $group): \Illuminate\Support\Collection
    {
        return static::where('group', $group)->orderBy('sort_order')->get();
    }

    public static function getGroupArray(string $group): array
    {
        return static::getGroup($group)->pluck('value', 'key')->toArray();
    }

    public static function forget(string $key): bool
    {
        return static::where('key', $key)->delete() > 0;
    }

    public static function setMany(array $settings, string $group): void
    {
        foreach ($settings as $key => $value) {
            static::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'group' => $group]
            );
        }
    }

    private function castValue(): mixed
    {
        return match ($this->type) {
            'boolean' => (bool) $this->value,
            'integer' => (int) $this->value,
            'json' => json_decode($this->value, true),
            default => $this->value,
        };
    }
}
