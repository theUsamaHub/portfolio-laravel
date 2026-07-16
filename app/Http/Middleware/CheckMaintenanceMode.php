<?php

namespace App\Http\Middleware;

use App\Models\SiteSetting;
use App\Helpers\AuthRouteHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    public function handle(Request $request, Closure $next): Response
    {
        if (SiteSetting::get('maintenance_mode', false)) {
            // Always allow health check
            if ($request->is('up')) {
                return response('OK', 200);
            }

            // Allow admin routes
            if ($request->is('admin/*') || $request->is('admin')) {
                return $next($request);
            }

            // Allow auth routes (login, register, logout, profile)
            $loginPath = AuthRouteHelper::getLoginPath();
            $registerPath = AuthRouteHelper::getRegisterPath();
            $allowedPaths = [$loginPath, $registerPath, 'logout', 'profile', 'forgot-password', 'reset-password'];

            foreach ($allowedPaths as $path) {
                if ($request->is($path) || $request->is($path . '/*')) {
                    return $next($request);
                }
            }

            // Block everything else
            return response()->view('errors.503', [], 503);
        }

        return $next($request);
    }
}
