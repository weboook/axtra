<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReviewRequest extends Notification implements ShouldQueue
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
            
        return (new MailMessage)
            ->subject('How was your Axe Throwing Experience?')
            ->view('emails.booking.review-request', [
                'booking' => $this->booking,
                'customerName' => $customerName
            ]);
    }
}
