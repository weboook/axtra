@extends('emails.layout', ['subject' => 'How was your Axe Throwing Experience?'])

@section('content')
    <div class="greeting">Hello {{ $customerName }}!</div>
    
    <div class="content-text">
        We hope you had an <strong>amazing time</strong> at Axtra Urban Axe Throwing yesterday! 🎯<br>
        Your feedback means the world to us and helps us continue to improve our service for future axe throwers.
    </div>

    <div class="info-box">
        <div class="info-box-title">
            <span class="icon">📋</span>
            Your Recent Experience
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
                <span class="details-label">Participants:</span>
                <span class="details-value">{{ $booking->participants }} {{ $booking->participants > 1 ? 'people' : 'person' }}</span>
            </div>
            <div class="details-row">
                <span class="details-label">Booking ID:</span>
                <span class="details-value">#{{ $booking->id }}</span>
            </div>
        </div>
    </div>

    <div class="content-text">
        <strong>Would you mind taking a moment to share your experience with others?</strong><br>
        Your review helps other axe throwing enthusiasts discover the excitement of Axtra!
    </div>

    <div class="text-center">
        <a href="https://www.google.com/maps/place/Axtra+-+Urban+Axe+Throwing/@47.4062808,8.5479301,17z/data=!3m1!4b1!4m6!3m5!1s0x47900b798de77729:0x38fc96342c113c1e!8m2!3d47.4062808!4d8.550505!16s%2Fg%2F11h8c0hmxr?entry=ttu&g_ep=EgoyMDI1MDgyNC4wIKXMDSoASAFQAw%3D%3D" class="action-button">
            ⭐ Leave a Google Review
        </a>
    </div>

    <div class="info-box">
        <div class="info-box-title">
            <span class="icon">🎁</span>
            Come Back Soon!
        </div>
        <div class="content-text mb-0">
            Did you know we offer different axe throwing experiences? <br>
            Consider trying our other services or bringing different friends next time!<br><br>
            
            <strong>Follow us on social media</strong> for special offers and axe throwing tips! 📱
        </div>
    </div>

    <div class="content-text text-center">
        <strong>Thank you for choosing Axtra Urban Axe Throwing!</strong><br>
        We look forward to welcoming you back for another thrilling experience! 🪓
    </div>
@endsection