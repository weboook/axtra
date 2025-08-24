<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AccessController
{
    /**
     * Unified access control middleware.
     * Handles role-based access, admin privileges, and dashboard view tracking.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string|null $requiredRole The required role (admin, employee, customer) or 'admin_or_employee'
     */
    public function handle(Request $request, Closure $next, string $requiredRole = null): Response
    {
        // Check authentication
        if (!auth()->check()) {
            abort(403, 'Unauthorized access - not authenticated');
        }

        $user = auth()->user();
        $userRole = $user->role;
        $currentRoute = $request->route()->getName();

        // Handle dashboard view tracking for admins
        if ($user->isAdmin()) {
            $this->trackDashboardView($request);
        }

        // Handle role-based redirects (but skip for certain routes)
        if (!$this->shouldSkipRedirect($currentRoute)) {
            $redirect = $this->getRedirectBasedOnRole($user, $currentRoute);
            if ($redirect) {
                return $redirect;
            }
        }

        // Handle access control
        if ($requiredRole) {
            switch ($requiredRole) {
                case 'admin':
                    if ($userRole !== 'admin') {
                        abort(403, 'Admin access required');
                    }
                    break;

                case 'employee':
                    // Admins can access employee routes
                    if (!in_array($userRole, ['admin', 'employee'])) {
                        abort(403, 'Employee access required');
                    }
                    break;

                case 'customer':
                    // Admins can access customer routes
                    if ($userRole === 'admin' || $userRole === 'customer') {
                        // Allow access
                    } else {
                        abort(403, 'Customer access required');
                    }
                    break;

                case 'admin_or_employee':
                    if (!in_array($userRole, ['admin', 'employee'])) {
                        abort(403, 'Admin or employee access required');
                    }
                    break;

                default:
                    // For any other role, check exact match (admins can access everything)
                    if ($userRole !== 'admin' && $userRole !== $requiredRole) {
                        abort(403, "Access denied - {$requiredRole} role required");
                    }
                    break;
            }
        }

        return $next($request);
    }

    /**
     * Track which dashboard view the admin is currently using.
     */
    private function trackDashboardView(Request $request): void
    {
        if ($request->routeIs('admin.*')) {
            session(['admin_dashboard_view' => 'admin']);
        } elseif ($request->routeIs('employee.*')) {
            session(['admin_dashboard_view' => 'employee']);
        } elseif ($request->routeIs(['dashboard', 'user.*'])) {
            session(['admin_dashboard_view' => 'customer']);
        }
    }

    /**
     * Get redirect response based on user role, if needed.
     */
    private function getRedirectBasedOnRole($user, ?string $currentRoute)
    {
        if (!$currentRoute) {
            return null;
        }

        switch ($user->role) {
            case 'admin':
                // Admin can access any dashboard, no redirect needed
                return null;
                
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

        return null;
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
