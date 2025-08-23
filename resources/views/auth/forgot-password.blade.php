<x-guest-layout>
    <!-- Logo -->
    <div class="auth-logo">
        <img src="{{ asset('images/brand/axtra-full-dark.png') }}" alt="Axtra Logo">
    </div>
    
    <!-- Header -->
    <h1 class="auth-title">Reset Password</h1>
    <p class="auth-subtitle">Enter your email and we'll send you a reset link</p>

    <div class="alert alert-info" style="background: rgba(23, 162, 184, 0.1); color: #0c5460; margin-bottom: 2rem;">
        <i class="fas fa-info-circle me-2"></i>
        Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
    </div>

    <!-- Success Messages -->
    @session('status')
        <div class="alert alert-success">
            <i class="fas fa-check-circle me-2"></i>{{ $value }}
        </div>
    @endsession

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div><i class="fas fa-exclamation-circle me-2"></i>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <!-- Reset Form -->
    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="form-group">
            <input type="email" 
                   name="email" 
                   class="form-control" 
                   placeholder="Your email address"
                   value="{{ old('email') }}" 
                   required 
                   autofocus 
                   autocomplete="username">
        </div>

        <button type="submit" class="btn-primary">
            Email Password Reset Link
        </button>

        <div class="auth-links">
            <p>
                Remember your password? 
                <a href="{{ route('login') }}">
                    Sign in here
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>