<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private Booking $booking,
        private array $changes = []
    ) {}

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification for database storage.
     */
    public function toArray(object $notifiable): array
    {
        $customerName = $this->booking->user 
            ? $this->booking->user->name 
            : ($this->booking->participant_details['guest_info']['name'] ?? 'Guest Customer');
            
        return [
            'type' => 'booking_updated',
            'title' => 'Booking Updated',
            'message' => "Booking #{$this->booking->id} updated by {$customerName}",
            'booking_id' => $this->booking->id,
            'customer_name' => $customerName,
            'service_name' => $this->booking->service->name,
            'booking_date' => $this->booking->booking_date,
            'start_time' => $this->booking->start_time,
            'changes' => $this->changes,
            'action_url' => route('admin.bookings.show', $this->booking),
        ];
    }
}
