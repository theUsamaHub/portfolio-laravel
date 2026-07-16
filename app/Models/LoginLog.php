<?php

namespace App\Models;

use App\Models\BaseModel;

class LoginLog extends BaseModel
{
    protected $fillable = ['user_id', 'email', 'status', 'ip_address', 'user_agent'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function logSuccess(string $email, ?int $userId = null): static
    {
        return static::create([
            'user_id' => $userId,
            'email' => $email,
            'status' => 'success',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    public static function logFailure(string $email): static
    {
        return static::create([
            'email' => $email,
            'status' => 'failed',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
