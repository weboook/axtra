<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Axtra') }}</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom Styles -->
    <style>
        :root {
            --axtra-red: #c02425;
            --axtra-red-dark: #a01e1f;
        }
        
        body {
            font-family: 'Figtree', sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            overflow: hidden;
        }
        
        .auth-container {
            display: flex;
            height: 100vh;
        }
        
        .auth-form {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            padding: 2rem;
        }
        
        .auth-video {
            flex: 1;
            position: relative;
            overflow: hidden;
        }
        
        .auth-video iframe {
            width: 100%;
            height: 100vh;
            border: none;
            position: absolute;
            top: 0;
            left: 0;
            pointer-events: none; /* Prevent interaction with video */
        }
        
        .auth-video-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(192, 36, 37, 0.8) 0%, rgba(0, 0, 0, 0.6) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
        }
        
        .auth-video-content {
            max-width: 400px;
            padding: 2rem;
        }
        
        .auth-video-content h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .auth-video-content p {
            font-size: 1.2rem;
            opacity: 0.9;
        }
        
        .auth-form-inner {
            width: 100%;
            max-width: 400px;
        }
        
        .auth-logo {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .auth-logo img {
            max-height: 60px;
            width: auto;
        }
        
        .auth-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1b1b1b;
            text-align: center;
            margin-bottom: 0.5rem;
        }
        
        .auth-subtitle {
            color: #6c757d;
            text-align: center;
            margin-bottom: 2rem;
            font-size: 1.1rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-control {
            padding: 1rem;
            font-size: 1rem;
            border-radius: 0.75rem;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
            width: 100%;
        }
        
        .form-control:focus {
            border-color: var(--axtra-red);
            box-shadow: 0 0 0 0.2rem rgba(192, 36, 37, 0.15);
            outline: none;
        }
        
        .form-check {
            margin-bottom: 1.5rem;
            text-align: left;
        }
        
        .form-check-input:checked {
            background-color: var(--axtra-red);
            border-color: var(--axtra-red);
        }
        
        .form-check-input:focus {
            border-color: var(--axtra-red);
            box-shadow: 0 0 0 0.25rem rgba(192, 36, 37, 0.25);
        }
        
        .btn-primary {
            width: 100%;
            padding: 1rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 0.75rem;
            border: none;
            background: linear-gradient(135deg, var(--axtra-red) 0%, var(--axtra-red-dark) 100%);
            color: white;
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
            cursor: pointer;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--axtra-red-dark) 0%, var(--axtra-red) 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(192, 36, 37, 0.3);
            color: white;
        }
        
        .auth-links {
            text-align: center;
            margin-bottom: 1rem;
        }
        
        .auth-links a {
            color: var(--axtra-red);
            text-decoration: none;
            font-weight: 500;
        }
        
        .auth-links a:hover {
            color: var(--axtra-red-dark);
            text-decoration: underline;
        }
        
        .social-divider {
            text-align: center;
            margin: 2rem 0 1rem;
            position: relative;
        }
        
        .social-divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e9ecef;
        }
        
        .social-divider span {
            background: white;
            padding: 0 1rem;
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .social-buttons {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .btn-social {
            flex: 1;
            padding: 0.75rem 1rem;
            border: 2px solid #e9ecef;
            border-radius: 0.75rem;
            color: #495057;
            text-decoration: none;
            font-weight: 500;
            text-align: center;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .btn-social:hover {
            border-color: var(--axtra-red);
            color: var(--axtra-red);
            background: rgba(192, 36, 37, 0.05);
            text-decoration: none;
        }
        
        .alert {
            border-radius: 0.75rem;
            padding: 1rem;
            margin-bottom: 1.5rem;
            border: none;
        }
        
        .alert-danger {
            background: rgba(220, 53, 69, 0.1);
            color: #721c24;
        }
        
        .alert-success {
            background: rgba(25, 135, 84, 0.1);
            color: #0f5132;
        }
        
        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .auth-container {
                flex-direction: column;
            }
            
            .auth-video {
                display: none;
            }
            
            body {
                overflow: auto;
                height: auto;
            }
        }
        
        /* Loading spinner */
        .livewire-loading {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
        }
        
        .spinner-border-axtra {
            color: var(--axtra-red);
        }
    </style>
    
    @livewireStyles
</head>
<body>
    <div class="auth-container">
        <!-- Auth Form Section -->
        <div class="auth-form">
            <div class="auth-form-inner">
                {{ $slot }}
            </div>
        </div>
        
        <!-- Video Section -->
        <div class="auth-video">
            <iframe 
                src="https://www.youtube.com/embed/HaqcFlAi_5I?controls=0&rel=0&playsinline=1&cc_load_policy=0&enablejsapi=1&autoplay=1&mute=1&loop=1&playlist=HaqcFlAi_5I&origin=https%3A%2F%2Faxtra.ch&widgetid=1&forigin=https%3A%2F%2Faxtra.ch%2F&aoriginsup=1&vf=6"
                frameborder="0" 
                allow="autoplay; encrypted-media" 
                allowfullscreen
                style="width: 100%; height: 100vh; object-fit: cover;">
            </iframe>
            <div class="auth-video-overlay">
                <div class="auth-video-content">
                    <h2>Welcome to Axtra</h2>
                    <p>Experience the thrill of axe throwing in Switzerland's premier venue</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Indicator -->
    <div wire:loading.delay class="livewire-loading">
        <div class="spinner-border spinner-border-axtra" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @livewireScripts
    @stack('scripts')
</body>
</html>