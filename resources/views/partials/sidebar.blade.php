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
                    <button class="btn btn-outline-light btn-sm dropdown-toggle w-100 d-flex justify-content-between align-items-center" 
                            type="button" 
                            data-bs-toggle="dropdown" 
                            style="background: rgba(192, 36, 37, 0.1); border-color: rgba(192, 36, 37, 0.3);">
                        <span>
                            <i class="fas fa-user-shield me-2" style="color: #c02425;"></i>
                            Switch Role View
                        </span>
                    </button>
                    <ul class="dropdown-menu w-100" style="background: #2d2d2d; border: 1px solid rgba(192, 36, 37, 0.3);">
                        <li>
                            <a class="dropdown-item d-flex align-items-center {{ request()->routeIs('admin.*') ? 'active' : '' }}" 
                               href="{{ route('admin.dashboard') }}"
                               style="color: rgba(255, 255, 255, 0.8);">
                                <i class="fas fa-crown me-2" style="color: #c02425;"></i>
                                Admin Dashboard
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center {{ request()->routeIs('employee.*') ? 'active' : '' }}" 
                               href="{{ route('employee.dashboard') }}"
                               style="color: rgba(255, 255, 255, 0.8);">
                                <i class="fas fa-user-tie me-2" style="color: #17a2b8;"></i>
                                Employee Dashboard
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
                               href="{{ route('dashboard') }}"
                               style="color: rgba(255, 255, 255, 0.8);">
                                <i class="fas fa-user me-2" style="color: #28a745;"></i>
                                Customer Dashboard
                            </a>
                        </li>
                    </ul>
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