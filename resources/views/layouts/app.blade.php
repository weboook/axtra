<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ isset($title) ? $title . ' - Axtra.ch' : 'Axtra.ch - Swiss Axe Throwing' }}</title>
        
        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
        <link rel="icon" type="image/png" href="{{ asset('images/brand/axtra-icon.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
        
        <!-- Icons -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <!-- Flatpickr CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_red.css">
        
        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
        @stack('styles')
        
        <style>
            /* Additional inline styles for immediate loading */
            body {
                font-family: 'Open Sans', sans-serif;
                background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
                color: #1b1b1b;
            }
            
            .main-wrapper {
                min-height: 100vh;
                display: flex;
            }
            
            .sidebar-wrapper {
                width: 320px;
                flex-shrink: 0;
            }
            
            .content-wrapper {
                flex: 1;
                display: flex;
                flex-direction: column;
                margin-left: 0; /* Remove margin */
            }
            
            @media (max-width: 991px) {
                .sidebar-wrapper {
                    position: fixed;
                    left: -320px;
                    top: 0;
                    height: 100vh;
                    z-index: 1050;
                    transition: left 0.3s ease;
                }
                
                .sidebar-wrapper.show {
                    left: 0;
                }
                
                .content-wrapper {
                    margin-left: 0;
                }
            }
            
            /* Custom scrollbar for sidebar */
            #sidenav-main::-webkit-scrollbar {
                width: 6px;
            }
            
            #sidenav-main::-webkit-scrollbar-track {
                background: transparent;
            }
            
            #sidenav-main::-webkit-scrollbar-thumb {
                background: rgba(192, 36, 37, 0.5);
                border-radius: 3px;
            }
            
            #sidenav-main::-webkit-scrollbar-thumb:hover {
                background: rgba(192, 36, 37, 0.8);
            }
            
            /* White placeholder text for search */
            .form-control::placeholder {
                color: rgba(255, 255, 255, 0.6) !important;
            }
            
            /* Navigation link hover states */
            .nav-link:not(.active):hover {
                background: rgba(192, 36, 37, 0.1) !important;
                border-color: rgba(192, 36, 37, 0.3) !important;
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
        </style>
    </head>
    <body class="antialiased">
        <x-banner />
        
        <div class="main-wrapper">
            <!-- Sidebar Wrapper -->
            <aside class="sidebar-wrapper" id="sidebar">
                @include('partials.sidebar')
            </aside>

            <!-- Content Wrapper -->
            <div class="content-wrapper">
                <!-- Top Navbar -->
                <header class="navbar-wrapper" style="z-index: 100; position: relative;">
                    @include('partials.navbar')
                </header>

                <!-- Main Content -->
                <main class="main-content flex-grow-1">
                    <div class="container-fluid px-4 py-3">
                        <!-- Flash Messages -->
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="background: var(--gradient-red); color: white; border: none; border-radius: 1rem; box-shadow: var(--axtra-shadow);">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle me-3 fs-5"></i>
                                    <div>
                                        <strong>Success!</strong> {{ session('success') }}
                                    </div>
                                </div>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="background: var(--danger); color: white; border: none; border-radius: 1rem; box-shadow: var(--soft-shadow-colored);">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-triangle me-3 fs-5"></i>
                                    <div>
                                        <strong>Error!</strong> {{ session('error') }}
                                    </div>
                                </div>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('warning'))
                            <div class="alert alert-warning alert-dismissible fade show mb-4" role="alert" style="background: var(--warning); color: var(--axtra-dark); border: none; border-radius: 1rem; box-shadow: var(--soft-shadow-colored);">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-circle me-3 fs-5"></i>
                                    <div>
                                        <strong>Warning!</strong> {{ session('warning') }}
                                    </div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('info'))
                            <div class="alert alert-info alert-dismissible fade show mb-4" role="alert" style="background: var(--info); color: white; border: none; border-radius: 1rem; box-shadow: var(--soft-shadow-colored);">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-info-circle me-3 fs-5"></i>
                                    <div>
                                        <strong>Info!</strong> {{ session('info') }}
                                    </div>
                                </div>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Page Header -->
                        @if (isset($header))
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="card border-0" style="background: var(--gradient-red); color: white; border-radius: 1rem; box-shadow: var(--axtra-shadow);">
                                        <div class="card-body py-4 px-4">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <h1 class="mb-0 h3 fw-bold">{{ $header }}</h1>
                                                @if(auth()->check())
                                                    <livewire:components.dashboard-switcher />
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Main Content Area -->
                        <div class="fade-in">
                            @isset($slot)
                                {{ $slot }}
                            @else
                                @yield('content')
                            @endisset
                        </div>
                    </div>

                    <!-- Footer -->
                    <footer class="mt-auto">
                        @include('partials.footer')
                    </footer>
                </main>
            </div>
        </div>

        <!-- Mobile Sidebar Toggle -->
        <button class="btn d-lg-none position-fixed" id="sidebarToggle" 
                style="top: 1rem; left: 1rem; z-index: 1100; background: var(--gradient-red); color: white; border: none; border-radius: 0.75rem; width: 50px; height: 50px; box-shadow: var(--axtra-shadow);">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Sidebar Overlay for Mobile -->
        <div class="sidebar-overlay d-lg-none" id="sidebarOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 1040;"></div>

        @stack('modals')

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        
        <!-- Flatpickr JS -->
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        
        @livewireScripts
        @stack('scripts')

        <!-- Enhanced JavaScript -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize components
                initializeSidebar();
                initializeAlerts();
                initializeLivewireEvents();
                
                // Auto-hide alerts after 5 seconds
                setTimeout(() => {
                    const alerts = document.querySelectorAll('.alert');
                    alerts.forEach(alert => {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    });
                }, 5000);
            });

            function initializeSidebar() {
                const sidebarToggle = document.getElementById('sidebarToggle');
                const sidebar = document.getElementById('sidebar');
                const sidebarOverlay = document.getElementById('sidebarOverlay');
                
                if (sidebarToggle) {
                    sidebarToggle.addEventListener('click', function() {
                        sidebar.classList.toggle('show');
                        if (sidebar.classList.contains('show')) {
                            sidebarOverlay.style.display = 'block';
                            sidebarOverlay.style.opacity = '1';
                        } else {
                            sidebarOverlay.style.display = 'none';
                        }
                    });
                }
                
                if (sidebarOverlay) {
                    sidebarOverlay.addEventListener('click', function() {
                        sidebar.classList.remove('show');
                        sidebarOverlay.style.display = 'none';
                    });
                }
            }

            function initializeAlerts() {
                // Custom alert functions
                window.showAlert = function(type, title, text) {
                    Swal.fire({
                        icon: type,
                        title: title,
                        text: text,
                        background: '#ffffff',
                        color: '#1b1b1b',
                        confirmButtonColor: '#c02425',
                        buttonsStyling: true,
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown animate__faster'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp animate__faster'
                        }
                    });
                };

                window.showSuccess = function(title, text = '') {
                    showAlert('success', title, text);
                };

                window.showError = function(title, text = '') {
                    showAlert('error', title, text);
                };

                window.showWarning = function(title, text = '') {
                    showAlert('warning', title, text);
                };

                window.showInfo = function(title, text = '') {
                    showAlert('info', title, text);
                };

                window.confirmAction = function(title, text, confirmText = 'Yes, do it!') {
                    return Swal.fire({
                        title: title,
                        text: text,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#c02425',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: confirmText,
                        cancelButtonText: 'Cancel',
                        background: '#ffffff',
                        color: '#1b1b1b'
                    });
                };
            }

            function initializeLivewireEvents() {
                // Listen for Livewire events and show alerts
                document.addEventListener('livewire:init', () => {
                    Livewire.on('alert', (event) => {
                        showAlert(event[0].type, event[0].title, event[0].text);
                    });

                    Livewire.on('success', (event) => {
                        showSuccess(event[0].title || 'Success!', event[0].text || '');
                    });

                    Livewire.on('error', (event) => {
                        showError(event[0].title || 'Error!', event[0].text || '');
                    });

                    Livewire.on('confirm', (event) => {
                        confirmAction(event[0].title, event[0].text, event[0].confirmText).then((result) => {
                            if (result.isConfirmed) {
                                Livewire.dispatch(event[0].callback, event[0].data || []);
                            }
                        });
                    });
                });
            }

            // Utility functions
            function fadeIn(element, duration = 300) {
                element.style.opacity = '0';
                element.style.display = 'block';
                
                let start = performance.now();
                
                function animate(time) {
                    let elapsed = time - start;
                    let progress = elapsed / duration;
                    
                    if (progress > 1) progress = 1;
                    
                    element.style.opacity = progress;
                    
                    if (progress < 1) {
                        requestAnimationFrame(animate);
                    }
                }
                
                requestAnimationFrame(animate);
            }

            // Navigation active state
            function setActiveNavigation() {
                const currentPath = window.location.pathname;
                const navLinks = document.querySelectorAll('.nav-link');
                
                navLinks.forEach(link => {
                    const href = link.getAttribute('href');
                    if (href === currentPath || (href !== '/' && currentPath.startsWith(href))) {
                        link.classList.add('active');
                    } else {
                        link.classList.remove('active');
                    }
                });
            }

            // Set active navigation on page load
            document.addEventListener('DOMContentLoaded', setActiveNavigation);
        </script>
    </body>
</html>
