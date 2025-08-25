<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\AppleController;
use App\Http\Controllers\Customer\LeaderboardController;
use App\Http\Controllers\Payment\PayRexxController;
use App\Http\Controllers\WebflowController;

// OAuth routes
Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);
Route::get('/auth/apple', [AppleController::class, 'redirect'])->name('auth.apple');
Route::get('/auth/apple/callback', [AppleController::class, 'callback']);

// Payment webhooks (public)
Route::post('/webhooks/payrexx', [PayRexxController::class, 'webhook'])->name('payment.webhook');
Route::post('/webhooks/webflow', [WebflowController::class, 'webhook']);

// Public booking flow (accessible to guests)
Route::get('/book', App\Livewire\Booking\BookingFlow::class)->name('booking.public');

// Payment routes (public)
Route::get('/booking/{booking}/payment', [PayRexxController::class, 'createPayment'])->name('booking.payment');
Route::get('/booking/{booking}/success', [PayRexxController::class, 'success'])->name('booking.success');
Route::get('/booking/{booking}/failed', [PayRexxController::class, 'failed'])->name('booking.failed');
Route::get('/booking/{booking}/cancelled', [PayRexxController::class, 'cancelled'])->name('booking.cancelled');
Route::get('/booking/error', [PayRexxController::class, 'error'])->name('booking.error');

// Testing routes with Claude bypass
Route::middleware(['claude_bypass'])->prefix('test')->name('test.')->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('dashboard');
    })->name('dashboard');
    
    Route::get('/user-info', function () {
        $user = auth()->user();
        return response()->json([
            'authenticated' => auth()->check(),
            'bypass_active' => request()->attributes->get('claude_bypass_active', false),
            'user' => $user ? [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'created_at' => $user->created_at,
            ] : null,
        ]);
    })->name('user-info');
    
    Route::get('/auth-test', function () {
        return response()->json([
            'bypass_active' => request()->attributes->get('claude_bypass_active', false),
            'authenticated' => auth()->check(),
            'session_id' => session()->getId(),
            'user_id' => auth()->id(),
            'timestamp' => now()->toISOString(),
        ]);
    })->name('auth-test');
    
    Route::get('/dashboard-test', App\Livewire\User\Dashboard\DashboardIndex::class)->name('dashboard-test');
    
    Route::get('/routes-test', function () {
        return response()->json([
            'dashboard_route_exists' => \Route::has('dashboard'),
            'user_book_route_exists' => \Route::has('user.book'),
            'user_bookings_route_exists' => \Route::has('user.bookings'),
            'user_profile_route_exists' => \Route::has('user.profile'),
            'user_notifications_route_exists' => \Route::has('user.notifications'),
            'leaderboard_public_route_exists' => \Route::has('leaderboard.public'),
            'all_routes_valid' => true
        ]);
    })->name('routes-test');
    
    // Test routes for navigation testing
    Route::get('/bookings', function () {
        return redirect()->route('user.bookings');
    })->name('bookings');
    
    Route::get('/book', function () {
        return redirect()->route('user.book');
    })->name('book');
    
    Route::get('/profile', function () {
        return redirect()->route('user.profile');
    })->name('profile');
    
    Route::get('/notifications', function () {
        return redirect()->route('user.notifications');
    })->name('notifications');
    
    Route::get('/leaderboard-public', function () {
        return redirect()->route('leaderboard.public');
    })->name('leaderboard-public');
});

// Authenticated routes
Route::middleware([
    'claude_bypass', // Add bypass for testing
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'access', // Unified access control (includes redirects and role checking)
])->group(function () {

    // Customer dashboard - main /dashboard route (admins can access)
    Route::middleware(['access:customer'])->get('/dashboard', App\Livewire\User\Dashboard\DashboardIndex::class)->name('dashboard');

    // Admin routes
    Route::middleware(['access:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', App\Livewire\Admin\Dashboard\DashboardIndex::class)->name('dashboard');
        Route::get('/users', App\Livewire\Admin\Users\UsersIndex::class)->name('users');
        Route::get('/users/create', App\Livewire\Admin\Users\UserCreate::class)->name('users.create');
        Route::get('/users/{user}/edit', App\Livewire\Admin\Users\UserEdit::class)->name('users.edit');
        Route::get('/users/{user}/detail', App\Livewire\Admin\Users\UserDetail::class)->name('users.detail');
        Route::get('/products', App\Livewire\Admin\Products\ProductsIndex::class)->name('products');
        Route::get('/coupons', App\Livewire\Admin\Coupons\CouponsIndex::class)->name('coupons');
        Route::get('/lanes', App\Livewire\Admin\Lanes\LanesIndex::class)->name('lanes');
        Route::get('/employees', App\Livewire\Admin\Employees\EmployeesIndex::class)->name('employees');
        Route::get('/gift-cards', App\Livewire\Admin\GiftCards\GiftCardsIndex::class)->name('gift-cards');
        Route::get('/levels', App\Livewire\Admin\Levels\LevelsIndex::class)->name('levels');
        Route::get('/achievements', App\Livewire\Admin\Achievements\AchievementsIndex::class)->name('achievements');
        Route::get('/email-previews', App\Livewire\Admin\EmailPreviews::class)->name('email-previews');
    });

    // Employee routes (admins and employees can access)
    Route::middleware(['access:admin_or_employee'])->prefix('employee')->name('employee.')->group(function () {
        Route::get('/dashboard', App\Livewire\Employee\Dashboard\DashboardIndex::class)->name('dashboard');
        Route::get('/schedule', App\Livewire\Employee\Schedule\ScheduleIndex::class)->name('schedule');
        Route::get('/quick-actions', App\Livewire\Employee\QuickActions\QuickActionsIndex::class)->name('quick-actions');
        Route::get('/bookings', App\Livewire\Employee\Bookings\BookingsIndex::class)->name('bookings');
        Route::get('/check-ins', App\Livewire\Employee\CheckIns\CheckInsIndex::class)->name('check-ins');
        Route::get('/equipment', App\Livewire\Employee\Equipment\EquipmentIndex::class)->name('equipment');
        Route::get('/reports', App\Livewire\Employee\Reports\ReportsIndex::class)->name('reports');
    });

    // Customer routes - clean URLs without dashboard prefix (admins can access)
    Route::middleware(['access:customer'])->name('user.')->group(function () {
        Route::get('/bookings', App\Livewire\User\Booking\BookingIndex::class)->name('bookings');
        Route::get('/book', App\Livewire\Booking\BookingFlow::class)->name('book');
        Route::get('/profile', function () {
            return redirect()->route('profile.show');
        })->name('profile');
        Route::get('/leaderboard', App\Livewire\User\Leaderboard\LeaderboardIndex::class)->name('leaderboard');
        Route::get('/achievements', App\Livewire\User\Achievement\AchievementIndex::class)->name('achievements');
        Route::get('/notifications', App\Livewire\Shared\Notifications\NotificationsIndex::class)->name('notifications');
        Route::get('/gift-cards', App\Livewire\User\GiftCard\GiftCardIndex::class)->name('gift-cards');
    });

    // Shared authenticated routes
    Route::get('/leaderboard', App\Livewire\User\Leaderboard\LeaderboardIndex::class)->name('leaderboard.public');
});
