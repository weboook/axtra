<?php

namespace App\Observers;

use App\Models\Booking;
use App\Models\User;
use App\Notifications\BookingCreated;
use App\Notifications\BookingUpdated;
use App\Notifications\BookingCancelled;

class BookingObserver
{
    /**
     * Handle the Booking "created" event.
     */
    public function created(Booking $booking): void
    {
        $this->notifyAdmins(new BookingCreated($booking));
    }

    /**
     * Handle the Booking "updated" event.
     */
    public function updated(Booking $booking): void
    {
        // Check if status changed to cancelled
        if ($booking->isDirty('status') && $booking->status === 'cancelled') {
            $this->notifyAdmins(new BookingCancelled($booking));
        } else {
            // Get the changed attributes
            $changes = $booking->getDirty();
            unset($changes['updated_at']); // Remove updated_at from changes
            
            if (!empty($changes)) {
                $this->notifyAdmins(new BookingUpdated($booking, $changes));
            }
        }
    }

    /**
     * Handle the Booking "deleted" event.
     */
    public function deleted(Booking $booking): void
    {
        $this->notifyAdmins(new BookingCancelled($booking, 'Booking deleted'));
    }

    /**
     * Notify all admin users
     */
    private function notifyAdmins($notification): void
    {
        $admins = User::where('role', 'admin')->get();
        
        foreach ($admins as $admin) {
            $admin->notify($notification);
        }
    }
}
