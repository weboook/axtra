<!-- Admin Navigation Menu -->
<nav class="px-3">
    <!-- Dashboard Section -->
    <div class="nav-section mb-4">
        <small class="nav-section-title fw-bold text-uppercase px-3 mb-2 d-block" style="color: rgba(255, 255, 255, 0.7); font-size: 0.7rem; letter-spacing: 1px;">Overview</small>
        
        <!-- Dashboard -->
        <a class="nav-link d-flex align-items-center mb-1 rounded-3 text-decoration-none {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
           href="{{ route('admin.dashboard') }}"
           style="color: {{ request()->routeIs('admin.dashboard') ? 'white' : 'rgba(255, 255, 255, 0.8)' }};
                  background: {{ request()->routeIs('admin.dashboard') ? '#c02425' : 'transparent' }};
                  transition: all 0.3s ease;
                  border: 1px solid {{ request()->routeIs('admin.dashboard') ? '#c02425' : 'transparent' }};
                  padding: 0.7rem 0.75rem !important;">
            <div class="me-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                <i class="fas fa-tachometer-alt"></i>
            </div>
            <div class="flex-grow-1">
                <h6 class="mb-0 fw-semibold" style="font-size: 0.9rem;">Dashboard</h6>
                <small class="opacity-75" style="font-size: 0.75rem;">System overview</small>
            </div>
        </a>
    </div>

    <!-- User Management Section -->
    <div class="nav-section mb-4">
        <small class="nav-section-title fw-bold text-uppercase px-3 mb-2 d-block" style="color: rgba(255, 255, 255, 0.7); font-size: 0.7rem; letter-spacing: 1px;">User Management</small>
        
        <!-- Users -->
        <a class="nav-link d-flex align-items-center mb-1 rounded-3 text-decoration-none {{ request()->routeIs('admin.users*') ? 'active' : '' }}" 
           href="{{ route('admin.users') }}"
           style="color: {{ request()->routeIs('admin.users*') ? 'white' : 'rgba(255, 255, 255, 0.8)' }};
                  background: {{ request()->routeIs('admin.users*') ? '#c02425' : 'transparent' }};
                  transition: all 0.3s ease;
                  border: 1px solid {{ request()->routeIs('admin.users*') ? '#c02425' : 'transparent' }};
                  padding: 0.7rem 0.75rem !important;">
            <div class="me-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                <i class="fas fa-users"></i>
            </div>
            <div class="flex-grow-1">
                <h6 class="mb-0 fw-semibold" style="font-size: 0.9rem;">Users</h6>
                <small class="opacity-75" style="font-size: 0.75rem;">Manage accounts</small>
            </div>
        </a>

        <!-- Employees -->
        <a class="nav-link d-flex align-items-center mb-1 rounded-3 text-decoration-none {{ request()->routeIs('admin.employees*') ? 'active' : '' }}" 
           href="{{ route('admin.employees') }}"
           style="color: {{ request()->routeIs('admin.employees*') ? 'white' : 'rgba(255, 255, 255, 0.8)' }};
                  background: {{ request()->routeIs('admin.employees*') ? '#c02425' : 'transparent' }};
                  transition: all 0.3s ease;
                  border: 1px solid {{ request()->routeIs('admin.employees*') ? '#c02425' : 'transparent' }};
                  padding: 0.7rem 0.75rem !important;">
            <div class="me-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                <i class="fas fa-user-tie"></i>
            </div>
            <div class="flex-grow-1">
                <h6 class="mb-0 fw-semibold" style="font-size: 0.9rem;">Employees</h6>
                <small class="opacity-75" style="font-size: 0.75rem;">Staff management</small>
            </div>
        </a>
    </div>

    <!-- Business Management Section -->
    <div class="nav-section mb-4">
        <small class="nav-section-title fw-bold text-uppercase px-3 mb-2 d-block" style="color: rgba(255, 255, 255, 0.7); font-size: 0.7rem; letter-spacing: 1px;">Business</small>
        
        <!-- Products -->
        <a class="nav-link d-flex align-items-center mb-1 rounded-3 text-decoration-none {{ request()->routeIs('admin.products*') ? 'active' : '' }}" 
           href="{{ route('admin.products') }}"
           style="color: {{ request()->routeIs('admin.products*') ? 'white' : 'rgba(255, 255, 255, 0.8)' }};
                  background: {{ request()->routeIs('admin.products*') ? '#c02425' : 'transparent' }};
                  transition: all 0.3s ease;
                  border: 1px solid {{ request()->routeIs('admin.products*') ? '#c02425' : 'transparent' }};
                  padding: 0.7rem 0.75rem !important;">
            <div class="me-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                <i class="fas fa-box-open"></i>
            </div>
            <div class="flex-grow-1">
                <h6 class="mb-0 fw-semibold" style="font-size: 0.9rem;">Products</h6>
                <small class="opacity-75" style="font-size: 0.75rem;">Inventory management</small>
            </div>
        </a>

        <!-- Lanes -->
        <a class="nav-link d-flex align-items-center mb-1 rounded-3 text-decoration-none {{ request()->routeIs('admin.lanes*') ? 'active' : '' }}" 
           href="{{ route('admin.lanes') }}"
           style="color: {{ request()->routeIs('admin.lanes*') ? 'white' : 'rgba(255, 255, 255, 0.8)' }};
                  background: {{ request()->routeIs('admin.lanes*') ? '#c02425' : 'transparent' }};
                  transition: all 0.3s ease;
                  border: 1px solid {{ request()->routeIs('admin.lanes*') ? '#c02425' : 'transparent' }};
                  padding: 0.7rem 0.75rem !important;">
            <div class="me-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                <i class="fas fa-bullseye"></i>
            </div>
            <div class="flex-grow-1">
                <h6 class="mb-0 fw-semibold" style="font-size: 0.9rem;">Lanes</h6>
                <small class="opacity-75" style="font-size: 0.75rem;">Lane configuration</small>
            </div>
        </a>

        <!-- Levels -->
        <a class="nav-link d-flex align-items-center mb-1 rounded-3 text-decoration-none {{ request()->routeIs('admin.levels*') ? 'active' : '' }}" 
           href="{{ route('admin.levels') }}"
           style="color: {{ request()->routeIs('admin.levels*') ? 'white' : 'rgba(255, 255, 255, 0.8)' }};
                  background: {{ request()->routeIs('admin.levels*') ? '#c02425' : 'transparent' }};
                  transition: all 0.3s ease;
                  border: 1px solid {{ request()->routeIs('admin.levels*') ? '#c02425' : 'transparent' }};
                  padding: 0.7rem 0.75rem !important;">
            <div class="me-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                <i class="fas fa-medal"></i>
            </div>
            <div class="flex-grow-1">
                <h6 class="mb-0 fw-semibold" style="font-size: 0.9rem;">Levels</h6>
                <small class="opacity-75" style="font-size: 0.75rem;">Skill progression</small>
            </div>
        </a>

        <!-- Achievements -->
        <a class="nav-link d-flex align-items-center mb-1 rounded-3 text-decoration-none {{ request()->routeIs('admin.achievements*') ? 'active' : '' }}" 
           href="{{ route('admin.achievements') }}"
           style="color: {{ request()->routeIs('admin.achievements*') ? 'white' : 'rgba(255, 255, 255, 0.8)' }};
                  background: {{ request()->routeIs('admin.achievements*') ? '#c02425' : 'transparent' }};
                  transition: all 0.3s ease;
                  border: 1px solid {{ request()->routeIs('admin.achievements*') ? '#c02425' : 'transparent' }};
                  padding: 0.7rem 0.75rem !important;">
            <div class="me-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                <i class="fas fa-trophy"></i>
            </div>
            <div class="flex-grow-1">
                <h6 class="mb-0 fw-semibold" style="font-size: 0.9rem;">Achievements</h6>
                <small class="opacity-75" style="font-size: 0.75rem;">Reward system</small>
            </div>
        </a>
    </div>

    <!-- Marketing Section -->
    <div class="nav-section mb-4">
        <small class="nav-section-title fw-bold text-uppercase px-3 mb-2 d-block" style="color: rgba(255, 255, 255, 0.7); font-size: 0.7rem; letter-spacing: 1px;">Marketing</small>
        
        <!-- Coupons -->
        <a class="nav-link d-flex align-items-center mb-1 rounded-3 text-decoration-none {{ request()->routeIs('admin.coupons*') ? 'active' : '' }}" 
           href="{{ route('admin.coupons') }}"
           style="color: {{ request()->routeIs('admin.coupons*') ? 'white' : 'rgba(255, 255, 255, 0.8)' }};
                  background: {{ request()->routeIs('admin.coupons*') ? '#c02425' : 'transparent' }};
                  transition: all 0.3s ease;
                  border: 1px solid {{ request()->routeIs('admin.coupons*') ? '#c02425' : 'transparent' }};
                  padding: 0.7rem 0.75rem !important;">
            <div class="me-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                <i class="fas fa-tags"></i>
            </div>
            <div class="flex-grow-1">
                <h6 class="mb-0 fw-semibold" style="font-size: 0.9rem;">Coupons</h6>
                <small class="opacity-75" style="font-size: 0.75rem;">Discount codes</small>
            </div>
        </a>

        <!-- Gift Cards -->
        <a class="nav-link d-flex align-items-center mb-1 rounded-3 text-decoration-none {{ request()->routeIs('admin.gift-cards*') ? 'active' : '' }}" 
           href="{{ route('admin.gift-cards') }}"
           style="color: {{ request()->routeIs('admin.gift-cards*') ? 'white' : 'rgba(255, 255, 255, 0.8)' }};
                  background: {{ request()->routeIs('admin.gift-cards*') ? '#c02425' : 'transparent' }};
                  transition: all 0.3s ease;
                  border: 1px solid {{ request()->routeIs('admin.gift-cards*') ? '#c02425' : 'transparent' }};
                  padding: 0.7rem 0.75rem !important;">
            <div class="me-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                <i class="fas fa-gift"></i>
            </div>
            <div class="flex-grow-1">
                <h6 class="mb-0 fw-semibold" style="font-size: 0.9rem;">Gift Cards</h6>
                <small class="opacity-75" style="font-size: 0.75rem;">Gift management</small>
            </div>
        </a>
    </div>

    <!-- Development Tools Section -->
    <div class="nav-section">
        <small class="nav-section-title fw-bold text-uppercase px-3 mb-2 d-block" style="color: rgba(255, 255, 255, 0.7); font-size: 0.7rem; letter-spacing: 1px;">Developer Tools</small>
        
        <!-- Telescope -->
        <a class="nav-link d-flex align-items-center mb-1 rounded-3 text-decoration-none" 
           href="/telescope" target="_blank"
           style="color: rgba(255, 255, 255, 0.8);
                  background: transparent;
                  transition: all 0.3s ease;
                  border: 1px solid transparent;
                  padding: 0.7rem 0.75rem !important;"
           onmouseover="this.style.background='rgba(192, 36, 37, 0.1)'; this.style.borderColor='rgba(192, 36, 37, 0.3)';"
           onmouseout="this.style.background='transparent'; this.style.borderColor='transparent';">
            <div class="me-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                <i class="fas fa-binoculars"></i>
            </div>
            <div class="flex-grow-1">
                <h6 class="mb-0 fw-semibold" style="font-size: 0.9rem;">Telescope</h6>
                <small class="opacity-75" style="font-size: 0.75rem;">Debug & monitor</small>
            </div>
        </a>

        <!-- Log Viewer -->
        <a class="nav-link d-flex align-items-center mb-1 rounded-3 text-decoration-none" 
           href="/log-viewer" target="_blank"
           style="color: rgba(255, 255, 255, 0.8);
                  background: transparent;
                  transition: all 0.3s ease;
                  border: 1px solid transparent;
                  padding: 0.7rem 0.75rem !important;"
           onmouseover="this.style.background='rgba(192, 36, 37, 0.1)'; this.style.borderColor='rgba(192, 36, 37, 0.3)';"
           onmouseout="this.style.background='transparent'; this.style.borderColor='transparent';">
            <div class="me-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                <i class="fas fa-file-alt"></i>
            </div>
            <div class="flex-grow-1">
                <h6 class="mb-0 fw-semibold" style="font-size: 0.9rem;">Logs</h6>
                <small class="opacity-75" style="font-size: 0.75rem;">System logs</small>
            </div>
        </a>
    </div>

    {{-- Future admin sections to be implemented:
    
    <!-- Operations Section -->
    <div class="nav-section mb-4">
        <small class="nav-section-title fw-bold text-uppercase px-3 mb-2 d-block" style="color: rgba(255, 255, 255, 0.7); font-size: 0.7rem; letter-spacing: 1px;">Operations</small>
        
        <!-- Bookings (admin.bookings) -->
        <!-- Equipment (admin.equipment) -->
        <!-- Reports (admin.reports) -->
        <!-- Payments (admin.payments) -->
    </div>
    
    <!-- System Section -->
    <div class="nav-section mb-4">
        <small class="nav-section-title fw-bold text-uppercase px-3 mb-2 d-block" style="color: rgba(255, 255, 255, 0.7); font-size: 0.7rem; letter-spacing: 1px;">System</small>
        
        <!-- Notifications (admin.notifications) -->
        <!-- Settings (admin.settings) -->
    </div>
    --}}
</nav>