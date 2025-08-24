@extends($layout)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="text-center">
                <!-- Error Icon -->
                <div class="mb-4">
                    <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-exclamation-triangle text-danger" style="font-size: 2rem;"></i>
                    </div>
                </div>
                
                <!-- Error Message -->
                <h2 class="fw-bold mb-3 text-dark">Payment Error</h2>
                <p class="text-muted mb-4 fs-5">We encountered an issue processing your payment. Please try again or contact support if the problem persists.</p>
                
                <!-- Action Buttons -->
                <div class="d-flex flex-column gap-3">
                    <a href="{{ route('user.book') }}" class="btn btn-primary btn-lg" 
                       style="background: linear-gradient(135deg, #c02425 0%, #d63031 100%); border: none; border-radius: 0.75rem;">
                        <i class="fas fa-redo me-2"></i>Try Again
                    </a>
                    
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-lg" 
                       style="border-radius: 0.75rem;">
                        <i class="fas fa-home me-2"></i>Return to Dashboard
                    </a>
                </div>
                
                <!-- Support Contact -->
                <div class="mt-5 pt-4 border-top">
                    <small class="text-muted">
                        <i class="fas fa-life-ring me-1"></i>
                        Need help? Contact our support team
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection