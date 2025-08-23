<x-guest-layout>
    <!-- Logo -->
    <div class="auth-logo">
        <img src="{{ asset('images/brand/axtra-full-dark.png') }}" alt="Axtra Logo">
    </div>
    
    <!-- Header -->
    <h1 class="auth-title">Welcome Back</h1>
    <p class="auth-subtitle">Sign in to continue your axe throwing journey</p>

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div><i class="fas fa-exclamation-circle me-2"></i>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <!-- Success Messages -->
    @session('status')
        <div class="alert alert-success">
            <i class="fas fa-check-circle me-2"></i>{{ $value }}
        </div>
    @endsession

    <!-- Login Form -->
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <input type="email" 
                   name="email" 
                   class="form-control" 
                   placeholder="Email address"
                   value="{{ old('email') }}" 
                   required 
                   autofocus 
                   autocomplete="username">
        </div>

        <div class="form-group">
            <input type="password" 
                   name="password" 
                   class="form-control" 
                   placeholder="Password"
                   required 
                   autocomplete="current-password">
        </div>

        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
            <label class="form-check-label" for="remember_me">
                Keep me signed in
            </label>
        </div>

        <button type="submit" class="btn-primary">
            Sign In to Axtra
        </button>

        <div class="auth-links">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">
                    Forgot your password?
                </a>
            @endif
        </div>

        @if (Route::has('register'))
            <div class="auth-links">
                <p>
                    New to Axtra? 
                    <a href="{{ route('register') }}">
                        Create an account
                    </a>
                </p>
            </div>
        @endif

        <!-- Social Login -->
        <div class="social-divider">
            <span>Or continue with</span>
        </div>
        
        <div class="social-buttons">
            @if (Route::has('auth.google'))
                <a href="{{ route('auth.google') }}" class="btn-social">
                    <i class="fab fa-google"></i>Google
                </a>
            @endif
            @if (Route::has('auth.apple'))
                <a href="{{ route('auth.apple') }}" class="btn-social">
                    <i class="fab fa-apple"></i>Apple
                </a>
            @endif
        </div>
    </form>
</x-guest-layout>