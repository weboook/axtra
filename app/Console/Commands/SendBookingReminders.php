<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Notifications\EventReminder50Hours;
use App\Notifications\EventReminder2Hours;
use App\Notifications\ReviewRequest;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendBookingReminders extends Command
{
    protected $signature = 'booking:send-reminders';
    protected $description = 'Send automated booking reminder emails and WhatsApp messages';

    public function handle()
    {
        $this->send50HourReminders();
        $this->send2HourReminders();
        $this->sendReviewRequests();
        
        $this->info('Booking reminders processed successfully.');
    }

    private function send50HourReminders()
    {
        $targetTime = now()->addHours(50);
        
        // Find bookings that are approximately 50 hours away (give or take 1 hour window)
        $bookings = Booking::where('status', 'confirmed')
            ->whereBetween('start_time', [
                $targetTime->copy()->subHour(),
                $targetTime->copy()->addHour()
            ])
            ->whereTime('start_time', '>=', '10:00') // Only send during appropriate hours
            ->whereDoesntHave('remindersSent', function($query) {
                $query->where('type', '50_hours');
            })
            ->get();

        foreach ($bookings as $booking) {
            if ($booking->user) {
                $booking->user->notify(new EventReminder50Hours($booking));
            } else {
                // Handle guest bookings - send to guest email
                $guestEmail = $booking->participant_details['guest_info']['email'] ?? null;
                if ($guestEmail) {
                    \Notification::route('mail', $guestEmail)
                        ->notify(new EventReminder50Hours($booking));
                }
            }
            
            // Mark reminder as sent (you'd need to create a reminders table)
            $this->markReminderSent($booking, '50_hours');
        }

        $this->info("Sent 50-hour reminders to {$bookings->count()} bookings.");
    }

    private function send2HourReminders()
    {
        $targetTime = now()->addHours(2);
        
        $bookings = Booking::where('status', 'confirmed')
            ->whereBetween('start_time', [
                $targetTime->copy()->subMinutes(30),
                $targetTime->copy()->addMinutes(30)
            ])
            ->whereDoesntHave('remindersSent', function($query) {
                $query->where('type', '2_hours');
            })
            ->get();

        foreach ($bookings as $booking) {
            if ($booking->user) {
                $booking->user->notify(new EventReminder2Hours($booking));
            } else {
                $guestEmail = $booking->participant_details['guest_info']['email'] ?? null;
                if ($guestEmail) {
                    \Notification::route('mail', $guestEmail)
                        ->notify(new EventReminder2Hours($booking));
                }
            }
            
            $this->markReminderSent($booking, '2_hours');
        }

        $this->info("Sent 2-hour reminders to {$bookings->count()} bookings.");
    }

    private function sendReviewRequests()
    {
        $yesterday = now()->subDay();
        
        $bookings = Booking::where('status', 'confirmed')
            ->whereDate('start_time', $yesterday->toDateString())
            ->whereDoesntHave('remindersSent', function($query) {
                $query->where('type', 'review_request');
            })
            ->get();

        foreach ($bookings as $booking) {
            if ($booking->user) {
                $booking->user->notify(new ReviewRequest($booking));
            } else {
                $guestEmail = $booking->participant_details['guest_info']['email'] ?? null;
                if ($guestEmail) {
                    \Notification::route('mail', $guestEmail)
                        ->notify(new ReviewRequest($booking));
                }
            }
            
            $this->markReminderSent($booking, 'review_request');
        }

        $this->info("Sent review requests to {$bookings->count()} bookings.");
    }

    private function markReminderSent($booking, $type)
    {
        // This would require a booking_reminders table
        // For now, just log it
        \Log::info("Reminder sent", [
            'booking_id' => $booking->id,
            'type' => $type,
            'sent_at' => now()
        ]);
    }
}
