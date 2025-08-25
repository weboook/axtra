@extends('emails.layout', ['subject' => 'New Booking Created'])

@section('content')
    <div class="greeting">New Booking Alert! 🎯</div>
    
    <div class="content-text">
        A new booking has been created on the Axtra platform. Here are the details:
    </div>

    <div class="info-box">
        <div class="info-box-title">
            <span class="icon">📋</span>
            Booking Information
        </div>
        <div class="details-table">
            <div class="details-row">
                <span class="details-label">Booking ID:</span>
                <span class="details-value">#{{ $booking->id }}</span>
            </div>
            <div class="details-row">
                <span class="details-label">Customer:</span>
                <span class="details-value">{{ $customerName }}</span>
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
            <div class="details-row">
                <span class="details-label">Status:</span>
                <span class="details-value text-success">{{ ucfirst($booking->status) }}</span>
            </div>
        </div>
    </div>

    @if($booking->notes)
    <div class="info-box">
        <div class="info-box-title">
            <span class="icon">💬</span>
            Customer Notes
        </div>
        <div class="content-text mb-0">
            {{ $booking->notes }}
        </div>
    </div>
    @endif

    <div class="text-center">
        <a href="{{ $actionUrl }}" class="action-button">View in Admin Panel</a>
    </div>

    <div class="content-text text-center">
        <strong>Booking created at:</strong> {{ $booking->created_at->format('Y-m-d H:i:s') }}
    </div>
@endsection