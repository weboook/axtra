@extends('layouts.public')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="text-center">
                <!-- Cancelled Icon -->
                <div class="mb-4">
                    <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-ban text-warning" style="font-size: 2rem;"></i>
                    </div>
                </div>
                
                <!-- Cancelled Message -->
                <h2 class="fw-bold mb-3 text-dark">Payment Cancelled</h2>
                <p class="text-muted mb-4 fs-5">Your booking payment was cancelled. No charges have been made to your account.</p>
                
                <!-- Booking Reference -->
                @if($booking)
                <div class="card border-0 bg-light mb-4" style="border-radius: 0.75rem;">
                    <div class="card-body p-3">
                        <small class="text-muted">Booking Reference</small>
                        <div class="fw-bold">#{{ $booking->id }}</div>
                        <small class="text-muted">{{ $booking->booking_date->format('M j, Y') }} at {{ $booking->start_time->format('g:i A') }}</small>
                        <div class="mt-2">
                            <span class="badge bg-warning text-dark px-2 py-1" style="border-radius: 0.5rem;">
                                <i class="fas fa-clock me-1"></i>Pending Payment
                            </span>
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- Action Buttons -->
                <div class="d-flex flex-column gap-3">
                    @if($booking)
                    <a href="{{ route('booking.payment', $booking->id) }}" class="btn btn-primary btn-lg" 
                       style="background: linear-gradient(135deg, #c02425 0%, #d63031 100%); border: none; border-radius: 0.75rem;">
                        <i class="fas fa-credit-card me-2"></i>Complete Payment
                    </a>
                    @endif
                    
                    <a href="{{ route('user.book') }}" class="btn btn-outline-primary btn-lg" 
                       style="border-radius: 0.75rem;">
                        <i class="fas fa-plus me-2"></i>Start New Booking
                    </a>
                    
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-lg" 
                       style="border-radius: 0.75rem;">
                        <i class="fas fa-home me-2"></i>Return to Dashboard
                    </a>
                </div>
                
                <!-- Booking Retention Notice -->
                <div class="mt-5 pt-4 border-top">
                    <div class="alert alert-info border-0" style="border-radius: 0.75rem; background: rgba(13, 202, 240, 0.1);">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-info-circle me-3 text-info"></i>
                            <div class="small text-start">
                                <strong>Your booking slot is still reserved!</strong><br>
                                Complete your payment within 24 hours to confirm your booking.
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Support Contact -->
                <div class="mt-4 pt-3 border-top">
                    <small class="text-muted">
                        <i class="fas fa-life-ring me-1"></i>
                        Questions? Our support team is here to help
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection