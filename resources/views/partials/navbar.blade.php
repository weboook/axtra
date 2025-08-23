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
            <!-- Left Side: Page Title & Search -->
            <div class="d-flex align-items-center">
                <!-- Mobile Menu Toggle -->
                <button class="btn d-lg-none me-3" id="sidebarToggle" style="background: rgba(192, 36, 37, 0.15); 
                                                                              border: none; 
                                                                              color: #c02425; 
                                                                              width: 40px; 
                                                                              height: 40px; 
                                                                              border-radius: 20px;
                                                                              display: flex;
                                                                              align-items: center;
                                                                              justify-content: center;">
                    <i class="fas fa-bars"></i>
                </button>
                
                <!-- Page Title -->
                <div class="me-4">
                    <h5 class="mb-0 fw-bold" style="color: white;">
                        @yield('page-title', 'Dashboard')
                    </h5>
                    @if(isset($breadcrumb) && $breadcrumb)
                        <small style="color: rgba(255, 255, 255, 0.6);">{{ $breadcrumb }}</small>
                    @endif
                </div>
                
                <!-- Search Bar -->
                <div class="me-4 d-none d-md-flex">
                    <div class="input-group" style="width: 320px;">
                        <span class="input-group-text" style="background: transparent; 
                                                              border: none; 
                                                              color: rgba(255, 255, 255, 0.7); 
                                                              border-radius: 25px 0 0 25px;
                                                              border-right: 1px solid rgba(255, 255, 255, 0.2);">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="search" class="form-control" placeholder="Search anything..." 
                               style="background: transparent; 
                                      border: none; 
                                      color: white; 
                                      border-radius: 0 25px 25px 0;
                                      padding-left: 0;"
                               onfocus="this.style.background='rgba(255, 255, 255, 0.1)'; this.previousElementSibling.style.background='rgba(255, 255, 255, 0.1)';"
                               onblur="this.style.background='transparent'; this.previousElementSibling.style.background='transparent';">
                    </div>
                </div>
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
                        
                        @if($notificationCount > 0)
                            <!-- Footer -->
                            <div class="p-3 text-center" style="border-top: 1px solid rgba(255, 255, 255, 0.08);">
                                <a href="{{ route('user.notifications') }}" class="text-decoration-none fw-semibold" 
                                   style="color: #c02425; font-size: 0.9rem;">
                                    View all notifications
                                </a>
                            </div>
                        @endif
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

<!-- Mobile Search (Hidden by default) -->
<div class="d-md-none" id="mobileSearch" style="display: none; background: #1b1b1b; border-bottom: 1px solid rgba(192, 36, 37, 0.2); padding: 1rem;">
    <div class="input-group">
        <span class="input-group-text" style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); color: rgba(255, 255, 255, 0.6);">
            <i class="fas fa-search"></i>
        </span>
        <input type="search" class="form-control" placeholder="Search..." 
               style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); color: white; border-left: none;">
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
</style>