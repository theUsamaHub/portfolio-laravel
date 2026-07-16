<?php

namespace App\Helpers;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;

class AuthRouteHelper
{
    public static function getPath(string $route): string
    {
        return Cache::remember("auth_route_{$route}", 3600, function () use ($route) {
            return SiteSetting::get("auth_{$route}_path", match($route) {
                'login' => 'a9x7k2m8',
                'register' => '7f3a9b2c',
                'forgot_password' => 'x4k8m2n9',
                'reset_password' => 'r7p3w5q1',
                default => 'login',
            });
        });
    }

    public static function getLoginPath(): string
    {
        return self::getPath('login');
    }

    public static function getRegisterPath(): string
    {
        return self::getPath('register');
    }

    public static function getForgotPasswordPath(): string
    {
        return self::getPath('forgot_password');
    }

    public static function getResetPasswordPath(): string
    {
        return self::getPath('reset_password');
    }

    public static function getAllPaths(): array
    {
        return [
            'login' => self::getLoginPath(),
            'register' => self::getRegisterPath(),
            'forgot_password' => self::getForgotPasswordPath(),
            'reset_password' => self::getResetPasswordPath(),
        ];
    }

    public static function clearCache(): void
    {
        Cache::forget('auth_route_login');
        Cache::forget('auth_route_register');
        Cache::forget('auth_route_forgot_password');
        Cache::forget('auth_route_reset_password');
    }
}
