@extends('layouts.public')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="text-center">
                <!-- Failed Icon -->
                <div class="mb-4">
                    <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-times text-danger" style="font-size: 2rem;"></i>
                    </div>
                </div>
                
                <!-- Failed Message -->
                <h2 class="fw-bold mb-3 text-dark">Payment Failed</h2>
                <p class="text-muted mb-4 fs-5">Your payment could not be processed. Please check your payment details and try again.</p>
                
                <!-- Booking Reference -->
                @if($booking)
                <div class="card border-0 bg-light mb-4" style="border-radius: 0.75rem;">
                    <div class="card-body p-3">
                        <small class="text-muted">Booking Reference</small>
                        <div class="fw-bold">#{{ $booking->id }}</div>
                        <small class="text-muted">{{ $booking->booking_date->format('M j, Y') }} at {{ $booking->start_time->format('g:i A') }}</small>
                    </div>
                </div>
                @endif
                
                <!-- Action Buttons -->
                <div class="d-flex flex-column gap-3">
                    @if($booking)
                    <a href="{{ route('booking.payment', $booking->id) }}" class="btn btn-primary btn-lg" 
                       style="background: linear-gradient(135deg, #c02425 0%, #d63031 100%); border: none; border-radius: 0.75rem;">
                        <i class="fas fa-credit-card me-2"></i>Retry Payment
                    </a>
                    @endif
                    
                    <a href="{{ route('user.book') }}" class="btn btn-outline-primary btn-lg" 
                       style="border-radius: 0.75rem;">
                        <i class="fas fa-redo me-2"></i>Start New Booking
                    </a>
                    
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-lg" 
                       style="border-radius: 0.75rem;">
                        <i class="fas fa-home me-2"></i>Return to Dashboard
                    </a>
                </div>
                
                <!-- Common Issues -->
                <div class="mt-5 pt-4 border-top text-start">
                    <h6 class="fw-bold mb-3">Common Issues</h6>
                    <ul class="list-unstyled small text-muted">
                        <li class="mb-2"><i class="fas fa-info-circle me-2 text-info"></i>Check your card details are correct</li>
                        <li class="mb-2"><i class="fas fa-info-circle me-2 text-info"></i>Ensure sufficient funds are available</li>
                        <li class="mb-2"><i class="fas fa-info-circle me-2 text-info"></i>Try a different payment method</li>
                        <li class="mb-2"><i class="fas fa-info-circle me-2 text-info"></i>Contact your bank if issues persist</li>
                    </ul>
                </div>
                
                <!-- Support Contact -->
                <div class="mt-4 pt-3 border-top">
                    <small class="text-muted">
                        <i class="fas fa-life-ring me-1"></i>
                        Need help? Contact our support team for assistance
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection