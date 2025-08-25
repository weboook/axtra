<?php

namespace App\Livewire\Admin;

use App\Models\Booking;
use Carbon\Carbon;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Livewire\Component;

class EmailPreviews extends Component
{
    public $selectedEmail = '';
    public $emailContent = '';
    
    public function mount()
    {
        // Create mock booking data for previews
        $this->createMockData();
    }

    public function previewEmail($emailType)
    {
        $this->selectedEmail = $emailType;
        $this->emailContent = $this->generateEmailContent($emailType);
        $this->dispatch('showEmailModal');
    }

    private function generateEmailContent($emailType)
    {
        $mockBooking = $this->getMockBooking();
        $booking = $mockBooking; // Add booking alias
        $customerName = 'John Smith';
        $changeDeadline = '2025-08-28 15:00';
        $actionUrl = config('app.url') . '/bookings/' . $mockBooking->id;

        switch ($emailType) {
            case 'booking-confirmation':
                $qrCodeBase64 = $this->generateQrCodeBase64($mockBooking->id);
                return view('emails.booking.confirmation', compact('mockBooking', 'booking', 'customerName', 'changeDeadline', 'actionUrl', 'qrCodeBase64'))->render();
                
            case 'reminder-50-hours':
                return view('emails.booking.reminder-50-hours', [
                    'booking' => $mockBooking,
                    'mockBooking' => $mockBooking,
                    'customerName' => $customerName,
                    'actionUrl' => $actionUrl
                ])->render();
                
            case 'reminder-2-hours':
                return view('emails.booking.reminder-2-hours', [
                    'booking' => $mockBooking,
                    'mockBooking' => $mockBooking,
                    'customerName' => $customerName,
                    'actionUrl' => $actionUrl
                ])->render();
                
            case 'review-request':
                return view('emails.booking.review-request', [
                    'booking' => $mockBooking,
                    'mockBooking' => $mockBooking,
                    'customerName' => $customerName
                ])->render();
                
            case 'admin-booking-created':
                return view('emails.admin.booking-created', [
                    'booking' => $mockBooking,
                    'mockBooking' => $mockBooking,
                    'customerName' => $customerName,
                    'actionUrl' => config('app.url') . '/admin/bookings/' . $mockBooking->id
                ])->render();
                
            case 'welcome':
                return view('emails.auth.welcome', [
                    'customerName' => $customerName,
                    'actionUrl' => config('app.url') . '/dashboard'
                ])->render();
                
            case 'password-reset':
                return view('emails.auth.password-reset', [
                    'customerName' => $customerName,
                    'resetUrl' => config('app.url') . '/password/reset/abc123token'
                ])->render();
                
            default:
                return '<p>Email template not found</p>';
        }
    }

    private function getMockBooking()
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
            'user' => null,
            'participant_details' => [
                'guest_info' => [
                    'name' => 'John Smith',
                    'email' => 'john.smith@example.com',
                    'phone' => '+41 79 123 45 67'
                ]
            ]
        ];
    }

    public function render()
    {
        $emails = [
            [
                'id' => 'booking-confirmation',
                'name' => 'Booking Confirmation',
                'description' => 'Sent when a booking is confirmed after payment',
                'category' => 'Booking',
                'recipients' => 'Customer',
                'trigger' => 'Payment Success'
            ],
            [
                'id' => 'reminder-50-hours',
                'name' => '50-Hour Reminder',
                'description' => 'Sent 50 hours before the event',
                'category' => 'Reminder',
                'recipients' => 'Customer',
                'trigger' => 'Automated (50h before)'
            ],
            [
                'id' => 'reminder-2-hours',
                'name' => '2-Hour Reminder',
                'description' => 'Sent 2 hours before the event',
                'category' => 'Reminder',
                'recipients' => 'Customer',
                'trigger' => 'Automated (2h before)'
            ],
            [
                'id' => 'review-request',
                'name' => 'Review Request',
                'description' => 'Sent the day after the event',
                'category' => 'Follow-up',
                'recipients' => 'Customer',
                'trigger' => 'Automated (next day)'
            ],
            [
                'id' => 'admin-booking-created',
                'name' => 'Admin Booking Alert',
                'description' => 'Sent to admins when new booking is created',
                'category' => 'Admin',
                'recipients' => 'Admin Users',
                'trigger' => 'New Booking'
            ],
            [
                'id' => 'welcome',
                'name' => 'Welcome Email',
                'description' => 'Sent when user creates account',
                'category' => 'Authentication',
                'recipients' => 'New User',
                'trigger' => 'Account Registration'
            ],
            [
                'id' => 'password-reset',
                'name' => 'Password Reset',
                'description' => 'Sent when user requests password reset',
                'category' => 'Authentication',
                'recipients' => 'User',
                'trigger' => 'Password Reset Request'
            ],
        ];

        return view('livewire.admin.email-previews', compact('emails'))
            ->layout('layouts.app', ['title' => 'Email Templates']);
    }

    private function createMockData()
    {
        // Initialize mock data if needed
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
