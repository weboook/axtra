<!-- Customer Navigation Menu -->
<nav class="px-3">
    <!-- Main Section -->
    <div class="nav-section mb-4">
        <small class="nav-section-title fw-bold text-uppercase px-3 mb-2 d-block" style="color: rgba(255, 255, 255, 0.7); font-size: 0.7rem; letter-spacing: 1px;">Main Menu</small>
        
        <!-- Dashboard -->
        <a class="nav-link d-flex align-items-center mb-1 rounded-3 text-decoration-none {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
           href="{{ route('dashboard') }}"
           style="color: {{ request()->routeIs('dashboard') ? 'white' : 'rgba(255, 255, 255, 0.8)' }};
                  background: {{ request()->routeIs('dashboard') ? '#c02425' : 'transparent' }};
                  transition: all 0.3s ease;
                  border: 1px solid {{ request()->routeIs('dashboard') ? '#c02425' : 'transparent' }};
                  padding: 0.7rem 0.75rem !important;">
            <div class="me-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                <i class="fas fa-tachometer-alt"></i>
            </div>
            <div class="flex-grow-1">
                <h6 class="mb-0 fw-semibold" style="font-size: 0.9rem;">Dashboard</h6>
                <small class="opacity-75" style="font-size: 0.75rem;">Overview & Stats</small>
            </div>
        </a>

        <!-- Book Session -->
        <a class="nav-link d-flex align-items-center mb-1 rounded-3 text-decoration-none {{ request()->routeIs('user.book') ? 'active' : '' }}" 
           href="{{ route('user.book') }}"
           style="color: {{ request()->routeIs('user.book') ? 'white' : 'rgba(255, 255, 255, 0.8)' }};
                  background: {{ request()->routeIs('user.book') ? '#c02425' : 'transparent' }};
                  transition: all 0.3s ease;
                  border: 1px solid {{ request()->routeIs('user.book') ? '#c02425' : 'transparent' }};
                  padding: 0.7rem 0.75rem !important;">
            <div class="me-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                <i class="fas fa-plus-circle"></i>
            </div>
            <div class="flex-grow-1">
                <h6 class="mb-0 fw-semibold" style="font-size: 0.9rem;">Book Session</h6>
                <small class="opacity-75" style="font-size: 0.75rem;">Reserve your lane</small>
            </div>
        </a>

        <!-- My Bookings -->
        <a class="nav-link d-flex align-items-center mb-1 rounded-3 text-decoration-none {{ request()->routeIs('user.bookings*') ? 'active' : '' }}" 
           href="{{ route('user.bookings') }}"
           style="color: {{ request()->routeIs('user.bookings*') ? 'white' : 'rgba(255, 255, 255, 0.8)' }};
                  background: {{ request()->routeIs('user.bookings*') ? '#c02425' : 'transparent' }};
                  transition: all 0.3s ease;
                  border: 1px solid {{ request()->routeIs('user.bookings*') ? '#c02425' : 'transparent' }};
                  padding: 0.7rem 0.75rem !important;">
            <div class="me-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="flex-grow-1">
                <h6 class="mb-0 fw-semibold" style="font-size: 0.9rem;">My Bookings</h6>
                <small class="opacity-75" style="font-size: 0.75rem;">View reservations</small>
            </div>
        </a>
    </div>

    <!-- Performance Section -->
    <div class="nav-section mb-4">
        <small class="nav-section-title fw-bold text-uppercase px-3 mb-2 d-block" style="color: rgba(255, 255, 255, 0.7); font-size: 0.7rem; letter-spacing: 1px;">Performance</small>
        

        <!-- Leaderboard -->
        <a class="nav-link d-flex align-items-center mb-1 rounded-3 text-decoration-none {{ request()->routeIs('leaderboard.public*') ? 'active' : '' }}" 
           href="{{ route('leaderboard.public') }}"
           style="color: {{ request()->routeIs('leaderboard.public*') ? 'white' : 'rgba(255, 255, 255, 0.8)' }};
                  background: {{ request()->routeIs('leaderboard.public*') ? '#c02425' : 'transparent' }};
                  transition: all 0.3s ease;
                  border: 1px solid {{ request()->routeIs('leaderboard.public*') ? '#c02425' : 'transparent' }};
                  padding: 0.7rem 0.75rem !important;">
            <div class="me-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                <i class="fas fa-trophy"></i>
            </div>
            <div class="flex-grow-1">
                <h6 class="mb-0 fw-semibold" style="font-size: 0.9rem;">Leaderboard</h6>
                <small class="opacity-75" style="font-size: 0.75rem;">Community rankings</small>
            </div>
        </a>

        <!-- Achievements -->
        <a class="nav-link d-flex align-items-center mb-1 rounded-3 text-decoration-none {{ request()->routeIs('user.achievements*') ? 'active' : '' }}" 
           href="{{ route('user.achievements') }}"
           style="color: {{ request()->routeIs('user.achievements*') ? 'white' : 'rgba(255, 255, 255, 0.8)' }};
                  background: {{ request()->routeIs('user.achievements*') ? '#c02425' : 'transparent' }};
                  transition: all 0.3s ease;
                  border: 1px solid {{ request()->routeIs('user.achievements*') ? '#c02425' : 'transparent' }};
                  padding: 0.7rem 0.75rem !important;">
            <div class="me-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                <i class="fas fa-medal"></i>
            </div>
            <div class="flex-grow-1">
                <h6 class="mb-0 fw-semibold" style="font-size: 0.9rem;">Achievements</h6>
                <small class="opacity-75" style="font-size: 0.75rem;">Unlock rewards</small>
            </div>
        </a>
    </div>

    <!-- More Section -->
    <div class="nav-section">
        <small class="nav-section-title fw-bold text-uppercase px-3 mb-2 d-block" style="color: rgba(255, 255, 255, 0.7); font-size: 0.7rem; letter-spacing: 1px;">More</small>
        
        <!-- Gift Cards -->
        <a class="nav-link d-flex align-items-center mb-1 rounded-3 text-decoration-none {{ request()->routeIs('user.gift-cards*') ? 'active' : '' }}" 
           href="{{ route('user.gift-cards') }}"
           style="color: {{ request()->routeIs('user.gift-cards*') ? 'white' : 'rgba(255, 255, 255, 0.8)' }};
                  background: {{ request()->routeIs('user.gift-cards*') ? '#c02425' : 'transparent' }};
                  transition: all 0.3s ease;
                  border: 1px solid {{ request()->routeIs('user.gift-cards*') ? '#c02425' : 'transparent' }};
                  padding: 0.7rem 0.75rem !important;">
            <div class="me-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                <i class="fas fa-gift"></i>
            </div>
            <div class="flex-grow-1">
                <h6 class="mb-0 fw-semibold" style="font-size: 0.9rem;">Gift Cards</h6>
                <small class="opacity-75" style="font-size: 0.75rem;">Purchase & redeem</small>
            </div>
        </a>
    </div>
</nav>