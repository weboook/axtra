@extends('emails.layout', ['subject' => 'Your Axe Throwing Event Starts Soon!'])

@section('content')
    <div class="greeting">Hello {{ $customerName }}!</div>
    
    <div class="content-text">
        <strong>Your axe throwing adventure starts in just 2 hours!</strong> 🪓⏰<br>
        It's time to make your way to Axtra Urban Axe Throwing for an unforgettable experience.
    </div>

    <div class="info-box">
        <div class="info-box-title">
            <span class="icon">🎯</span>
            Event Starting Soon
        </div>
        <div class="details-table">
            <div class="details-row">
                <span class="details-label">Service:</span>
                <span class="details-value">{{ $booking->service->name }}</span>
            </div>
            <div class="details-row">
                <span class="details-label">Start Time:</span>
                <span class="details-value">{{ date('H:i', strtotime($booking->start_time)) }} ({{ date('l, F j', strtotime($booking->booking_date)) }})</span>
            </div>
            <div class="details-row">
                <span class="details-label">Participants:</span>
                <span class="details-value">{{ $booking->participants }} {{ $booking->participants > 1 ? 'people' : 'person' }}</span>
            </div>
            <div class="details-row">
                <span class="details-label">Booking ID:</span>
                <span class="details-value">#{{ $booking->id }}</span>
            </div>
        </div>
    </div>

    <div class="info-box">
        <div class="info-box-title">
            <span class="icon">⚠️</span>
            Important: Arrive Early!
        </div>
        <div class="content-text mb-0">
            <strong>Please arrive at least 30 minutes before your scheduled time</strong> for:<br><br>
            ✓ Check-in and registration<br>
            ✓ Safety briefing and equipment fitting<br>
            ✓ Technique demonstration<br>
            ✓ Getting warmed up and ready to throw!
        </div>
    </div>

    <div class="content-text">
        <strong>Location:</strong><br>
        Axtra Urban Axe Throwing<br>
        Bahnhofstrasse 123, 8001 Zürich, Switzerland
    </div>

    <div class="text-center">
        <a href="{{ $actionUrl }}" class="action-button">View Full Details</a>
    </div>

    <div class="content-text text-center">
        <strong>See you soon! Get ready to hit those bullseyes! 🎯</strong><br>
        Our team is excited to welcome you to Axtra!
    </div>
@endsection