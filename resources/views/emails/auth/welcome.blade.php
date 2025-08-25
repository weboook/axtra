@extends('emails.layout', ['subject' => 'Welcome to Axtra Urban Axe Throwing!'])

@section('content')
    <div class="greeting">Welcome {{ $customerName }}! 🎯</div>
    
    <div class="content-text">
        <strong>Thank you for joining Axtra Urban Axe Throwing!</strong><br>
        We're thrilled to have you as part of our axe throwing community in Switzerland.
    </div>

    <div class="info-box">
        <div class="info-box-title">
            <span class="icon">🏹</span>
            What You Can Do Now
        </div>
        <div class="content-text mb-0">
            ✓ <strong>Book your first axe throwing experience</strong><br>
            ✓ <strong>View available time slots</strong> and choose what works for you<br>
            ✓ <strong>Manage your bookings</strong> through your personal dashboard<br>
            ✓ <strong>Earn rewards</strong> with every visit<br>
            ✓ <strong>Get exclusive offers</strong> and early access to events
        </div>
    </div>

    <div class="text-center">
        <a href="{{ $actionUrl }}" class="action-button">Go to Dashboard</a>
    </div>

    <div class="info-box">
        <div class="info-box-title">
            <span class="icon">🎯</span>
            Why Choose Axtra?
        </div>
        <div class="content-text mb-0">
            • <strong>Expert Instructors:</strong> Learn from the best axe throwing coaches<br>
            • <strong>Safe Environment:</strong> State-of-the-art safety equipment and protocols<br>
            • <strong>Premium Experience:</strong> High-quality axes and professional lanes<br>
            • <strong>Perfect for Groups:</strong> Corporate events, birthdays, team building<br>
            • <strong>Central Location:</strong> Easy to reach in the heart of Zürich
        </div>
    </div>

    <div class="content-text">
        <strong>Ready to throw some axes?</strong><br>
        Book your first experience and discover why axe throwing is Switzerland's most exciting new sport!
    </div>

    <div class="content-text text-center">
        <strong>Welcome to the Axtra family!</strong><br>
        We can't wait to see you hit those bullseyes! 🪓
    </div>
@endsection