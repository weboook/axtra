@extends($layout)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="text-center">
                <!-- Success Icon -->
                <div class="mb-4">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-check text-success" style="font-size: 2rem;"></i>
                    </div>
                </div>
                
                <!-- Success Message -->
                <h2 class="fw-bold mb-3 text-dark">Booking Confirmed!</h2>
                <p class="text-muted mb-4 fs-5">Your axe throwing experience has been successfully booked. Get ready for an amazing time!</p>
                
                <!-- Booking Details Card -->
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 1rem;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3 text-start">Booking Details</h5>
                        <div class="row g-3 text-start">
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center p-3 bg-light rounded-3">
                                    <i class="fas fa-calendar me-3 text-primary"></i>
                                    <div>
                                        <small class="text-muted">Date</small>
                                        <div class="fw-semibold">{{ $booking->booking_date->format('M j, Y') }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center p-3 bg-light rounded-3">
                                    <i class="fas fa-clock me-3 text-primary"></i>
                                    <div>
                                        <small class="text-muted">Time</small>
                                        <div class="fw-semibold">{{ $booking->start_time->format('g:i A') }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center p-3 bg-light rounded-3">
                                    <i class="fas fa-users me-3 text-primary"></i>
                                    <div>
                                        <small class="text-muted">Participants</small>
                                        <div class="fw-semibold">{{ $booking->participants }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center p-3 bg-light rounded-3">
                                    <i class="fas fa-receipt me-3 text-primary"></i>
                                    <div>
                                        <small class="text-muted">Total Paid</small>
                                        <div class="fw-semibold">CHF {{ number_format($booking->total_price, 2) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                    <a href="{{ route('user.bookings') }}" class="btn btn-primary btn-lg" 
                       style="background: linear-gradient(135deg, #c02425 0%, #d63031 100%); border: none; border-radius: 0.75rem;">
                        <i class="fas fa-list me-2"></i>View My Bookings
                    </a>
                    
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-lg" 
                       style="border-radius: 0.75rem;">
                        <i class="fas fa-home me-2"></i>Dashboard
                    </a>
                </div>
                
                <!-- Additional Info -->
                <div class="mt-5 pt-4 border-top">
                    <div class="row text-start">
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-2">What to Expect</h6>
                            <ul class="list-unstyled small text-muted">
                                <li><i class="fas fa-check me-2 text-success"></i>Safety briefing included</li>
                                <li><i class="fas fa-check me-2 text-success"></i>All equipment provided</li>
                                <li><i class="fas fa-check me-2 text-success"></i>Professional instruction</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-2">Important Notes</h6>
                            <ul class="list-unstyled small text-muted">
                                <li><i class="fas fa-info me-2 text-info"></i>Arrive 15 minutes early</li>
                                <li><i class="fas fa-info me-2 text-info"></i>Closed-toe shoes required</li>
                                <li><i class="fas fa-info me-2 text-info"></i>Bring valid ID</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection