@extends('emails.layout', ['subject' => 'Your Axe Throwing Event is Coming Up!'])

@section('content')
    <div class="greeting">Hello {{ $customerName }}!</div>
    
    <div class="content-text">
        Your exciting axe throwing event at <strong>Axtra Urban Axe Throwing</strong> is coming up soon! We wanted to give you a friendly reminder and share some important details.
    </div>

    <div class="info-box">
        <div class="info-box-title">
            <span class="icon">📅</span>
            Event Details
        </div>
        <div class="details-table">
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
        </div>
    </div>

    <div class="content-text">
        <strong>Good news!</strong> You can still make changes to your booking up to 48 hours before your event if needed.
    </div>

    <div class="text-center">
        <a href="{{ $actionUrl }}" class="action-button">View Booking</a>
    </div>

    <div class="info-box">
        <div class="info-box-title">
            <span class="icon">💡</span>
            What to Expect
        </div>
        <div class="content-text mb-0">
            • <strong>Arrive 30 minutes early</strong> for check-in and safety briefing<br>
            • Wear <strong>closed-toe shoes</strong> and comfortable clothing<br>
            • Our expert instructors will guide you through everything<br>
            • Get ready for an adrenaline-pumping experience! 🎯
        </div>
    </div>

    <div class="content-text text-center">
        <strong>We can't wait to see you throw some axes!</strong><br>
        Questions? Don't hesitate to contact us.
    </div>
@endsection