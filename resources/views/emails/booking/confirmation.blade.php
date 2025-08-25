@extends('emails.layout', ['subject' => 'Booking Confirmation'])

@section('content')
    <div class="greeting">Hello {{ $customerName }}!</div>
    
    <div class="content-text">
        <strong>Thank you for booking with Axtra Urban Axe Throwing!</strong> Your booking has been confirmed and we're excited to welcome you.
    </div>

    <div class="info-box">
        <div class="info-box-title">
            <span class="icon">🎯</span>
            Booking Details
        </div>
        <div class="details-table">
            <div class="details-row">
                <span class="details-label">Booking ID:</span>
                <span class="details-value">#{{ $booking->id }}</span>
            </div>
            <div class="details-row">
                <span class="details-label">Service:</span>
                <span class="details-value">{{ $booking->service->name }}</span>
            </div>
            <div class="details-row">
                <span class="details-label">Date:</span>
                <span class="details-value">{{ date('l, F j, Y', strtotime($booking->booking_date)) }}</span>
            </div>
            <div class="details-row">
                <span class="details-label">Time:</span>
                <span class="details-value">{{ date('H:i', strtotime($booking->start_time)) }}</span>
            </div>
            <div class="details-row">
                <span class="details-label">Participants:</span>
                <span class="details-value">{{ $booking->participants }} {{ $booking->participants > 1 ? 'people' : 'person' }}</span>
            </div>
            <div class="details-row">
                <span class="details-label">Total Amount:</span>
                <span class="details-value">CHF {{ number_format($booking->total_price, 2) }}</span>
            </div>
        </div>
    </div>

    <div class="text-center">
        <a href="{{ $actionUrl }}" class="action-button">View Booking Details</a>
    </div>

    <div class="info-box">
        <div class="info-box-title">
            <span class="icon">ℹ️</span>
            Important Information
        </div>
        <div class="content-text mb-0">
            <strong>Please arrive at least 30 minutes before your scheduled time</strong><br><br>
            
            <strong>Booking Changes Policy:</strong><br>
            Changes to your booking can be made up to <strong>48 hours before your event</strong> (until {{ $changeDeadline }}).<br>
            After this deadline, no changes will be accepted.<br><br>
            
            <strong>QR Code Check-in:</strong><br>
            We've attached a QR code to this email. Please show this QR code at reception for quick and easy check-in.
        </div>
    </div>

    {{-- QR Code Section --}}
    <div class="info-box text-center">
        <div class="info-box-title" style="justify-content: center;">
            <span class="icon">📱</span>
            Your Check-in QR Code
        </div>
        <div class="content-text">
            <strong>Show this QR code at reception for quick check-in:</strong>
        </div>
        @if(isset($qrCodeBase64))
            <div style="background: white; padding: 20px; border-radius: 8px; display: inline-block; margin: 15px 0; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                <img src="data:image/png;base64,{{ $qrCodeBase64 }}" alt="Booking QR Code" style="max-width: 200px; height: auto; display: block;">
            </div>
        @else
            <div style="background: white; padding: 20px; border-radius: 8px; display: inline-block; margin: 15px 0; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                <div style="width: 200px; height: 200px; background: #f8f9fa; border: 2px dashed #dee2e6; display: flex; align-items: center; justify-content: center; color: #6c757d; font-size: 14px; text-align: center;">
                    QR Code<br>Booking #{{ $booking->id }}
                </div>
            </div>
        @endif
        <div class="content-text" style="font-size: 14px; color: #6c757d; margin-top: 10px;">
            Booking ID: #{{ $booking->id }}
        </div>
    </div>

    <div class="content-text text-center">
        <strong>We look forward to seeing you at Axtra Urban Axe Throwing!</strong><br>
        Get ready for an unforgettable axe throwing experience! 🪓
    </div>
@endsection