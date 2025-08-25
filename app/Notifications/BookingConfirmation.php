<?php

namespace App\Notifications;

use App\Models\Booking;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class BookingConfirmation extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private Booking $booking
    ) {}

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $qrCodeData = $this->generateQrCodeData();
        $qrCodePath = $this->generateQrCode();
        
        $customerName = $this->booking->user 
            ? $this->booking->user->name 
            : $this->booking->participant_details['guest_info']['name'];
            
        $changeDeadline = now()->parse($this->booking->start_time)->subHours(48)->format('Y-m-d H:i');
        $actionUrl = route('bookings.show', $this->booking);
        
        return (new MailMessage)
            ->subject('Booking Confirmation - Axtra Urban Axe Throwing')
            ->view('emails.booking.confirmation', [
                'booking' => $this->booking,
                'customerName' => $customerName,
                'changeDeadline' => $changeDeadline,
                'actionUrl' => $actionUrl,
                'qrCodeBase64' => $qrCodeData['base64']
            ])
            ->attach(storage_path('app/' . $qrCodePath), [
                'as' => 'booking-qr-code.png',
                'mime' => 'image/png',
            ]);
    }

    /**
     * Generate QR code data (both base64 and file)
     */
    private function generateQrCodeData(): array
    {
        $qrCodeData = "BOOKING-{$this->booking->id}";
        
        $qrCode = new QrCode(
            data: $qrCodeData,
            size: 200,
            margin: 10
        );
        
        $writer = new PngWriter();
        $result = $writer->write($qrCode);
        
        return [
            'string' => $result->getString(),
            'base64' => base64_encode($result->getString())
        ];
    }

    /**
     * Generate QR code for the booking
     */
    private function generateQrCode(): string
    {
        $qrCodeData = $this->generateQrCodeData();
        
        $filename = 'qr-codes/booking-' . $this->booking->id . '.png';
        Storage::put($filename, $qrCodeData['string']);
        
        return $filename;
    }
}
