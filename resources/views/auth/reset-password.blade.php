<x-guest-layout>
    <!-- Logo -->
    <div class="auth-logo">
        <img src="{{ asset('images/brand/axtra-full-dark.png') }}" alt="Axtra Logo">
    </div>
    
    <!-- Header -->
    <h1 class="auth-title">Create New Password</h1>
    <p class="auth-subtitle">Enter your new password to complete the reset</p>

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div><i class="fas fa-exclamation-circle me-2"></i>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <!-- Reset Password Form -->
    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="form-group">
            <input type="email" 
                   name="email" 
                   class="form-control" 
                   placeholder="Email address"
                   value="{{ old('email', $request->email) }}" 
                   required 
                   autofocus 
                   autocomplete="username"
                   readonly>
        </div>

        <div class="form-group">
            <input type="password" 
                   name="password" 
                   class="form-control" 
                   placeholder="New password"
                   required 
                   autocomplete="new-password">
        </div>

        <div class="form-group">
            <input type="password" 
                   name="password_confirmation" 
                   class="form-control" 
                   placeholder="Confirm new password"
                   required 
                   autocomplete="new-password">
        </div>

        <button type="submit" class="btn-primary">
            Reset Password
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