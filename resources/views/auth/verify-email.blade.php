<x-guest-layout>
    <!-- Logo -->
    <div class="auth-logo">
        <img src="{{ asset('images/brand/axtra-full-dark.png') }}" alt="Axtra Logo">
    </div>
    
    <!-- Header -->
    <h1 class="auth-title">Verify Your Email</h1>
    <p class="auth-subtitle">We've sent a verification link to your email address</p>

    <!-- Success Messages -->
    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success">
            <i class="fas fa-check-circle me-2"></i>A new verification link has been sent to your email address.
        </div>
    @endif

    <!-- Main Content -->
    <div style="background: #f8f9fa; border-radius: 1rem; padding: 2rem; margin-bottom: 2rem; text-align: center;">
        <div style="margin-bottom: 1.5rem;">
            <i class="fas fa-envelope-open" style="font-size: 3rem; color: var(--axtra-red); margin-bottom: 1rem;"></i>
            <p style="color: #6c757d; font-size: 1rem; line-height: 1.6; margin: 0;">
                Before continuing, please check your email and click on the verification link we sent you. 
                If you didn't receive the email, we'll gladly send you another one.
            </p>
        </div>
    </div>

    <!-- Resend Verification Form -->
    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="btn-primary">
            <i class="fas fa-paper-plane me-2"></i>Resend Verification Email
        </button>
    </form>

    <!-- Action Links -->
    <div class="auth-links">
        <a href="{{ route('profile.show') }}">
            <i class="fas fa-user me-1"></i>Edit Profile
        </a>
    </div>

    <div class="auth-links">
        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
            @csrf
            <button type="submit" style="background: none; border: none; color: var(--axtra-red); font-weight: 500; text-decoration: none; cursor: pointer; font-size: inherit;">
                <i class="fas fa-sign-out-alt me-1"></i>Sign Out
            </button>
        </form>
    </div>
</x-guest-layout>
