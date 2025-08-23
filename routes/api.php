<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ChatbotController;
use App\Http\Controllers\Api\Notifications\TwilioController;

// Public API routes
Route::prefix('v1')->group(function () {
    
    // Chatbot endpoints (public)
    Route::post('/chatbot/message', [ChatbotController::class, 'processMessage']);
    Route::get('/chatbot/health', [ChatbotController::class, 'health']);
    
    // Public booking endpoints
    Route::get('/products', [BookingController::class, 'products']);
    Route::get('/time-slots', [BookingController::class, 'timeSlots']);
    Route::get('/availability', [BookingController::class, 'checkAvailability']);
    
    // Public leaderboard
    Route::get('/leaderboard', [UserController::class, 'leaderboard']);
    
    // Twilio webhooks (public)
    Route::post('/twilio/webhook', [TwilioController::class, 'webhook']);
});

// Authenticated API routes
Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    
    // User endpoints
    Route::get('/user', [UserController::class, 'show']);
    Route::put('/user', [UserController::class, 'update']);
    Route::get('/user/stats', [UserController::class, 'stats']);
    Route::get('/user/bookings', [UserController::class, 'bookings']);
    Route::get('/user/notifications', [UserController::class, 'notifications']);
    Route::put('/user/notifications/{id}/read', [UserController::class, 'markNotificationAsRead']);
    
    // Twilio/WhatsApp notifications
    Route::post('/notifications/whatsapp', [TwilioController::class, 'sendWhatsApp']);
    Route::post('/notifications/booking-confirmation', [TwilioController::class, 'sendBookingConfirmation']);
    Route::post('/notifications/reminder', [TwilioController::class, 'sendReminder']);
    Route::get('/notifications/status', [TwilioController::class, 'getStatus']);
    
    // Booking endpoints
    Route::apiResource('bookings', BookingController::class);
    Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel']);
    Route::get('/bookings/{booking}/participants', [BookingController::class, 'participants']);
    Route::post('/bookings/{booking}/check-in', [BookingController::class, 'checkIn']);
    
    // Payment endpoints
    Route::post('/payments', [PaymentController::class, 'store']);
    Route::get('/payments/{payment}', [PaymentController::class, 'show']);
    Route::post('/payments/{payment}/refund', [PaymentController::class, 'refund']);
    
    // Admin/Employee only endpoints
    Route::middleware('admin_or_employee')->group(function () {
        Route::get('/admin/dashboard/stats', [BookingController::class, 'dashboardStats']);
        Route::get('/admin/bookings', [BookingController::class, 'adminIndex']);
        Route::put('/admin/bookings/{booking}/status', [BookingController::class, 'updateStatus']);
        
        Route::get('/admin/users', [UserController::class, 'adminIndex']);
        Route::put('/admin/users/{user}/role', [UserController::class, 'updateRole']);
        
        Route::get('/admin/payments', [PaymentController::class, 'adminIndex']);
        Route::get('/admin/reports/revenue', [PaymentController::class, 'revenueReport']);
        
        // Admin notifications
        Route::post('/admin/notifications/bulk-send', [TwilioController::class, 'bulkSend']);
    });
});
