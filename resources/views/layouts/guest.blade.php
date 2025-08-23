<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Axtra') }} - Book Your Experience</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_red.css">
    
    <!-- Custom Styles -->
    <style>
        :root {
            --axtra-red: #c02425;
            --axtra-red-dark: #a01e1f;
        }
        
        body {
            font-family: 'Open Sans', sans-serif;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
            color: #1b1b1b;
        }
        
        .btn-axtra {
            background: linear-gradient(135deg, var(--axtra-red) 0%, var(--axtra-red-dark) 100%);
            border: none;
            color: white;
            transition: all 0.3s ease;
        }
        
        .btn-axtra:hover {
            background: linear-gradient(135deg, var(--axtra-red-dark) 0%, var(--axtra-red) 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(192, 36, 37, 0.3);
        }
        
        .card {
            border: 0;
            border-radius: 1.25rem;
            background: white;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        }
        
        .card-header {
            background: white;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            border-radius: 1.25rem 1.25rem 0 0 !important;
        }
        
        .btn-primary, .btn-danger {
            background: linear-gradient(135deg, #c02425 0%, #d63031 100%);
            border: none;
            border-radius: 0.75rem;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover, .btn-danger:hover {
            background: linear-gradient(135deg, #d63031 0%, #c02425 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(192, 36, 37, 0.3);
        }
        
        .btn-outline-primary, .btn-outline-danger {
            border: 2px solid #c02425;
            color: #c02425;
            border-radius: 0.75rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-outline-primary:hover, .btn-outline-danger:hover {
            background: linear-gradient(135deg, #c02425 0%, #d63031 100%);
            border-color: #c02425;
            color: white;
            transform: translateY(-2px);
        }
        
        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #c02425;
            box-shadow: 0 0 0 0.2rem rgba(192, 36, 37, 0.15);
        }
        
        .badge {
            border-radius: 0.5rem;
            font-weight: 600;
            padding: 0.5rem 0.75rem;
        }
        
        /* Flatpickr custom styling */
        .flatpickr-calendar {
            border-radius: 1rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            border: none;
        }
        
        .flatpickr-day.selected {
            background: linear-gradient(135deg, #c02425 0%, #d63031 100%);
            border-color: #c02425;
        }
        
        .flatpickr-day:hover {
            background: rgba(192, 36, 37, 0.1);
            border-color: #c02425;
        }
        
        .text-axtra {
            color: var(--axtra-red) !important;
        }
        
        .border-axtra {
            border-color: var(--axtra-red) !important;
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
    <!-- Modern Header for Guest -->
    <nav class="navbar navbar-expand-lg py-4" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(0,0,0,0.05);">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/" style="color: #c02425; font-size: 1.5rem;">
                <i class="fas fa-bullseye me-2"></i>
                AXTRA
            </a>
            
            <div class="navbar-nav ms-auto">
                <a class="nav-link fw-semibold me-3" href="{{ route('login') }}" style="color: #1b1b1b;">
                    <i class="fas fa-sign-in-alt me-1"></i>Login
                </a>
                <a class="btn btn-primary" href="{{ route('register') }}">
                    <i class="fas fa-user-plus me-1"></i>Sign Up
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-5">
        {{ $slot }}
    </main>

    <!-- Simple Footer -->
    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-bullseye text-danger me-2"></i>
                        <span class="fw-bold">AXTRA</span>
                        <span class="ms-2 text-muted">Premium Axe Throwing Experience</span>
                    </div>
                </div>
                <div class="col-md-6 text-md-end">
                    <small class="text-muted">
                        © {{ date('Y') }} Axtra. All rights reserved.
                    </small>
                </div>
            </div>
        </div>
    </footer>

    <!-- Loading Indicator -->
    <div wire:loading.delay class="livewire-loading">
        <div class="spinner-border spinner-border-axtra" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    
    @livewireScripts
    @stack('scripts')
    
    <script>
        // Handle Livewire loading states
        document.addEventListener('livewire:navigating', () => {
            document.body.style.opacity = '0.7';
        });
        
        document.addEventListener('livewire:navigated', () => {
            document.body.style.opacity = '1';
        });
        
        // Smooth scrolling for step navigation
        document.addEventListener('DOMContentLoaded', function() {
            // Auto scroll to current step on load
            const currentStep = document.querySelector('[id^="step-"]');
            if (currentStep) {
                setTimeout(() => {
                    currentStep.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }, 500);
            }
        });
    </script>
</body>
</html>