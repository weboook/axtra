<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Console\Command;

class SendTestEmails extends Command
{
    protected $signature = 'email:send-tests';
    protected $description = 'Send test emails using PHP mail() function to info@weboook.co.uk';

    private $testEmail = 'info@weboook.co.uk';

    public function handle()
    {
        $this->info('Starting to send test emails...');

        // Create mock data for testing
        $mockBooking = $this->createMockBooking();

        // Send all email types
        $this->sendBookingConfirmation($mockBooking);
        $this->sendReminder50Hours($mockBooking);
        $this->sendReminder2Hours($mockBooking);
        $this->sendReviewRequest($mockBooking);
        $this->sendAdminNotification($mockBooking);
        
        // Send auth-related emails
        $this->sendWelcomeEmail();
        $this->sendPasswordReset();

        $this->info('All test emails sent successfully!');
    }

    private function createMockBooking()
    {
        return (object) [
            'id' => 12345,
            'booking_date' => '2025-08-30',
            'start_time' => '2025-08-30 15:00:00',
            'participants' => 4,
            'total_price' => 180.00,
            'status' => 'confirmed',
            'notes' => 'Birthday celebration - please prepare some extra axes!',
            'created_at' => Carbon::now(),
            'service' => (object) [
                'name' => 'Premium Axe Throwing Experience',
                'duration_hours' => 2
            ],
            'user' => null, // Guest booking
            'participant_details' => [
                'guest_info' => [
                    'name' => 'John Smith',
                    'email' => 'john.smith@example.com',
                    'phone' => '+41 79 123 45 67'
                ]
            ]
        ];
    }

    private function sendBookingConfirmation($booking)
    {
        $customerName = 'John Smith';
        $changeDeadline = '2025-08-28 15:00';
        $actionUrl = config('app.url') . '/bookings/' . $booking->id;
        $qrCodeBase64 = $this->generateQrCodeBase64($booking->id);

        $subject = 'Booking Confirmation - Axtra Urban Axe Throwing';
        $html = view('emails.booking.confirmation', compact('booking', 'customerName', 'changeDeadline', 'actionUrl', 'qrCodeBase64'))->render();
        
        $this->sendEmail($subject, $html);
        $this->info('✓ Booking Confirmation email sent');
    }

    private function sendReminder50Hours($booking)
    {
        $customerName = 'John Smith';
        $actionUrl = config('app.url') . '/bookings/' . $booking->id;

        $subject = 'Your Axe Throwing Event is Coming Up!';
        $html = view('emails.booking.reminder-50-hours', compact('booking', 'customerName', 'actionUrl'))->render();
        
        $this->sendEmail($subject, $html);
        $this->info('✓ 50-hour Reminder email sent');
    }

    private function sendReminder2Hours($booking)
    {
        $customerName = 'John Smith';
        $actionUrl = config('app.url') . '/bookings/' . $booking->id;

        $subject = 'Your Axe Throwing Event Starts Soon!';
        $html = view('emails.booking.reminder-2-hours', compact('booking', 'customerName', 'actionUrl'))->render();
        
        $this->sendEmail($subject, $html);
        $this->info('✓ 2-hour Reminder email sent');
    }

    private function sendReviewRequest($booking)
    {
        $customerName = 'John Smith';

        $subject = 'How was your Axe Throwing Experience?';
        $html = view('emails.booking.review-request', compact('booking', 'customerName'))->render();
        
        $this->sendEmail($subject, $html);
        $this->info('✓ Review Request email sent');
    }

    private function sendAdminNotification($booking)
    {
        $customerName = 'John Smith';
        $actionUrl = config('app.url') . '/admin/bookings/' . $booking->id;

        $subject = 'New Booking Created - Admin Alert';
        $html = view('emails.admin.booking-created', compact('booking', 'customerName', 'actionUrl'))->render();
        
        $this->sendEmail($subject, $html);
        $this->info('✓ Admin Notification email sent');
    }

    private function sendWelcomeEmail()
    {
        $customerName = 'John Smith';
        $actionUrl = config('app.url') . '/dashboard';

        $subject = 'Welcome to Axtra Urban Axe Throwing!';
        $html = view('emails.auth.welcome', compact('customerName', 'actionUrl'))->render();
        
        $this->sendEmail($subject, $html);
        $this->info('✓ Welcome email sent');
    }

    private function sendPasswordReset()
    {
        $customerName = 'John Smith';
        $resetUrl = config('app.url') . '/password/reset/abc123token';

        $subject = 'Reset Your Password - Axtra';
        $html = view('emails.auth.password-reset', compact('customerName', 'resetUrl'))->render();
        
        $this->sendEmail($subject, $html);
        $this->info('✓ Password Reset email sent');
    }

    private function sendEmail($subject, $html)
    {
        // Try a simpler approach first
        $headers = [
            'MIME-Version: 1.0',
            'Content-type: text/html; charset=UTF-8',
            'From: noreply@axtra.ch',
            'Reply-To: info@axtra.ch'
        ];

        $this->info("Attempting to send: $subject");
        $this->info("To: {$this->testEmail}");

        $success = mail(
            $this->testEmail,
            $subject,
            $html,
            implode("\r\n", $headers)
        );

        if ($success) {
            $this->info("✓ Mail function returned TRUE for: $subject");
        } else {
            $this->error("✗ Mail function returned FALSE for: $subject");
            // Get last error
            $error = error_get_last();
            if ($error) {
                $this->error("Error: " . $error['message']);
            }
        }

        // Also try a simple text version as backup
        $textSubject = $subject . ' [Text Version]';
        $textMessage = strip_tags($html);
        $textHeaders = 'From: noreply@axtra.ch' . "\r\n" . 'Reply-To: info@axtra.ch';
        
        $textSuccess = mail($this->testEmail, $textSubject, $textMessage, $textHeaders);
        
        if ($textSuccess) {
            $this->info("✓ Text version sent successfully");
        } else {
            $this->error("✗ Text version also failed");
        }

        // Small delay between emails
        sleep(2);
    }

    private function generateQrCodeBase64($bookingId): string
    {
        try {
            $qrCodeData = "BOOKING-{$bookingId}";
            
            $qrCode = new QrCode(
                data: $qrCodeData,
                size: 200,
                margin: 10
            );
            
            $writer = new PngWriter();
            $result = $writer->write($qrCode);
            
            return base64_encode($result->getString());
        } catch (\Exception $e) {
            // Return empty string if QR code generation fails
            return '';
        }
    }
}
