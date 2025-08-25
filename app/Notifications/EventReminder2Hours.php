<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EventReminder2Hours extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private Booking $booking
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $customerName = $this->booking->user 
            ? $this->booking->user->name 
            : $this->booking->participant_details['guest_info']['name'];
            
        $actionUrl = route('bookings.show', $this->booking);
            
        return (new MailMessage)
            ->subject('Your Axe Throwing Event Starts Soon!')
            ->view('emails.booking.reminder-2-hours', [
                'booking' => $this->booking,
                'customerName' => $customerName,
                'actionUrl' => $actionUrl
            ]);
    }
}
