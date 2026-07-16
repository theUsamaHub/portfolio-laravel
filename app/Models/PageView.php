<?php

namespace App\Models;

use App\Models\BaseModel;

class PageView extends BaseModel
{
    protected $fillable = ['path', 'user_agent', 'ip_address', 'referrer', 'country', 'device', 'browser', 'created_at'];

    public function scopeForPath($query, string $path)
    {
        return $query->where('path', $path);
    }

    public function scopeRecent($query, int $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    public static function record(string $path): static
    {
        return static::create([
            'path' => $path,
            'user_agent' => request()->userAgent(),
            'ip_address' => request()->ip(),
            'referrer' => request()->headers->get('referer'),
            'created_at' => now(),
        ]);
    }
}
