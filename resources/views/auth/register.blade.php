<x-guest-layout>
    <!-- Logo -->
    <div class="auth-logo">
        <img src="{{ asset('images/brand/axtra-full-dark.png') }}" alt="Axtra Logo">
    </div>
    
    <!-- Header -->
    <h1 class="auth-title">Join Axtra</h1>
    <p class="auth-subtitle">Create your account and start your axe throwing adventure</p>

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div><i class="fas fa-exclamation-circle me-2"></i>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <!-- Registration Form -->
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            <input type="text" 
                   name="name" 
                   class="form-control" 
                   placeholder="Full name"
                   value="{{ old('name') }}" 
                   required 
                   autofocus 
                   autocomplete="name">
        </div>

        <div class="form-group">
            <input type="email" 
                   name="email" 
                   class="form-control" 
                   placeholder="Email address"
                   value="{{ old('email') }}" 
                   required 
                   autocomplete="username">
        </div>

        <div class="form-group">
            <input type="password" 
                   name="password" 
                   class="form-control" 
                   placeholder="Create a password"
                   required 
                   autocomplete="new-password">
        </div>

        <div class="form-group">
            <input type="password" 
                   name="password_confirmation" 
                   class="form-control" 
                   placeholder="Confirm your password"
                   required 
                   autocomplete="new-password">
        </div>

        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                <label class="form-check-label" for="terms">
                    I agree to the 
                    <a href="{{ route('terms.show') }}" target="_blank">Terms of Service</a>
                    and 
                    <a href="{{ route('policy.show') }}" target="_blank">Privacy Policy</a>
                </label>
            </div>
        @endif

        <button type="submit" class="btn-primary">
            Create My Account
        </button>

        <div class="auth-links">
            <p>
                Already have an account? 
                <a href="{{ route('login') }}">
                    Sign in here
                </a>
            </p>
        </div>

        <!-- Social Login -->
        <div class="social-divider">
            <span>Or sign up with</span>
        </div>
        
        <div class="social-buttons">
            @if (Route::has('auth.google'))
                <a href="{{ route('auth.google') }}" class="btn-social">
                    <i class="fab fa-google"></i>Google
                </a>
            @endif
            @if (Route::has('auth.apple'))
                <a href="{{ route('auth.apple') }}" class="btn-social">
                    <i class="fab fa-apple me-2"></i>Apple
                </a>
            @endif
        </div>
    </form>
</x-guest-layout>