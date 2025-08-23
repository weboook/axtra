<!-- Admin Navigation Menu -->
<ul class="navbar-nav">
    <!-- Dashboard -->
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
           href="{{ route('admin.dashboard') }}">
            <div class="nav-icon">
                <i class="material-icons opacity-10">dashboard</i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
        </a>
    </li>

    <!-- Users Management -->
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}" 
           href="{{ route('admin.users') }}">
            <div class="nav-icon">
                <i class="material-icons opacity-10">people</i>
            </div>
            <span class="nav-link-text ms-1">Users</span>
        </a>
    </li>

    <!-- Products Management -->
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.products*') ? 'active' : '' }}" 
           href="{{ route('admin.products') }}">
            <div class="nav-icon">
                <i class="material-icons opacity-10">inventory_2</i>
            </div>
            <span class="nav-link-text ms-1">Products</span>
        </a>
    </li>

    <!-- Lanes Management -->
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.lanes*') ? 'active' : '' }}" 
           href="{{ route('admin.lanes') }}">
            <div class="nav-icon">
                <i class="material-icons opacity-10">sports</i>
            </div>
            <span class="nav-link-text ms-1">Lanes</span>
        </a>
    </li>

    <!-- Bookings Management -->
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.bookings*') ? 'active' : '' }}" 
           href="{{ route('admin.bookings') }}">
            <div class="nav-icon">
                <i class="material-icons opacity-10">event</i>
            </div>
            <span class="nav-link-text ms-1">Bookings</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="horizontal light mt-3 mb-2">

    <!-- Coupons & Promotions -->
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.coupons*') ? 'active' : '' }}" 
           href="{{ route('admin.coupons') }}">
            <div class="nav-icon">
                <i class="material-icons opacity-10">local_offer</i>
            </div>
            <span class="nav-link-text ms-1">Coupons</span>
        </a>
    </li>

    <!-- Gift Cards -->
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.gift-cards*') ? 'active' : '' }}" 
           href="{{ route('admin.gift-cards') }}">
            <div class="nav-icon">
                <i class="material-icons opacity-10">card_giftcard</i>
            </div>
            <span class="nav-link-text ms-1">Gift Cards</span>
        </a>
    </li>

    <!-- Levels Management -->
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.levels*') ? 'active' : '' }}" 
           href="{{ route('admin.levels') }}">
            <div class="nav-icon">
                <i class="material-icons opacity-10">military_tech</i>
            </div>
            <span class="nav-link-text ms-1">Levels</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="horizontal light mt-3 mb-2">

    <!-- Employees -->
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.employees*') ? 'active' : '' }}" 
           href="{{ route('admin.employees') }}">
            <div class="nav-icon">
                <i class="material-icons opacity-10">badge</i>
            </div>
            <span class="nav-link-text ms-1">Employees</span>
        </a>
    </li>

    <!-- Equipment Management -->
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.equipment*') ? 'active' : '' }}" 
           href="{{ route('admin.equipment') }}">
            <div class="nav-icon">
                <i class="material-icons opacity-10">build</i>
            </div>
            <span class="nav-link-text ms-1">Equipment</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="horizontal light mt-3 mb-2">

    <!-- Reports & Analytics -->
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.reports*') ? 'active' : '' }}" 
           href="{{ route('admin.reports') }}">
            <div class="nav-icon">
                <i class="material-icons opacity-10">analytics</i>
            </div>
            <span class="nav-link-text ms-1">Reports</span>
        </a>
    </li>

    <!-- Payments -->
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.payments*') ? 'active' : '' }}" 
           href="{{ route('admin.payments') }}">
            <div class="nav-icon">
                <i class="material-icons opacity-10">payments</i>
            </div>
            <span class="nav-link-text ms-1">Payments</span>
        </a>
    </li>

    <!-- Notifications -->
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.notifications*') ? 'active' : '' }}" 
           href="{{ route('admin.notifications') }}">
            <div class="nav-icon">
                <i class="material-icons opacity-10">notifications</i>
            </div>
            <span class="nav-link-text ms-1">Notifications</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="horizontal light mt-3 mb-2">

    <!-- Settings -->
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}" 
           href="{{ route('admin.settings') }}">
            <div class="nav-icon">
                <i class="material-icons opacity-10">settings</i>
            </div>
            <span class="nav-link-text ms-1">Settings</span>
        </a>
    </li>

    <!-- Telescope (Development) -->
    @if(app()->environment(['local', 'staging']))
    <li class="nav-item">
        <a class="nav-link" href="/telescope" target="_blank">
            <div class="nav-icon">
                <i class="material-icons opacity-10">search</i>
            </div>
            <span class="nav-link-text ms-1">Telescope</span>
        </a>
    </li>
    @endif

    <!-- Log Viewer -->
    <li class="nav-item">
        <a class="nav-link" href="/log-viewer" target="_blank">
            <div class="nav-icon">
                <i class="material-icons opacity-10">bug_report</i>
            </div>
            <span class="nav-link-text ms-1">Logs</span>
        </a>
    </li>
</ul>