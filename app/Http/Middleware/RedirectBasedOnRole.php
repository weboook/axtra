<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectBasedOnRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();
            $currentRoute = $request->route()->getName();

            // Skip if already on the correct dashboard or on profile/auth routes
            if ($this->shouldSkipRedirect($currentRoute)) {
                return $next($request);
            }

            // Redirect based on user role
            switch ($user->role) {
                case 'admin':
                    // Admin can access any dashboard, so let them through
                    return $next($request);
                    
                case 'employee':
                    // Employee accessing customer dashboard should be redirected to employee dashboard
                    if ($currentRoute === 'dashboard') {
                        return redirect()->route('employee.dashboard');
                    }
                    break;
                    
                case 'customer':
                    // Customer accessing admin/employee dashboards should be redirected to customer dashboard
                    if (str_starts_with($currentRoute, 'admin.') || str_starts_with($currentRoute, 'employee.')) {
                        return redirect()->route('dashboard');
                    }
                    break;
            }
        }

        return $next($request);
    }

    /**
     * Determine if we should skip the role-based redirect
     */
    private function shouldSkipRedirect(?string $currentRoute): bool
    {
        if (!$currentRoute) {
            return true;
        }

        $skipRoutes = [
            'profile.show',
            'profile.edit',
            'auth.google',
            'auth.apple',
            'login',
            'register',
            'password.request',
            'password.email',
            'password.reset',
            'password.update',
            'verification.notice',
            'verification.verify',
            'verification.send',
            'leaderboard.public',
        ];

        return in_array($currentRoute, $skipRoutes) ||
               str_starts_with($currentRoute, 'profile.') ||
               str_starts_with($currentRoute, 'auth.') ||
               str_starts_with($currentRoute, 'password.') ||
               str_starts_with($currentRoute, 'verification.');
    }
}
