<!-- Top Navigation Bar -->
<div class="d-flex justify-content-center pt-3 px-3">
    <nav class="navbar navbar-expand-lg p-0" style="background: rgba(27, 27, 27, 0.95); 
                                                      backdrop-filter: blur(20px); 
                                                      height: 65px; 
                                                      border-radius: 50px; 
                                                      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(192, 36, 37, 0.1);
                                                      border: 1px solid rgba(255, 255, 255, 0.1);
                                                      max-width: 95%;
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
                <ul class="dropdown-menu dropdown-menu-end" style="background: rgba(27, 27, 27, 0.95); 
                                                                   backdrop-filter: blur(20px);
                                                                   border: 1px solid rgba(255, 255, 255, 0.1); 
                                                                   border-radius: 20px;
                                                                   box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
                                                                   min-width: 300px;"
                    <li class="px-3 py-2" style="border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
                        <h6 class="mb-0" style="color: white;">Notifications</h6>
                    </li>
                    @php
                        try {
                            $notifications = auth()->user()->unreadNotifications->take(5);
                        } catch (Exception $e) {
                            $notifications = collect();
                        }
                    @endphp
                    @forelse($notifications as $notification)
                        <li class="px-3 py-2" style="border-bottom: 1px solid rgba(255, 255, 255, 0.05);">
                            <div style="color: rgba(255, 255, 255, 0.9); font-size: 0.9rem;">
                                {{ $notification->data['message'] ?? 'New notification' }}
                            </div>
                            <small style="color: rgba(255, 255, 255, 0.6);">{{ $notification->created_at->diffForHumans() }}</small>
                        </li>
                    @empty
                        <li class="px-3 py-3 text-center">
                            <span style="color: rgba(255, 255, 255, 0.6);">No new notifications</span>
                        </li>
                    @endforelse
                    @if($notificationCount > 0)
                        <li class="px-3 py-2 text-center" style="border-top: 1px solid rgba(255, 255, 255, 0.1);">
                            <a href="#" onclick="return false;" class="text-decoration-none" style="color: #c02425; font-size: 0.9rem;">
                                View all notifications
                            </a>
                        </li>
                    @endif
                </ul>
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
                
                <ul class="dropdown-menu dropdown-menu-end" style="background: rgba(27, 27, 27, 0.95); 
                                                                   backdrop-filter: blur(20px);
                                                                   border: 1px solid rgba(255, 255, 255, 0.1); 
                                                                   border-radius: 20px;
                                                                   box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
                                                                   min-width: 220px;"
                    <li class="px-3 py-2" style="border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
                        <div style="color: white; font-weight: 600;">{{ auth()->user()->name }}</div>
                        <small style="color: rgba(255, 255, 255, 0.6);">{{ auth()->user()->email }}</small>
                    </li>
                    
                    <li><a class="dropdown-item d-flex align-items-center" href="{{ route('user.profile') }}" 
                           style="color: rgba(255, 255, 255, 0.9); padding: 12px 16px;"
                           onmouseover="this.style.background='rgba(192, 36, 37, 0.1)'"
                           onmouseout="this.style.background='transparent'">
                        <i class="fas fa-user-circle me-2" style="color: #c02425;"></i> Profile
                    </a></li>
                    
                    @if(!auth()->user()->isAdmin() && !auth()->user()->isEmployee())
                        <li><a class="dropdown-item d-flex align-items-center" href="{{ route('user.bookings') }}" 
                               style="color: rgba(255, 255, 255, 0.9); padding: 12px 16px;"
                               onmouseover="this.style.background='rgba(192, 36, 37, 0.1)'"
                               onmouseout="this.style.background='transparent'">
                            <i class="fas fa-calendar-alt me-2" style="color: #c02425;"></i> My Bookings
                        </a></li>
                    @endif
                    
                    @if(auth()->user()->isAdmin())
                        <li><a class="dropdown-item d-flex align-items-center" href="{{ route('admin.dashboard') }}" 
                               style="color: rgba(255, 255, 255, 0.9); padding: 12px 16px;"
                               onmouseover="this.style.background='rgba(192, 36, 37, 0.1)'"
                               onmouseout="this.style.background='transparent'">
                            <i class="fas fa-crown me-2" style="color: #c02425;"></i> Admin Panel
                        </a></li>
                    @endif
                    
                    <li><hr class="dropdown-divider" style="border-color: rgba(255, 255, 255, 0.1);"></li>
                    
                    <li>
                        <form method="POST" action="{{ route('logout') }}" class="d-inline w-100">
                            @csrf
                            <button type="submit" class="dropdown-item d-flex align-items-center w-100 text-start" 
                                    style="color: rgba(255, 255, 255, 0.9); padding: 12px 16px; border: none; background: transparent;"
                                    onmouseover="this.style.background='rgba(192, 36, 37, 0.1)'"
                                    onmouseout="this.style.background='transparent'">
                                <i class="fas fa-sign-out-alt me-2" style="color: #c02425;"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
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