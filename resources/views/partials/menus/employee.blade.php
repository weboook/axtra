<!-- Employee Navigation Menu -->
<nav class="px-3">
    <!-- Dashboard Section -->
    <div class="nav-section mb-4">
        <small class="nav-section-title fw-bold text-uppercase px-3 mb-2 d-block" style="color: rgba(255, 255, 255, 0.7); font-size: 0.7rem; letter-spacing: 1px;">Overview</small>
        
        <!-- Dashboard -->
        <a class="nav-link d-flex align-items-center mb-1 rounded-3 text-decoration-none {{ request()->routeIs('employee.dashboard') ? 'active' : '' }}" 
           href="{{ route('employee.dashboard') }}"
           style="color: {{ request()->routeIs('employee.dashboard') ? 'white' : 'rgba(255, 255, 255, 0.8)' }};
                  background: {{ request()->routeIs('employee.dashboard') ? '#17a2b8' : 'transparent' }};
                  transition: all 0.3s ease;
                  border: 1px solid {{ request()->routeIs('employee.dashboard') ? '#17a2b8' : 'transparent' }};
                  padding: 0.7rem 0.75rem !important;">
            <div class="me-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                <i class="fas fa-tachometer-alt"></i>
            </div>
            <div class="flex-grow-1">
                <h6 class="mb-0 fw-semibold" style="font-size: 0.9rem;">Dashboard</h6>
                <small class="opacity-75" style="font-size: 0.75rem;">Employee overview</small>
            </div>
        </a>

        <!-- My Schedule -->
        <a class="nav-link d-flex align-items-center mb-1 rounded-3 text-decoration-none {{ request()->routeIs('employee.schedule*') ? 'active' : '' }}" 
           href="{{ route('employee.schedule') }}"
           style="color: {{ request()->routeIs('employee.schedule*') ? 'white' : 'rgba(255, 255, 255, 0.8)' }};
                  background: {{ request()->routeIs('employee.schedule*') ? '#17a2b8' : 'transparent' }};
                  transition: all 0.3s ease;
                  border: 1px solid {{ request()->routeIs('employee.schedule*') ? '#17a2b8' : 'transparent' }};
                  padding: 0.7rem 0.75rem !important;">
            <div class="me-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="flex-grow-1">
                <h6 class="mb-0 fw-semibold" style="font-size: 0.9rem;">My Schedule</h6>
                <small class="opacity-75" style="font-size: 0.75rem;">Work schedule</small>
            </div>
        </a>
    </div>

    <!-- Operations Section -->
    <div class="nav-section mb-4">
        <small class="nav-section-title fw-bold text-uppercase px-3 mb-2 d-block" style="color: rgba(255, 255, 255, 0.7); font-size: 0.7rem; letter-spacing: 1px;">Operations</small>
        
        <!-- Quick Actions -->
        <a class="nav-link d-flex align-items-center mb-1 rounded-3 text-decoration-none {{ request()->routeIs('employee.quick-actions*') ? 'active' : '' }}" 
           href="{{ route('employee.quick-actions') }}"
           style="color: {{ request()->routeIs('employee.quick-actions*') ? 'white' : 'rgba(255, 255, 255, 0.8)' }};
                  background: {{ request()->routeIs('employee.quick-actions*') ? '#17a2b8' : 'transparent' }};
                  transition: all 0.3s ease;
                  border: 1px solid {{ request()->routeIs('employee.quick-actions*') ? '#17a2b8' : 'transparent' }};
                  padding: 0.7rem 0.75rem !important;">
            <div class="me-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                <i class="fas fa-bolt"></i>
            </div>
            <div class="flex-grow-1">
                <h6 class="mb-0 fw-semibold" style="font-size: 0.9rem;">Quick Actions</h6>
                <small class="opacity-75" style="font-size: 0.75rem;">Fast operations</small>
            </div>
        </a>

        <!-- Today's Bookings -->
        <a class="nav-link d-flex align-items-center mb-1 rounded-3 text-decoration-none {{ request()->routeIs('employee.bookings*') ? 'active' : '' }}" 
           href="{{ route('employee.bookings') }}"
           style="color: {{ request()->routeIs('employee.bookings*') ? 'white' : 'rgba(255, 255, 255, 0.8)' }};
                  background: {{ request()->routeIs('employee.bookings*') ? '#17a2b8' : 'transparent' }};
                  transition: all 0.3s ease;
                  border: 1px solid {{ request()->routeIs('employee.bookings*') ? '#17a2b8' : 'transparent' }};
                  padding: 0.7rem 0.75rem !important;">
            <div class="me-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                <i class="fas fa-calendar-day"></i>
            </div>
            <div class="flex-grow-1">
                <h6 class="mb-0 fw-semibold" style="font-size: 0.9rem;">Today's Bookings</h6>
                <small class="opacity-75" style="font-size: 0.75rem;">Current reservations</small>
            </div>
        </a>

        <!-- Check-ins -->
        <a class="nav-link d-flex align-items-center mb-1 rounded-3 text-decoration-none {{ request()->routeIs('employee.check-ins*') ? 'active' : '' }}" 
           href="{{ route('employee.check-ins') }}"
           style="color: {{ request()->routeIs('employee.check-ins*') ? 'white' : 'rgba(255, 255, 255, 0.8)' }};
                  background: {{ request()->routeIs('employee.check-ins*') ? '#17a2b8' : 'transparent' }};
                  transition: all 0.3s ease;
                  border: 1px solid {{ request()->routeIs('employee.check-ins*') ? '#17a2b8' : 'transparent' }};
                  padding: 0.7rem 0.75rem !important;">
            <div class="me-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="flex-grow-1">
                <h6 class="mb-0 fw-semibold" style="font-size: 0.9rem;">Check-ins</h6>
                <small class="opacity-75" style="font-size: 0.75rem;">Customer arrivals</small>
            </div>
        </a>
    </div>

    <!-- Facility Section -->
    <div class="nav-section mb-4">
        <small class="nav-section-title fw-bold text-uppercase px-3 mb-2 d-block" style="color: rgba(255, 255, 255, 0.7); font-size: 0.7rem; letter-spacing: 1px;">Facility</small>
        
        <!-- Equipment Status -->
        <a class="nav-link d-flex align-items-center mb-1 rounded-3 text-decoration-none {{ request()->routeIs('employee.equipment*') ? 'active' : '' }}" 
           href="{{ route('employee.equipment') }}"
           style="color: {{ request()->routeIs('employee.equipment*') ? 'white' : 'rgba(255, 255, 255, 0.8)' }};
                  background: {{ request()->routeIs('employee.equipment*') ? '#17a2b8' : 'transparent' }};
                  transition: all 0.3s ease;
                  border: 1px solid {{ request()->routeIs('employee.equipment*') ? '#17a2b8' : 'transparent' }};
                  padding: 0.7rem 0.75rem !important;">
            <div class="me-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                <i class="fas fa-tools"></i>
            </div>
            <div class="flex-grow-1">
                <h6 class="mb-0 fw-semibold" style="font-size: 0.9rem;">Equipment</h6>
                <small class="opacity-75" style="font-size: 0.75rem;">Status & maintenance</small>
            </div>
        </a>

    </div>

    <!-- Reports Section -->
    <div class="nav-section">
        <small class="nav-section-title fw-bold text-uppercase px-3 mb-2 d-block" style="color: rgba(255, 255, 255, 0.7); font-size: 0.7rem; letter-spacing: 1px;">Reports</small>
        
        <!-- Daily Reports -->
        <a class="nav-link d-flex align-items-center mb-1 rounded-3 text-decoration-none {{ request()->routeIs('employee.reports*') ? 'active' : '' }}" 
           href="{{ route('employee.reports') }}"
           style="color: {{ request()->routeIs('employee.reports*') ? 'white' : 'rgba(255, 255, 255, 0.8)' }};
                  background: {{ request()->routeIs('employee.reports*') ? '#17a2b8' : 'transparent' }};
                  transition: all 0.3s ease;
                  border: 1px solid {{ request()->routeIs('employee.reports*') ? '#17a2b8' : 'transparent' }};
                  padding: 0.7rem 0.75rem !important;">
            <div class="me-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="flex-grow-1">
                <h6 class="mb-0 fw-semibold" style="font-size: 0.9rem;">Daily Reports</h6>
                <small class="opacity-75" style="font-size: 0.75rem;">Performance data</small>
            </div>
        </a>
    </div>
</nav>