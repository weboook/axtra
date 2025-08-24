<div class="container-fluid p-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1" style="color: #1a1a1a; font-weight: 700;">Admin Dashboard</h1>
            <p class="text-muted mb-0">Welcome back! Here's what's happening with your business today.</p>
        </div>
        <div class="d-flex gap-2 align-items-center">
            <span class="badge bg-success px-3 py-2" style="border-radius: 20px;">
                <i class="fas fa-circle me-2" style="font-size: 0.6rem;"></i>All Systems Operational
            </span>
            <button class="btn btn-outline-primary" style="border-radius: 10px; font-weight: 500;">
                <i class="fas fa-download me-2"></i>Export Report
            </button>
        </div>
    </div>

    <!-- Key Performance Stats -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1 fw-bold">${{ number_format($monthRevenue, 0) }}</h3>
                            <small class="opacity-75">Monthly Revenue</small>
                            <div class="d-flex align-items-center mt-1">
                                <i class="fas fa-{{ $revenueGrowth >= 0 ? 'arrow-up' : 'arrow-down' }} me-1" style="font-size: 0.7rem;"></i>
                                <small class="opacity-75">{{ abs($revenueGrowth) }}% vs last month</small>
                            </div>
                        </div>
                        <i class="fas fa-dollar-sign fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                <div class="card-body text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1 fw-bold">{{ number_format($monthBookings) }}</h3>
                            <small class="opacity-75">Monthly Bookings</small>
                            <div class="d-flex align-items-center mt-1">
                                <i class="fas fa-{{ $bookingGrowth >= 0 ? 'arrow-up' : 'arrow-down' }} me-1" style="font-size: 0.7rem;"></i>
                                <small class="opacity-75">{{ abs($bookingGrowth) }}% vs last month</small>
                            </div>
                        </div>
                        <i class="fas fa-calendar-check fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%);">
                <div class="card-body text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1 fw-bold">{{ number_format($totalUsers) }}</h3>
                            <small class="opacity-75">Total Users</small>
                            <div class="d-flex align-items-center mt-1">
                                <i class="fas fa-plus me-1" style="font-size: 0.7rem;"></i>
                                <small class="opacity-75">{{ $newUsersMonth }} new this month</small>
                            </div>
                        </div>
                        <i class="fas fa-users fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);">
                <div class="card-body text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1 fw-bold">{{ $activeLanes }}</h3>
                            <small class="opacity-75">Active Lanes</small>
                            <div class="d-flex align-items-center mt-1">
                                <i class="fas fa-play me-1" style="font-size: 0.7rem;"></i>
                                <small class="opacity-75">{{ $todayBookings }} bookings today</small>
                            </div>
                        </div>
                        <i class="fas fa-bowling-ball fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Performance & System Status -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="card" style="border: none; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                <div class="card-header" style="background: white; border-bottom: 1px solid #f1f5f9; border-radius: 16px 16px 0 0; padding: 24px;">
                    <h5 class="mb-1" style="color: #1a1a1a; font-weight: 700;">
                        <i class="fas fa-chart-line me-2" style="color: #c02425;"></i>Today's Performance
                    </h5>
                    <p class="text-muted mb-0" style="font-size: 0.9rem;">Real-time business metrics for {{ \Carbon\Carbon::today()->format('F j, Y') }}</p>
                </div>
                <div class="card-body" style="padding: 24px;">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="text-center p-3" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); border-radius: 12px;">
                                <div class="h4 mb-1 text-white fw-bold">${{ number_format($todayRevenue, 0) }}</div>
                                <small class="text-white opacity-75">Revenue</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 12px;">
                                <div class="h4 mb-1 text-white fw-bold">{{ $todayBookings }}</div>
                                <small class="text-white opacity-75">Bookings</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3" style="background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); border-radius: 12px;">
                                <div class="h4 mb-1 text-white fw-bold">{{ $newUsersToday }}</div>
                                <small class="text-white opacity-75">New Users</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 12px;">
                                <div class="h4 mb-1 text-white fw-bold">{{ $achievementsEarnedToday }}</div>
                                <small class="text-white opacity-75">Achievements</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card" style="border: none; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                <div class="card-header" style="background: white; border-bottom: 1px solid #f1f5f9; border-radius: 16px 16px 0 0; padding: 24px;">
                    <h5 class="mb-1" style="color: #1a1a1a; font-weight: 700;">
                        <i class="fas fa-gift me-2" style="color: #c02425;"></i>Gift Cards
                    </h5>
                    <p class="text-muted mb-0" style="font-size: 0.9rem;">Sales and usage overview</p>
                </div>
                <div class="card-body" style="padding: 24px;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Total Cards</span>
                        <span class="fw-bold" style="color: #1f2937;">{{ number_format($totalGiftCards) }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Total Value</span>
                        <span class="fw-bold" style="color: #1f2937;">${{ number_format($giftCardRevenue, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Sold Today</span>
                        <span class="fw-bold text-success">${{ number_format($giftCardsSoldToday, 0) }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Used Today</span>
                        <span class="fw-bold text-info">${{ number_format($giftCardsUsedToday, 0) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Weekly Calendar & Lane Stats -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="card" style="border: none; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                <div class="card-header" style="background: white; border-bottom: 1px solid #f1f5f9; border-radius: 16px 16px 0 0; padding: 24px;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1" style="color: #1a1a1a; font-weight: 700;">
                                <i class="fas fa-calendar-week me-2" style="color: #c02425;"></i>Weekly Booking Calendar
                            </h5>
                            <p class="text-muted mb-0" style="font-size: 0.9rem;">Next 7 days overview</p>
                        </div>
                        <div class="d-flex gap-2">
                            <span class="badge" style="background: #10b981; color: white; padding: 4px 8px; border-radius: 12px; font-size: 0.75rem;">{{ $upcomingBookings->where('status', 'confirmed')->count() }} Confirmed</span>
                            <span class="badge" style="background: #f59e0b; color: white; padding: 4px 8px; border-radius: 12px; font-size: 0.75rem;">{{ $upcomingBookings->where('status', 'pending')->count() }} Pending</span>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="padding: 24px;">
                    @if($upcomingBookings->count() > 0)
                    <div class="weekly-calendar">
                        @php
                            $startOfWeek = \Carbon\Carbon::today();
                            $weekDays = collect(range(0, 6))->map(function($day) use ($startOfWeek) {
                                return $startOfWeek->copy()->addDays($day);
                            });
                            $groupedBookings = $upcomingBookings->groupBy(function($booking) {
                                return $booking->booking_date->format('Y-m-d');
                            });
                        @endphp
                        
                        <div class="row g-2">
                            @foreach($weekDays as $date)
                            @php
                                $dateString = $date->format('Y-m-d');
                                $dayBookings = $groupedBookings->get($dateString, collect());
                            @endphp
                            <div class="col">
                                <div class="card border h-100 calendar-day" style="border-radius: 12px; transition: all 0.2s ease; {{ $date->isToday() ? 'border-color: #c02425; background: #c0242515;' : '' }}">
                                    <div class="card-header text-center py-2" style="background: {{ $date->isToday() ? '#c02425' : '#f8f9fa' }}; border-radius: 12px 12px 0 0; border-bottom: 1px solid #f1f5f9;">
                                        <div class="fw-bold" style="font-size: 0.85rem; color: {{ $date->isToday() ? 'white' : '#6b7280' }};">{{ $date->format('D') }}</div>
                                        <div class="fw-bold" style="font-size: 1.1rem; color: {{ $date->isToday() ? 'white' : '#1f2937' }};">{{ $date->format('j') }}</div>
                                        <small style="color: {{ $date->isToday() ? 'rgba(255,255,255,0.8)' : '#9ca3af' }};">{{ $date->format('M') }}</small>
                                    </div>
                                    <div class="card-body p-2" style="min-height: 120px;">
                                        @if($dayBookings->count() > 0)
                                            @foreach($dayBookings->take(3) as $booking)
                                            <div class="mb-2 p-2 rounded" style="background: {{ $booking->status === 'confirmed' ? '#dcfce7' : '#fef3c7' }}; font-size: 0.75rem; border: 1px solid {{ $booking->status === 'confirmed' ? '#bbf7d0' : '#fde68a' }};">
                                                <div class="fw-semibold text-truncate" style="color: {{ $booking->status === 'confirmed' ? '#166534' : '#92400e' }};">{{ $booking->user->name }}</div>
                                                <div class="text-muted" style="font-size: 0.7rem;">{{ $booking->lane->name ?? 'Lane' }}</div>
                                                <div class="fw-semibold" style="color: {{ $booking->status === 'confirmed' ? '#059669' : '#d97706' }};">{{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }}</div>
                                            </div>
                                            @endforeach
                                            @if($dayBookings->count() > 3)
                                            <small class="text-muted">+{{ $dayBookings->count() - 3 }} more</small>
                                            @endif
                                        @else
                                            <div class="text-center py-3">
                                                <i class="fas fa-calendar-day text-muted" style="font-size: 1.5rem; opacity: 0.3;"></i>
                                                <div class="text-muted" style="font-size: 0.7rem; margin-top: 8px;">No bookings</div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="fas fa-calendar-times fa-3x text-muted mb-3" style="opacity: 0.3;"></i>
                        <h6 class="text-muted">No Upcoming Bookings</h6>
                        <p class="text-muted">Future bookings will appear here</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card" style="border: none; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                <div class="card-header" style="background: white; border-bottom: 1px solid #f1f5f9; border-radius: 16px 16px 0 0; padding: 24px;">
                    <h5 class="mb-1" style="color: #1a1a1a; font-weight: 700;">
                        <i class="fas fa-bowling-ball me-2" style="color: #c02425;"></i>Lane Performance
                    </h5>
                    <p class="text-muted mb-0" style="font-size: 0.9rem;">Monthly utilization rates</p>
                </div>
                <div class="card-body" style="padding: 24px;">
                    @if($laneStats->count() > 0)
                    <div class="lane-performance">
                        @foreach($laneStats->sortBy('name') as $lane)
                        @php
                            $utilizationPercent = $monthBookings > 0 ? min(100, ($lane->bookings_count / ($monthBookings / $laneStats->count())) * 100) : 0;
                            $statusColor = match($lane->maintenance_status) {
                                'operational' => '#10b981',
                                'maintenance' => '#f59e0b', 
                                'out_of_order' => '#ef4444',
                                default => '#6b7280'
                            };
                        @endphp
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="d-flex align-items-center">
                                    <span class="badge me-2" style="background: {{ $statusColor }}; color: white; padding: 4px 8px; border-radius: 8px; font-size: 0.75rem;">{{ $lane->name }}</span>
                                    <small class="text-muted">{{ $lane->bookings_count }} bookings</small>
                                </div>
                                <small class="fw-bold" style="color: {{ $statusColor }};">{{ round($utilizationPercent) }}%</small>
                            </div>
                            <div class="progress" style="height: 6px; background: #f3f4f6; border-radius: 10px;">
                                <div class="progress-bar" style="background: {{ $statusColor }}; width: {{ $utilizationPercent }}%; border-radius: 10px;"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-4">
                        <i class="fas fa-bowling-ball fa-2x text-muted mb-2" style="opacity: 0.3;"></i>
                        <p class="text-muted mb-0">No lanes configured</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Achievement Stats & Popular Services -->
    <div class="row mb-4">
        <div class="col-lg-6">
            <div class="card" style="border: none; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                <div class="card-header" style="background: white; border-bottom: 1px solid #f1f5f9; border-radius: 16px 16px 0 0; padding: 24px;">
                    <h5 class="mb-1" style="color: #1a1a1a; font-weight: 700;">
                        <i class="fas fa-trophy me-2" style="color: #c02425;"></i>Achievement Activity
                    </h5>
                    <p class="text-muted mb-0" style="font-size: 0.9rem;">User engagement and rewards</p>
                </div>
                <div class="card-body" style="padding: 24px;">
                    <div class="row g-3 mb-4">
                        <div class="col-6 text-center">
                            <div class="h4 mb-1" style="color: #f59e0b; font-weight: 700;">{{ $totalAchievements }}</div>
                            <small class="text-muted">Total Achievements</small>
                        </div>
                        <div class="col-6 text-center">
                            <div class="h4 mb-1" style="color: #06b6d4; font-weight: 700;">{{ $achievementsEarnedWeek }}</div>
                            <small class="text-muted">Earned This Week</small>
                        </div>
                    </div>
                    
                    @if($topAchievement)
                    <div class="border rounded p-3" style="background: #f8f9fa; border-color: #e5e7eb !important; border-radius: 12px !important;">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="d-flex align-items-center justify-content-center" 
                                     style="width: 40px; height: 40px; background: {{ $topAchievement->color }}15; border: 2px solid {{ $topAchievement->color }}; border-radius: 12px;">
                                    <i class="{{ $topAchievement->icon }}" style="color: {{ $topAchievement->color }};"></i>
                                </div>
                            </div>
                            <div>
                                <div class="fw-semibold" style="color: #1f2937;">Most Popular Achievement</div>
                                <div style="color: #c02425; font-weight: 600;">{{ $topAchievement->name }}</div>
                                <small class="text-muted">Earned {{ $topAchievement->user_achievements_count }} times</small>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($recentAchievements->count() > 0)
                    <div class="mt-3">
                        <small class="text-muted fw-semibold">Recent Activity</small>
                        <div class="mt-2">
                            @foreach($recentAchievements as $userAchievement)
                            <div class="d-flex align-items-center mb-2 p-2" style="background: #f8f9fa; border-radius: 8px;">
                                <div class="me-2">
                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 24px; height: 24px;">
                                        <span class="text-white" style="font-size: 0.7rem;">{{ substr($userAchievement->user->name, 0, 1) }}</span>
                                    </div>
                                </div>
                                <div class="flex-grow-1 min-w-0">
                                    <div class="text-truncate" style="font-size: 0.85rem;">
                                        <span class="fw-semibold">{{ $userAchievement->user->name }}</span>
                                        earned <span style="color: #c02425; font-weight: 600;">{{ $userAchievement->achievement->name }}</span>
                                    </div>
                                    <small class="text-muted">{{ $userAchievement->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card" style="border: none; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                <div class="card-header" style="background: white; border-bottom: 1px solid #f1f5f9; border-radius: 16px 16px 0 0; padding: 24px;">
                    <h5 class="mb-1" style="color: #1a1a1a; font-weight: 700;">
                        <i class="fas fa-chart-bar me-2" style="color: #c02425;"></i>Popular Services
                    </h5>
                    <p class="text-muted mb-0" style="font-size: 0.9rem;">Most booked services this month</p>
                </div>
                <div class="card-body" style="padding: 24px;">
                    @if($popularBookings->count() > 0)
                    @foreach($popularBookings as $booking)
                    @php
                        $percentage = $totalBookings > 0 ? ($booking->booking_count / $totalBookings) * 100 : 0;
                        $colors = ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'];
                        $color = $colors[$loop->index % count($colors)];
                    @endphp
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-semibold" style="color: #1f2937;">{{ $booking->service->name ?? 'Service' }}</span>
                            <span class="text-muted">{{ $booking->booking_count }} bookings</span>
                        </div>
                        <div class="progress" style="height: 8px; background: #f3f4f6; border-radius: 10px;">
                            <div class="progress-bar" style="width: {{ $percentage }}%; background: {{ $color }}; border-radius: 10px;"></div>
                        </div>
                        <small class="text-muted">{{ round($percentage, 1) }}% of all bookings</small>
                    </div>
                    @endforeach
                    @else
                    <div class="text-center py-4">
                        <i class="fas fa-chart-bar fa-2x text-muted mb-2" style="opacity: 0.3;"></i>
                        <p class="text-muted mb-0">No booking data available</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card" style="border: none; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                <div class="card-header" style="background: white; border-bottom: 1px solid #f1f5f9; border-radius: 16px 16px 0 0; padding: 24px;">
                    <h5 class="mb-1" style="color: #1a1a1a; font-weight: 700;">
                        <i class="fas fa-bolt me-2" style="color: #c02425;"></i>Quick Actions
                    </h5>
                    <p class="text-muted mb-0" style="font-size: 0.9rem;">Navigate to key management areas</p>
                </div>
                <div class="card-body" style="padding: 24px;">
                    <div class="row g-3">
                        <div class="col-md-2">
                            <a href="{{ route('admin.users') }}" class="btn w-100 p-3 text-center quick-action-btn" style="border: 2px solid #e5e7eb; border-radius: 12px; background: white; transition: all 0.2s ease;">
                                <i class="fas fa-users d-block mb-2" style="font-size: 1.5rem; color: #3b82f6;"></i>
                                <div class="fw-semibold" style="color: #1f2937;">Users</div>
                                <small class="text-muted">{{ number_format($totalUsers) }}</small>
                            </a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('admin.lanes') }}" class="btn w-100 p-3 text-center quick-action-btn" style="border: 2px solid #e5e7eb; border-radius: 12px; background: white; transition: all 0.2s ease;">
                                <i class="fas fa-bowling-ball d-block mb-2" style="font-size: 1.5rem; color: #10b981;"></i>
                                <div class="fw-semibold" style="color: #1f2937;">Lanes</div>
                                <small class="text-muted">{{ $activeLanes }} active</small>
                            </a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('admin.gift-cards') }}" class="btn w-100 p-3 text-center quick-action-btn" style="border: 2px solid #e5e7eb; border-radius: 12px; background: white; transition: all 0.2s ease;">
                                <i class="fas fa-gift d-block mb-2" style="font-size: 1.5rem; color: #06b6d4;"></i>
                                <div class="fw-semibold" style="color: #1f2937;">Gift Cards</div>
                                <small class="text-muted">${{ number_format($giftCardRevenue, 0) }}</small>
                            </a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('admin.coupons') }}" class="btn w-100 p-3 text-center quick-action-btn" style="border: 2px solid #e5e7eb; border-radius: 12px; background: white; transition: all 0.2s ease;">
                                <i class="fas fa-tags d-block mb-2" style="font-size: 1.5rem; color: #f59e0b;"></i>
                                <div class="fw-semibold" style="color: #1f2937;">Coupons</div>
                                <small class="text-muted">{{ $totalCoupons }} active</small>
                            </a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('admin.levels') }}" class="btn w-100 p-3 text-center quick-action-btn" style="border: 2px solid #e5e7eb; border-radius: 12px; background: white; transition: all 0.2s ease;">
                                <i class="fas fa-medal d-block mb-2" style="font-size: 1.5rem; color: #8b5cf6;"></i>
                                <div class="fw-semibold" style="color: #1f2937;">Levels</div>
                                <small class="text-muted">{{ $totalLevels }} levels</small>
                            </a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('admin.achievements') }}" class="btn w-100 p-3 text-center quick-action-btn" style="border: 2px solid #e5e7eb; border-radius: 12px; background: white; transition: all 0.2s ease;">
                                <i class="fas fa-trophy d-block mb-2" style="font-size: 1.5rem; color: #ef4444;"></i>
                                <div class="fw-semibold" style="color: #1f2937;">Achievements</div>
                                <small class="text-muted">{{ $totalAchievements }} total</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card" style="border: none; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                <div class="card-header" style="background: white; border-bottom: 1px solid #f1f5f9; border-radius: 16px 16px 0 0; padding: 24px;">
                    <h5 class="mb-1" style="color: #1a1a1a; font-weight: 700;">
                        <i class="fas fa-clock me-2" style="color: #c02425;"></i>Recent Bookings
                    </h5>
                    <p class="text-muted mb-0" style="font-size: 0.9rem;">Latest customer activity</p>
                </div>
                <div class="card-body" style="padding: 24px;">
                    @if($recentBookings->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($recentBookings as $booking)
                        <div class="list-group-item border-0 px-0 py-3" style="border-bottom: 1px solid #f1f5f9 !important;">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                         style="width: 44px; height: 44px; background: linear-gradient(135deg, #3b82f6, #1d4ed8);">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1 fw-semibold" style="color: #1f2937;">{{ $booking->user->name }}</h6>
                                            <p class="mb-1 text-muted" style="font-size: 0.9rem;">
                                                {{ $booking->service->name ?? 'Service' }} • {{ $booking->lane->name ?? 'Lane' }}
                                                @if($booking->booking_date)
                                                • {{ $booking->booking_date->format('M j, Y') }}
                                                @endif
                                            </p>
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="badge" style="background: {{ $booking->status === 'confirmed' ? '#10b981' : ($booking->status === 'pending' ? '#f59e0b' : '#6b7280') }}; color: white; padding: 4px 8px; border-radius: 12px; font-size: 0.75rem;">
                                                    {{ ucfirst($booking->status) }}
                                                </span>
                                                @if($booking->total_price)
                                                <span class="fw-bold" style="color: #10b981;">${{ number_format($booking->total_price, 2) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <small class="text-muted">{{ $booking->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="fas fa-calendar-alt fa-3x text-muted mb-3" style="opacity: 0.3;"></i>
                        <h6 class="text-muted">No Recent Bookings</h6>
                        <p class="text-muted">New bookings will appear here</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card" style="border: none; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                <div class="card-header" style="background: white; border-bottom: 1px solid #f1f5f9; border-radius: 16px 16px 0 0; padding: 24px;">
                    <h5 class="mb-1" style="color: #1a1a1a; font-weight: 700;">
                        <i class="fas fa-user-plus me-2" style="color: #c02425;"></i>New Users
                    </h5>
                    <p class="text-muted mb-0" style="font-size: 0.9rem;">Recent registrations</p>
                </div>
                <div class="card-body" style="padding: 24px;">
                    @if($recentUsers->count() > 0)
                    <div class="d-flex flex-column gap-3">
                        @foreach($recentUsers as $user)
                        <div class="d-flex align-items-center p-2" style="background: #f8f9fa; border-radius: 12px;">
                            <div class="me-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: linear-gradient(135deg, #10b981, #059669);">
                                    <span class="text-white fw-bold" style="font-size: 0.9rem;">{{ substr($user->name, 0, 2) }}</span>
                                </div>
                            </div>
                            <div class="flex-grow-1 min-w-0">
                                <div class="fw-semibold text-truncate" style="color: #1f2937;">{{ $user->name }}</div>
                                <small class="text-muted">{{ $user->email }}</small>
                                <div>
                                    <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-4">
                        <i class="fas fa-user-plus fa-2x text-muted mb-2" style="opacity: 0.3;"></i>
                        <p class="text-muted mb-0">No new users today</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.calendar-day:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px -5px rgba(0, 0, 0, 0.1);
}

.quick-action-btn:hover {
    border-color: #c02425 !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(192, 36, 37, 0.15);
}

.weekly-calendar .card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
</style>
@endpush