<!-- Top Navigation Bar -->
<div class="d-flex justify-content-center pt-3 px-3">
    <nav class="navbar navbar-expand-lg p-0" style="background: rgba(27, 27, 27, 0.95); 
                                                      backdrop-filter: blur(20px); 
                                                      height: 65px; 
                                                      border-radius: 50px; 
                                                      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(192, 36, 37, 0.1);
                                                      border: 1px solid rgba(255, 255, 255, 0.1);
                                                      width: 100%;">
        <div class="container-fluid h-100 px-4">
            <!-- Left Side: Mobile Menu + Search -->
            <div class="d-flex align-items-center">
                <!-- Mobile Sidebar Toggle -->
                <button class="btn d-lg-none me-3" id="sidebarToggle" 
                        style="background: linear-gradient(135deg, #c02425 0%, #d63031 100%); 
                               color: white; 
                               border: none; 
                               border-radius: 8px; 
                               width: 40px; 
                               height: 40px; 
                               display: flex;
                               align-items: center;
                               justify-content: center;
                               box-shadow: 0 2px 8px rgba(192, 36, 37, 0.3);">
                    <i class="fas fa-bars" style="font-size: 0.9rem;"></i>
                </button>
                
                <!-- Search Bar (Desktop) / Search Icon (Mobile) -->
                <div class="flex-grow-1 me-4 d-none d-md-block">
                    @livewire('shared.search.search-index')
                </div>
                
                <!-- Mobile Search Icon -->
                <button class="btn d-md-none me-3" id="mobileSearchToggle"
                        style="background: rgba(255, 255, 255, 0.08); 
                               color: white; 
                               border: none; 
                               border-radius: 8px; 
                               width: 40px; 
                               height: 40px; 
                               display: flex;
                               align-items: center;
                               justify-content: center;
                               backdrop-filter: blur(10px);
                               transition: all 0.3s ease;"
                        onmouseover="this.style.background='rgba(255, 255, 255, 0.15)';"
                        onmouseout="this.style.background='rgba(255, 255, 255, 0.08)';">
                    <i class="fas fa-search" style="font-size: 0.9rem;"></i>
                </button>
            </div>
            
            <!-- Right Side -->
            <div class="d-flex align-items-center">
                <!-- Quick Actions -->
                <div class="me-3 d-none d-md-flex">
                    @if(!auth()->user()->isAdmin() && !auth()->user()->isEmployee())
                        <a href="{{ route('user.book') }}" class="btn btn-sm me-2" style="background: linear-gradient(135deg, #c02425 0%, #d63031 100%); 
                                                                                          color: white; 
                                                                                          border: none; 
                                                                                          padding: 10px 20px; 
                                                                                          border-radius: 25px;
                                                                                          font-weight: 600;
                                                                                          box-shadow: 0 4px 15px rgba(192, 36, 37, 0.3);
                                                                                          transition: all 0.3s ease;"
                               onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(192, 36, 37, 0.4)';"
                               onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(192, 36, 37, 0.3)';">
                            <i class="fas fa-plus me-1"></i> Quick Book
                        </a>
                    @endif
                    
                    @if(auth()->user()->isAdmin())
                        <button class="btn btn-sm me-2" style="background: rgba(255, 255, 255, 0.1); 
                                                              color: white; 
                                                              border: none; 
                                                              padding: 10px 20px; 
                                                              border-radius: 25px;
                                                              backdrop-filter: blur(10px);" 
                                title="Admin Panel">
                            <i class="fas fa-cog me-1"></i> Admin
                        </button>
                    @endif
                </div>
                
                <!-- Notifications -->
                <div class="dropdown me-3">
                    <button class="btn position-relative" type="button" id="notificationsDropdown" data-bs-toggle="dropdown" 
                            style="background: rgba(255, 255, 255, 0.08); 
                                   border: none; 
                                   color: white; 
                                   width: 45px; 
                                   height: 45px; 
                                   border-radius: 25px;
                                   backdrop-filter: blur(10px);
                                   transition: all 0.3s ease;"
                            onmouseover="this.style.background='rgba(255, 255, 255, 0.15)';"
                            onmouseout="this.style.background='rgba(255, 255, 255, 0.08)';">
                        <i class="fas fa-bell"></i>
                        @php
                            try {
                                $notificationCount = auth()->user()->unreadNotifications->count();
                            } catch (Exception $e) {
                                $notificationCount = 0;
                            }
                        @endphp
                        @if($notificationCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill" 
                                  style="background: #c02425; font-size: 0.6rem;">
                                {{ min($notificationCount, 99) }}
                            </span>
                        @endif
                    </button>
                    
                    <!-- Modern Notifications Dropdown -->
                    <div class="dropdown-menu dropdown-menu-end p-0" style="background: rgba(17, 17, 17, 0.98); 
                                                                           backdrop-filter: blur(40px);
                                                                           border: none; 
                                                                           border-radius: 20px;
                                                                           box-shadow: 0 20px 60px rgba(0, 0, 0, 0.8), 0 0 0 1px rgba(255, 255, 255, 0.05);
                                                                           min-width: 350px;
                                                                           transform: translateY(10px);
                                                                           z-index: 9999 !important;
                                                                           overflow: hidden;">
                        
                        <!-- Header -->
                        <div class="p-4" style="border-bottom: 1px solid rgba(255, 255, 255, 0.08);">
                            <div class="d-flex align-items-center justify-content-between">
                                <h6 class="mb-0 fw-bold" style="color: white;">Notifications</h6>
                                @if($notificationCount > 0)
                                    <span class="badge" style="background: #c02425; color: white; font-size: 0.75rem;">{{ $notificationCount }} new</span>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Notifications List -->
                        <div class="py-2" style="max-height: 400px; overflow-y: auto;">
                            @php
                                try {
                                    $notifications = auth()->user()->unreadNotifications->take(5);
                                } catch (Exception $e) {
                                    $notifications = collect();
                                }
                            @endphp
                            @forelse($notifications as $notification)
                                <div class="px-4 py-3" style="border-bottom: 1px solid rgba(255, 255, 255, 0.05); transition: background 0.2s ease;"
                                     onmouseover="this.style.background='rgba(192, 36, 37, 0.05)'"
                                     onmouseout="this.style.background='transparent'">
                                    <div class="d-flex">
                                        <div class="me-3">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                                 style="width: 40px; height: 40px; background: rgba(192, 36, 37, 0.15); color: #c02425;">
                                                <i class="fas fa-bell"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div style="color: white; font-weight: 600; font-size: 0.9rem; line-height: 1.4;">
                                                {{ $notification->data['message'] ?? 'New notification' }}
                                            </div>
                                            <small style="color: rgba(255, 255, 255, 0.6);">{{ $notification->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="px-4 py-5 text-center">
                                    <div class="mb-3">
                                        <i class="fas fa-bell-slash" style="font-size: 2rem; color: rgba(255, 255, 255, 0.3);"></i>
                                    </div>
                                    <div style="color: rgba(255, 255, 255, 0.6); font-weight: 500;">No new notifications</div>
                                    <small style="color: rgba(255, 255, 255, 0.4);">You're all caught up!</small>
                                </div>
                            @endforelse
                        </div>
                        
                        <!-- Footer -->
                        <div class="p-3 text-center" style="border-top: 1px solid rgba(255, 255, 255, 0.08);">
                            <a href="{{ route('user.notifications') }}" class="text-decoration-none fw-semibold" 
                               style="color: #c02425; font-size: 0.9rem;">
                                View all notifications
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- User Menu -->
                <div class="dropdown">
                    <button class="btn d-flex align-items-center" type="button" id="userDropdown" data-bs-toggle="dropdown" 
                            style="background: rgba(255, 255, 255, 0.08); 
                                   border: none; 
                                   color: white; 
                                   padding: 8px 16px; 
                                   border-radius: 25px;
                                   backdrop-filter: blur(10px);
                                   transition: all 0.3s ease;"
                            onmouseover="this.style.background='rgba(255, 255, 255, 0.15)';"
                            onmouseout="this.style.background='rgba(255, 255, 255, 0.08)';">
                        <div class="me-2">
                            @if(auth()->user()->profile_photo_path)
                                <img src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}" 
                                     style="width: 30px; height: 30px; border-radius: 50%; border: 2px solid #c02425; object-fit: cover;">
                            @else
                                <div style="width: 30px; height: 30px; background: #c02425; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 0.9rem;">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div class="text-start d-none d-lg-block">
                            <div style="font-weight: 600; font-size: 0.9rem; color: white;">{{ auth()->user()->name }}</div>
                        </div>
                        <i class="fas fa-chevron-down ms-2" style="font-size: 0.8rem; color: rgba(255, 255, 255, 0.6);"></i>
                    </button>
                    
                    <!-- Modern Profile Dropdown -->
                    <div class="dropdown-menu dropdown-menu-end p-0" style="background: rgba(17, 17, 17, 0.98); 
                                                                           backdrop-filter: blur(40px);
                                                                           border: none; 
                                                                           border-radius: 20px;
                                                                           box-shadow: 0 20px 60px rgba(0, 0, 0, 0.8), 0 0 0 1px rgba(255, 255, 255, 0.05);
                                                                           min-width: 280px;
                                                                           transform: translateY(10px);
                                                                           z-index: 9999 !important;
                                                                           overflow: hidden;">
                        
                        <!-- User Header -->
                        <div class="p-4" style="border-bottom: 1px solid rgba(255, 255, 255, 0.08);">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    @if(auth()->user()->profile_photo_path)
                                        <img src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}" 
                                             style="width: 50px; height: 50px; border-radius: 50%; border: 3px solid #c02425; object-fit: cover;">
                                    @else
                                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #c02425 0%, #d63031 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.2rem; color: white; border: 3px solid rgba(192, 36, 37, 0.3);">
                                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-bold" style="color: white; font-size: 1rem;">{{ auth()->user()->name }}</h6>
                                    <p class="mb-0" style="color: rgba(255, 255, 255, 0.6); font-size: 0.85rem;">{{ auth()->user()->email }}</p>
                                    <span class="badge mt-1" style="background: linear-gradient(135deg, #c02425 0%, #d63031 100%); color: white; font-size: 0.7rem; padding: 4px 8px; border-radius: 12px;">
                                        @if(auth()->user()->isAdmin())
                                            <i class="fas fa-crown me-1"></i> Administrator
                                        @elseif(auth()->user()->isEmployee())
                                            <i class="fas fa-user-tie me-1"></i> Employee
                                        @else
                                            <i class="fas fa-user me-1"></i> Customer
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Menu Items -->
                        <div class="py-2">
                            <a href="{{ route('user.profile') }}" class="dropdown-item d-flex align-items-center px-4 py-3" 
                               style="color: white; text-decoration: none; background: transparent; border: none; transition: all 0.2s ease;"
                               onmouseover="this.style.background='rgba(192, 36, 37, 0.1)';"
                               onmouseout="this.style.background='transparent';">
                                <div class="me-3 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; background: rgba(192, 36, 37, 0.15); border-radius: 10px; color: #c02425;">
                                    <i class="fas fa-user-edit"></i>
                                </div>
                                <div>
                                    <div style="font-weight: 600; font-size: 0.9rem;">Edit Profile</div>
                                    <small style="color: rgba(255, 255, 255, 0.6);">Manage your account</small>
                                </div>
                            </a>
                            
                            @if(!auth()->user()->isAdmin() && !auth()->user()->isEmployee())
                                <a href="{{ route('user.bookings') }}" class="dropdown-item d-flex align-items-center px-4 py-3" 
                                   style="color: white; text-decoration: none; background: transparent; border: none; transition: all 0.2s ease;"
                                   onmouseover="this.style.background='rgba(52, 152, 219, 0.1)';"
                                   onmouseout="this.style.background='transparent';">
                                    <div class="me-3 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; background: rgba(52, 152, 219, 0.15); border-radius: 10px; color: #3498db;">
                                        <i class="fas fa-calendar-check"></i>
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; font-size: 0.9rem;">My Bookings</div>
                                        <small style="color: rgba(255, 255, 255, 0.6);">View reservations</small>
                                    </div>
                                </a>
                                
                                <a href="{{ route('leaderboard.public') }}" class="dropdown-item d-flex align-items-center px-4 py-3" 
                                   style="color: white; text-decoration: none; background: transparent; border: none; transition: all 0.2s ease;"
                                   onmouseover="this.style.background='rgba(241, 196, 15, 0.1)';"
                                   onmouseout="this.style.background='transparent';">
                                    <div class="me-3 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; background: rgba(241, 196, 15, 0.15); border-radius: 10px; color: #f1c40f;">
                                        <i class="fas fa-trophy"></i>
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; font-size: 0.9rem;">Leaderboard</div>
                                        <small style="color: rgba(255, 255, 255, 0.6);">View rankings</small>
                                    </div>
                                </a>
                            @endif
                            
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="dropdown-item d-flex align-items-center px-4 py-3" 
                                   style="color: white; text-decoration: none; background: transparent; border: none; transition: all 0.2s ease;"
                                   onmouseover="this.style.background='rgba(142, 68, 173, 0.1)';"
                                   onmouseout="this.style.background='transparent';">
                                    <div class="me-3 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; background: rgba(142, 68, 173, 0.15); border-radius: 10px; color: #8e44ad;">
                                        <i class="fas fa-crown"></i>
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; font-size: 0.9rem;">Admin Panel</div>
                                        <small style="color: rgba(255, 255, 255, 0.6);">Manage system</small>
                                    </div>
                                </a>
                            @endif
                        </div>
                        
                        <!-- Divider -->
                        <hr style="border-color: rgba(255, 255, 255, 0.08); margin: 0.5rem 1rem;">
                        
                        <!-- Logout -->
                        <div class="pb-2">
                            <form method="POST" action="{{ route('logout') }}" class="w-100">
                                @csrf
                                <button type="submit" class="dropdown-item d-flex align-items-center px-4 py-3 w-100 text-start" 
                                        style="color: #ff6b6b; background: transparent; border: none; transition: all 0.2s ease;"
                                        onmouseover="this.style.background='rgba(255, 107, 107, 0.1)';"
                                        onmouseout="this.style.background='transparent';">
                                    <div class="me-3 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; background: rgba(255, 107, 107, 0.15); border-radius: 10px; color: #ff6b6b;">
                                        <i class="fas fa-sign-out-alt"></i>
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; font-size: 0.9rem;">Sign Out</div>
                                        <small style="color: rgba(255, 255, 255, 0.6);">Logout from account</small>
                                    </div>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</div>

<!-- Mobile Search Modal (Hidden by default) -->
<div class="d-md-none position-fixed w-100" id="mobileSearchModal" 
     style="display: none; 
            top: 0; 
            left: 0; 
            z-index: 9999; 
            background: rgba(0, 0, 0, 0.8); 
            backdrop-filter: blur(10px);
            height: 100vh;">
    
    <!-- Search Container -->
    <div style="background: rgba(27, 27, 27, 0.98); 
                backdrop-filter: blur(20px);
                border-bottom: 1px solid rgba(192, 36, 37, 0.2);
                padding: 80px 20px 20px 20px;">
        
        <!-- Close Button -->
        <button class="btn position-absolute" id="closeMobileSearch"
                style="top: 20px; 
                       right: 20px; 
                       background: rgba(255, 255, 255, 0.1);
                       color: white;
                       border: none;
                       width: 40px;
                       height: 40px;
                       border-radius: 50%;
                       display: flex;
                       align-items: center;
                       justify-content: center;">
            <i class="fas fa-times"></i>
        </button>
        
        <!-- Search Input -->
        <div class="input-group">
            <span class="input-group-text" 
                  style="background: rgba(192, 36, 37, 0.2); 
                         border: 1px solid rgba(192, 36, 37, 0.3); 
                         color: #c02425;
                         border-radius: 15px 0 0 15px;">
                <i class="fas fa-search"></i>
            </span>
            <input type="search" class="form-control" placeholder="Search anything..." id="mobileSearchInput"
                   style="background: rgba(255, 255, 255, 0.1); 
                          border: 1px solid rgba(192, 36, 37, 0.3); 
                          color: white; 
                          border-left: none;
                          border-radius: 0 15px 15px 0;
                          padding: 15px;
                          font-size: 16px;">
        </div>
        
        <!-- Search Suggestions/Results would go here -->
        <div class="mt-3" style="color: rgba(255, 255, 255, 0.6); text-align: center;">
            <i class="fas fa-search" style="font-size: 2rem; margin-bottom: 10px; opacity: 0.3;"></i>
            <p>Start typing to search...</p>
        </div>
    </div>
</div>

<style>
    @keyframes dropdownSlide {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(10px);
        }
    }
    
    .dropdown-menu {
        animation: dropdownSlide 0.2s ease-out;
    }
    
    /* Mobile navbar fixes */
    @media (max-width: 991px) {
        .navbar {
            height: auto !important;
            min-height: 65px;
            padding: 8px 12px !important;
        }
        
        .navbar .container-fluid {
            padding: 0 !important;
        }
        
        /* Mobile sidebar toggle button */
        #sidebarToggle {
            flex-shrink: 0;
            width: 42px !important;
            height: 42px !important;
            margin-right: 12px;
        }
        
        /* Search bar on mobile - now just icon */
        .navbar .d-flex:first-child {
            flex-wrap: nowrap;
            align-items: center;
            gap: 8px;
        }
        
        /* Mobile search icon styling */
        #mobileSearchToggle {
            flex-shrink: 0;
        }
        
        /* All dropdowns base mobile styles */
        .dropdown-menu {
            max-width: calc(100vw - 40px) !important;
            right: 0 !important;
            left: auto !important;
        }
        
        /* Hide user name on very small screens */
        .d-none.d-lg-block {
            display: none !important;
        }
        
        /* User dropdown mobile */
        .dropdown-menu:not(.dropdown-menu-end):not([style*="min-width"]) {
            min-width: 260px !important;
            max-width: calc(100vw - 40px) !important;
        }
        
        /* Notification dropdown mobile */
        .dropdown-menu.dropdown-menu-end {
            min-width: 280px !important;
            max-width: calc(100vw - 40px) !important;
            right: 10px !important;
            left: auto !important;
        }
        
        /* Role switcher dropdown mobile */
        .dropdown-menu[style*="min-width"] {
            min-width: 250px !important;
            max-width: calc(100vw - 40px) !important;
            right: 10px !important;
            left: auto !important;
        }
        
        /* Ensure all dropdowns stay within viewport */
        .navbar .dropdown {
            position: relative !important;
        }
        
        .navbar .dropdown-menu {
            position: absolute !important;
            z-index: 9999 !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
            border: 1px solid rgba(0, 0, 0, 0.1) !important;
            border-radius: 12px !important;
            top: 100% !important;
            right: 0 !important;
            left: auto !important;
            margin-top: 5px !important;
        }
        
        /* Specific positioning for notifications dropdown */
        #notificationsDropdown + .dropdown-menu {
            right: 0 !important;
            left: auto !important;
            transform: translateX(0) !important;
        }
        
        /* Role switcher dropdown positioning */
        .dropdown-menu[aria-labelledby*="role"] {
            right: 0 !important;
            left: auto !important;
            transform: translateX(0) !important;
        }
        
        /* Mobile quick actions */
        .d-none.d-md-flex {
            display: none !important;
        }
    }
    
    /* Small mobile screens */
    @media (max-width: 575px) {
        .navbar {
            margin: 0 8px;
            width: calc(100% - 16px);
        }
        
        .navbar .container-fluid {
            gap: 8px;
        }
        
        #sidebarToggle {
            width: 38px !important;
            height: 38px !important;
            margin-right: 8px;
        }
        
        /* User button smaller */
        button[id="userDropdown"] {
            padding: 6px 12px !important;
        }
        
        button[id="userDropdown"] div:first-child img,
        button[id="userDropdown"] div:first-child div {
            width: 28px !important;
            height: 28px !important;
        }
        
        /* Notifications button smaller */
        button[id="notificationsDropdown"] {
            width: 40px !important;
            height: 40px !important;
        }
        
        /* Dropdowns more compact on small screens */
        .dropdown-menu {
            max-width: calc(100vw - 30px) !important;
            right: 15px !important;
            left: auto !important;
        }
        
        /* All specific dropdowns on small screens */
        .dropdown-menu.dropdown-menu-end,
        .dropdown-menu[style*="min-width"],
        .dropdown-menu:not(.dropdown-menu-end):not([style*="min-width"]) {
            max-width: calc(100vw - 30px) !important;
            right: 15px !important;
            left: auto !important;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mobile search functionality
    const mobileSearchToggle = document.getElementById('mobileSearchToggle');
    const mobileSearchModal = document.getElementById('mobileSearchModal');
    const closeMobileSearch = document.getElementById('closeMobileSearch');
    const mobileSearchInput = document.getElementById('mobileSearchInput');
    
    if (mobileSearchToggle && mobileSearchModal) {
        // Open mobile search modal
        mobileSearchToggle.addEventListener('click', function() {
            mobileSearchModal.style.display = 'block';
            // Focus on input after a short delay to ensure modal is visible
            setTimeout(() => {
                if (mobileSearchInput) {
                    mobileSearchInput.focus();
                }
            }, 100);
        });
        
        // Close mobile search modal
        if (closeMobileSearch) {
            closeMobileSearch.addEventListener('click', function() {
                mobileSearchModal.style.display = 'none';
            });
        }
        
        // Close on backdrop click
        mobileSearchModal.addEventListener('click', function(e) {
            if (e.target === mobileSearchModal) {
                mobileSearchModal.style.display = 'none';
            }
        });
        
        // Close on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && mobileSearchModal.style.display === 'block') {
                mobileSearchModal.style.display = 'none';
            }
        });
    }
});
</script>