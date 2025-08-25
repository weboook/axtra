<div class="container-fluid p-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1" style="color: #1a1a1a; font-weight: 700;">Employee Dashboard</h1>
            <p class="text-muted mb-0">Welcome back! Here's your shift overview for {{ \Carbon\Carbon::today()->format('F j, Y') }}.</p>
        </div>
        <div class="d-flex gap-2 align-items-center">
            <span class="badge bg-success px-3 py-2" style="border-radius: 20px;">
                <i class="fas fa-circle me-2" style="font-size: 0.6rem;"></i>On Duty
            </span>
            <span class="text-muted">{{ now()->format('g:i A') }}</span>
        </div>
    </div>

    <!-- Key Performance Stats -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%);">
                <div class="card-body text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1 fw-bold">{{ \App\Models\Booking::whereDate('booking_date', today())->count() }}</h3>
                            <small class="opacity-75">Today's Bookings</small>
                        </div>
                        <i class="fas fa-calendar-check fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                <div class="card-body text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1 fw-bold">{{ \App\Models\Lane::where('maintenance_status', 'operational')->count() }}</h3>
                            <small class="opacity-75">Available Lanes</small>
                        </div>
                        <i class="fas fa-bowling-ball fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);">
                <div class="card-body text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1 fw-bold">{{ \App\Models\Booking::where('status', 'pending')->count() }}</h3>
                            <small class="opacity-75">Pending Check-ins</small>
                        </div>
                        <i class="fas fa-clock fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #6f42c1 0%, #e83e8c 100%);">
                <div class="card-body text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1 fw-bold">{{ \App\Models\Lane::where('maintenance_status', '!=', 'operational')->count() }}</h3>
                            <small class="opacity-75">Maintenance Needed</small>
                        </div>
                        <i class="fas fa-wrench fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Current Status -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="card" style="border: none; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                <div class="card-header" style="background: white; border-bottom: 1px solid #f1f5f9; border-radius: 16px 16px 0 0; padding: 24px;">
                    <h5 class="mb-1" style="color: #1a1a1a; font-weight: 700;">
                        <i class="fas fa-bolt me-2" style="color: #17a2b8;"></i>Quick Actions
                    </h5>
                    <p class="text-muted mb-0" style="font-size: 0.9rem;">Common tasks and operations</p>
                </div>
                <div class="card-body" style="padding: 24px;">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <a href="{{ route('employee.quick-actions') }}" class="btn w-100 p-3 text-center quick-action-btn" style="border: 2px solid #e5e7eb; border-radius: 12px; background: white; transition: all 0.2s ease; text-decoration: none;">
                                <i class="fas fa-tools d-block mb-2" style="font-size: 1.5rem; color: #17a2b8;"></i>
                                <div class="fw-semibold" style="color: #1f2937;">Lane Maintenance</div>
                                <small class="text-muted">Report issues</small>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('employee.bookings') }}" class="btn w-100 p-3 text-center quick-action-btn" style="border: 2px solid #e5e7eb; border-radius: 12px; background: white; transition: all 0.2s ease; text-decoration: none;">
                                <i class="fas fa-calendar-day d-block mb-2" style="font-size: 1.5rem; color: #28a745;"></i>
                                <div class="fw-semibold" style="color: #1f2937;">Today's Bookings</div>
                                <small class="text-muted">View schedule</small>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('employee.check-ins') }}" class="btn w-100 p-3 text-center quick-action-btn" style="border: 2px solid #e5e7eb; border-radius: 12px; background: white; transition: all 0.2s ease; text-decoration: none;">
                                <i class="fas fa-check-circle d-block mb-2" style="font-size: 1.5rem; color: #ffc107;"></i>
                                <div class="fw-semibold" style="color: #1f2937;">Customer Check-ins</div>
                                <small class="text-muted">Process arrivals</small>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('employee.equipment') }}" class="btn w-100 p-3 text-center quick-action-btn" style="border: 2px solid #e5e7eb; border-radius: 12px; background: white; transition: all 0.2s ease; text-decoration: none;">
                                <i class="fas fa-clipboard-check d-block mb-2" style="font-size: 1.5rem; color: #6f42c1;"></i>
                                <div class="fw-semibold" style="color: #1f2937;">Equipment Status</div>
                                <small class="text-muted">Check inventory</small>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('employee.schedule') }}" class="btn w-100 p-3 text-center quick-action-btn" style="border: 2px solid #e5e7eb; border-radius: 12px; background: white; transition: all 0.2s ease; text-decoration: none;">
                                <i class="fas fa-calendar-alt d-block mb-2" style="font-size: 1.5rem; color: #e83e8c;"></i>
                                <div class="fw-semibold" style="color: #1f2937;">My Schedule</div>
                                <small class="text-muted">Work calendar</small>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('employee.reports') }}" class="btn w-100 p-3 text-center quick-action-btn" style="border: 2px solid #e5e7eb; border-radius: 12px; background: white; transition: all 0.2s ease; text-decoration: none;">
                                <i class="fas fa-chart-line d-block mb-2" style="font-size: 1.5rem; color: #dc3545;"></i>
                                <div class="fw-semibold" style="color: #1f2937;">Daily Reports</div>
                                <small class="text-muted">Shift summary</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card" style="border: none; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                <div class="card-header" style="background: white; border-bottom: 1px solid #f1f5f9; border-radius: 16px 16px 0 0; padding: 24px;">
                    <h5 class="mb-1" style="color: #1a1a1a; font-weight: 700;">
                        <i class="fas fa-clock me-2" style="color: #17a2b8;"></i>My Shift
                    </h5>
                    <p class="text-muted mb-0" style="font-size: 0.9rem;">Current work schedule</p>
                </div>
                <div class="card-body" style="padding: 24px;">
                    <div class="text-center">
                        <div class="mb-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto" 
                                 style="width: 60px; height: 60px; background: rgba(23, 162, 184, 0.1);">
                                <i class="fas fa-briefcase" style="color: #17a2b8; font-size: 1.5rem;"></i>
                            </div>
                        </div>
                        <h6 class="fw-semibold mb-2" style="color: #1f2937;">Regular Shift</h6>
                        <p class="text-muted mb-3">9:00 AM - 6:00 PM</p>
                        <div class="progress mb-3" style="height: 8px; background: #f3f4f6; border-radius: 10px;">
                            @php
                                $currentHour = now()->hour;
                                $shiftProgress = max(0, min(100, (($currentHour - 9) / 9) * 100));
                            @endphp
                            <div class="progress-bar" style="width: {{ $shiftProgress }}%; background: linear-gradient(90deg, #17a2b8, #20c997); border-radius: 10px;"></div>
                        </div>
                        <small class="text-muted">{{ round($shiftProgress) }}% of shift completed</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Current Activity & Urgent Tasks -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card" style="border: none; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                <div class="card-header" style="background: white; border-bottom: 1px solid #f1f5f9; border-radius: 16px 16px 0 0; padding: 24px;">
                    <h5 class="mb-1" style="color: #1a1a1a; font-weight: 700;">
                        <i class="fas fa-calendar-day me-2" style="color: #17a2b8;"></i>Today's Activity
                    </h5>
                    <p class="text-muted mb-0" style="font-size: 0.9rem;">Recent bookings and check-ins</p>
                </div>
                <div class="card-body" style="padding: 24px;">
                    @php
                        $todayBookings = \App\Models\Booking::with(['user', 'lane'])
                            ->whereDate('booking_date', today())
                            ->orderBy('start_time')
                            ->take(8)
                            ->get();
                    @endphp
                    
                    @if($todayBookings->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($todayBookings as $booking)
                        <div class="list-group-item border-0 px-0 py-3" style="border-bottom: 1px solid #f1f5f9 !important;">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                         style="width: 40px; height: 40px; background: {{ $booking->status === 'confirmed' ? 'linear-gradient(135deg, #28a745, #20c997)' : 'linear-gradient(135deg, #ffc107, #fd7e14)' }};">
                                        <i class="fas fa-user text-white" style="font-size: 0.9rem;"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1 fw-semibold" style="color: #1f2937;">{{ $booking->user->name }}</h6>
                                            <p class="mb-1 text-muted" style="font-size: 0.9rem;">
                                                {{ $booking->lane->name ?? 'Lane TBD' }}
                                                @if($booking->start_time)
                                                • {{ \Carbon\Carbon::parse($booking->start_time)->format('g:i A') }}
                                                @endif
                                            </p>
                                            <span class="badge" style="background: {{ $booking->status === 'confirmed' ? '#28a745' : ($booking->status === 'pending' ? '#ffc107' : '#6b7280') }}; color: white; padding: 4px 8px; border-radius: 12px; font-size: 0.75rem;">
                                                {{ ucfirst($booking->status) }}
                                            </span>
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
                        <h6 class="text-muted">No bookings today</h6>
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
                        <i class="fas fa-bowling-ball me-2" style="color: #17a2b8;"></i>Lane Status
                    </h5>
                    <p class="text-muted mb-0" style="font-size: 0.9rem;">Current lane availability</p>
                </div>
                <div class="card-body" style="padding: 24px;">
                    @php
                        $lanes = \App\Models\Lane::orderBy('name')->get();
                    @endphp
                    
                    @if($lanes->count() > 0)
                    <div class="d-flex flex-column gap-2">
                        @foreach($lanes->take(6) as $lane)
                        <div class="d-flex align-items-center p-2" style="background: #f8f9fa; border-radius: 12px;">
                            <div class="me-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 28px; height: 28px; background: {{ $lane->maintenance_status === 'operational' ? '#28a745' : '#dc3545' }};">
                                    <i class="fas fa-bowling-ball text-white" style="font-size: 0.7rem;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 min-w-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-semibold text-truncate" style="color: #1f2937;">{{ $lane->name }}</span>
                                    <span class="badge" style="background: {{ $lane->maintenance_status === 'operational' ? '#28a745' : '#dc3545' }}; color: white; padding: 2px 6px; border-radius: 8px; font-size: 0.7rem;">
                                        {{ $lane->maintenance_status === 'operational' ? 'OK' : 'Issue' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @if($lanes->count() > 6)
                        <small class="text-muted text-center">+{{ $lanes->count() - 6 }} more lanes</small>
                        @endif
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
</div>

@push('styles')
<style>
.quick-action-btn:hover {
    border-color: #17a2b8 !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(23, 162, 184, 0.15);
}
</style>
@endpush