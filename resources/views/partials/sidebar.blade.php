<!-- Sidebar -->
<aside class="sidebar h-100" id="sidenav-main" 
       style="background: #1b1b1b; 
              border-radius: 0 1.5rem 1.5rem 0; 
              box-shadow: 0 20px 27px 0 rgba(27, 27, 27, 0.15);
              border-right: 1px solid rgba(192, 36, 37, 0.2);
              width: 320px;
              position: fixed;
              top: 0;
              left: 0;
              overflow-y: auto;
              z-index: 1000;
              /* Custom scrollbar */
              scrollbar-width: thin;
              scrollbar-color: rgba(192, 36, 37, 0.5) transparent;">
    
    <!-- Brand Header -->
    <div class="py-4 px-4" style="border-bottom: 1px solid rgba(192, 36, 37, 0.3);">
        <a href="{{ route('dashboard') }}" class="text-decoration-none d-flex align-items-center justify-content-center">
            <div class="text-center">
                <img src="{{ asset('images/brand/axtra-full.png') }}" 
                     style="height: 45px; max-width: 180px; object-fit: contain;" 
                     alt="Axtra Logo" class="mb-2"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='block'">
                <div style="display: none;">
                    <h3 class="text-white mb-0 fw-bold" style="color: #c02425 !important;">AXTRA</h3>
                    <small style="color: rgba(255, 255, 255, 0.7);">Swiss Axe Throwing</small>
                </div>
            </div>
        </a>
    </div>

    <!-- Admin Role Switcher -->
    @auth
        @if(auth()->user()->isAdmin())
            <div class="px-4 pb-3">
                <div class="dropdown">
                    <button class="btn d-flex align-items-center w-100" type="button" data-bs-toggle="dropdown" 
                            style="background: rgba(255, 255, 255, 0.08); 
                                   border: none; 
                                   color: white; 
                                   padding: 12px 16px; 
                                   border-radius: 15px;
                                   backdrop-filter: blur(10px);
                                   transition: all 0.3s ease;"
                            onmouseover="this.style.background='rgba(255, 255, 255, 0.15)';"
                            onmouseout="this.style.background='rgba(255, 255, 255, 0.08)';">
                        <div class="me-3 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; background: rgba(192, 36, 37, 0.15); border-radius: 10px; color: #c02425;">
                            @php
                                $currentView = session('admin_dashboard_view', 'admin');
                                $icon = $currentView === 'admin' ? 'fa-crown' : ($currentView === 'employee' ? 'fa-user-tie' : 'fa-user');
                                $color = $currentView === 'admin' ? '#c02425' : ($currentView === 'employee' ? '#17a2b8' : '#28a745');
                            @endphp
                            <i class="fas {{ $icon }}" style="color: {{ $color }};"></i>
                        </div>
                        <div class="flex-grow-1 text-start">
                            <div style="font-weight: 600; font-size: 0.9rem;">
                                @if($currentView === 'admin')
                                    Admin View
                                @elseif($currentView === 'employee')
                                    Employee View
                                @else
                                    Customer View
                                @endif
                            </div>
                            <small style="color: rgba(255, 255, 255, 0.6);">Switch dashboard role</small>
                        </div>
                        <i class="fas fa-chevron-down" style="color: rgba(255, 255, 255, 0.6); font-size: 0.8rem;"></i>
                    </button>
                    
                    <!-- Modern Role Switcher Dropdown -->
                    <div class="dropdown-menu w-100 p-0" style="background: rgba(17, 17, 17, 0.98); 
                                                              backdrop-filter: blur(40px);
                                                              border: none; 
                                                              border-radius: 15px;
                                                              box-shadow: 0 20px 60px rgba(0, 0, 0, 0.8), 0 0 0 1px rgba(255, 255, 255, 0.05);
                                                              transform: translateY(10px);
                                                              overflow: hidden;">
                        
                        <!-- Header -->
                        <div class="p-3" style="border-bottom: 1px solid rgba(255, 255, 255, 0.08);">
                            <h6 class="mb-0 fw-bold" style="color: white; font-size: 0.9rem;">Switch Dashboard View</h6>
                            <small style="color: rgba(255, 255, 255, 0.6);">Access different role interfaces</small>
                        </div>
                        
                        <!-- Role Options -->
                        <div class="py-2">
                            <a href="{{ route('admin.dashboard') }}" 
                               class="dropdown-item d-flex align-items-center px-3 py-3 {{ request()->routeIs('admin.*') ? 'current-role' : '' }}"
                               style="color: white; text-decoration: none; background: {{ request()->routeIs('admin.*') ? 'rgba(192, 36, 37, 0.15)' : 'transparent' }}; border: none; transition: all 0.2s ease;"
                               onmouseover="if (!this.classList.contains('current-role')) this.style.background='rgba(192, 36, 37, 0.1)';"
                               onmouseout="if (!this.classList.contains('current-role')) this.style.background='transparent';">
                                <div class="me-3 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background: rgba(192, 36, 37, 0.15); border-radius: 8px; color: #c02425;">
                                    <i class="fas fa-crown"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div style="font-weight: 600; font-size: 0.85rem;">Admin Dashboard</div>
                                    <small style="color: rgba(255, 255, 255, 0.6);">Full system access</small>
                                </div>
                                @if(request()->routeIs('admin.*'))
                                    <i class="fas fa-check-circle" style="color: #c02425; font-size: 0.9rem;"></i>
                                @endif
                            </a>
                            
                            <a href="{{ route('employee.dashboard') }}" 
                               class="dropdown-item d-flex align-items-center px-3 py-3 {{ request()->routeIs('employee.*') ? 'current-role' : '' }}"
                               style="color: white; text-decoration: none; background: {{ request()->routeIs('employee.*') ? 'rgba(23, 162, 184, 0.15)' : 'transparent' }}; border: none; transition: all 0.2s ease;"
                               onmouseover="if (!this.classList.contains('current-role')) this.style.background='rgba(23, 162, 184, 0.1)';"
                               onmouseout="if (!this.classList.contains('current-role')) this.style.background='transparent';">
                                <div class="me-3 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background: rgba(23, 162, 184, 0.15); border-radius: 8px; color: #17a2b8;">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div style="font-weight: 600; font-size: 0.85rem;">Employee Dashboard</div>
                                    <small style="color: rgba(255, 255, 255, 0.6);">Staff operations</small>
                                </div>
                                @if(request()->routeIs('employee.*'))
                                    <i class="fas fa-check-circle" style="color: #17a2b8; font-size: 0.9rem;"></i>
                                @endif
                            </a>
                            
                            <a href="{{ route('dashboard') }}" 
                               class="dropdown-item d-flex align-items-center px-3 py-3 {{ request()->routeIs('dashboard') || request()->routeIs('user.*') ? 'current-role' : '' }}"
                               style="color: white; text-decoration: none; background: {{ request()->routeIs('dashboard') || request()->routeIs('user.*') ? 'rgba(40, 167, 69, 0.15)' : 'transparent' }}; border: none; transition: all 0.2s ease;"
                               onmouseover="if (!this.classList.contains('current-role')) this.style.background='rgba(40, 167, 69, 0.1)';"
                               onmouseout="if (!this.classList.contains('current-role')) this.style.background='transparent';">
                                <div class="me-3 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background: rgba(40, 167, 69, 0.15); border-radius: 8px; color: #28a745;">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div style="font-weight: 600; font-size: 0.85rem;">Customer Dashboard</div>
                                    <small style="color: rgba(255, 255, 255, 0.6);">Customer experience</small>
                                </div>
                                @if(request()->routeIs('dashboard') || request()->routeIs('user.*'))
                                    <i class="fas fa-check-circle" style="color: #28a745; font-size: 0.9rem;"></i>
                                @endif
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endauth

    <!-- Navigation Menu -->
    <div class="flex-grow-1 py-3">
        @auth
            @if(auth()->user()->isAdmin())
                @php
                    $dashboardView = session('admin_dashboard_view', 'admin');
                @endphp
                @if($dashboardView === 'admin')
                    @include('partials.menus.admin')
                @elseif($dashboardView === 'employee')
                    @include('partials.menus.employee')
                @else
                    @include('partials.menus.customer')
                @endif
            @elseif(auth()->user()->isEmployee())
                @include('partials.menus.employee')
            @else
                @include('partials.menus.customer')
            @endif
        @endauth
    </div>

    <!-- User Profile Section -->
    @auth
    <div class="mt-auto px-3 pb-4">
        <!-- Quick Stats for Customers -->
        @if(!auth()->user()->isAdmin() && !auth()->user()->isEmployee())
            <div class="mb-3 p-3 rounded-3" style="background: rgba(192, 36, 37, 0.1); border: 1px solid #c02425;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <small style="color: rgba(255, 255, 255, 0.7); font-weight: 600; font-size: 0.7rem; letter-spacing: 1px;">SKILL LEVEL</small>
                    <small class="fw-bold" style="color: #c02425;">{{ auth()->user()->skill_points ?? 0 }} PTS</small>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fw-bold" style="color: white;">{{ ucfirst(auth()->user()->skill_level ?? 'Beginner') }}</span>
                    <small style="color: rgba(255, 255, 255, 0.7);">Level Progress</small>
                </div>
                <div class="progress" style="height: 6px; background: rgba(255, 255, 255, 0.1); border-radius: 3px;">
                    <div class="progress-bar" 
                         style="background: #c02425; width: {{ rand(25, 85) }}%; border-radius: 3px;"></div>
                </div>
            </div>
        @endif

        
    </div>
    @endauth
</aside>