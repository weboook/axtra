<!-- Employee Navigation Menu -->
<ul class="navbar-nav">
    <!-- Dashboard -->
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('employee.dashboard') ? 'active' : '' }}" 
           href="{{ route('employee.dashboard') }}">
            <div class="nav-icon">
                <i class="material-icons opacity-10">dashboard</i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
        </a>
    </li>

    <!-- Schedule -->
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('employee.schedule*') ? 'active' : '' }}" 
           href="{{ route('employee.schedule') }}">
            <div class="nav-icon">
                <i class="material-icons opacity-10">schedule</i>
            </div>
            <span class="nav-link-text ms-1">My Schedule</span>
        </a>
    </li>

    <!-- Quick Actions -->
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('employee.quick-actions*') ? 'active' : '' }}" 
           href="{{ route('employee.quick-actions') }}">
            <div class="nav-icon">
                <i class="material-icons opacity-10">flash_on</i>
            </div>
            <span class="nav-link-text ms-1">Quick Actions</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="horizontal light mt-3 mb-2">

    <!-- Today's Bookings -->
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('employee.bookings*') ? 'active' : '' }}" 
           href="{{ route('admin.bookings') }}">
            <div class="nav-icon">
                <i class="material-icons opacity-10">today</i>
            </div>
            <span class="nav-link-text ms-1">Today's Bookings</span>
        </a>
    </li>

    <!-- Check-ins -->
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('employee.check-ins*') ? 'active' : '' }}" 
           href="#">
            <div class="nav-icon">
                <i class="material-icons opacity-10">check_circle</i>
            </div>
            <span class="nav-link-text ms-1">Check-ins</span>
        </a>
    </li>

    <!-- Equipment Status -->
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('employee.equipment*') ? 'active' : '' }}" 
           href="{{ route('admin.equipment') }}">
            <div class="nav-icon">
                <i class="material-icons opacity-10">build</i>
            </div>
            <span class="nav-link-text ms-1">Equipment</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="horizontal light mt-3 mb-2">

    <!-- Customer Support -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <div class="nav-icon">
                <i class="material-icons opacity-10">support_agent</i>
            </div>
            <span class="nav-link-text ms-1">Customer Support</span>
        </a>
    </li>

    <!-- Reports -->
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('employee.reports*') ? 'active' : '' }}" 
           href="#">
            <div class="nav-icon">
                <i class="material-icons opacity-10">assessment</i>
            </div>
            <span class="nav-link-text ms-1">Daily Reports</span>
        </a>
    </li>
</ul>