<?php

namespace App\Services;

use App\Models\User;
use App\Models\Booking;

class NotificationService
{
    public function sendBookingConfirmation(Booking $booking)
    {
        // Implementation placeholder
    }

    public function sendReminder(Booking $booking)
    {
        // Implementation placeholder
    }

    public function sendWhatsAppNotification(User $user, string $message)
    {
        // Implementation placeholder
    }
}