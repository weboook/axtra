<x-slot name="header">
    Employee Dashboard
</x-slot>

<div>
    <!-- Employee Stats -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 text-center" 
                 style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); transition: transform 0.3s ease, box-shadow 0.3s ease;"
                 onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 20px 40px rgba(0, 0, 0, 0.12)';"
                 onmouseout="this.style.transform='translateY(0px)'; this.style.boxShadow='0 10px 30px rgba(0, 0, 0, 0.08)';">
                <div class="card-body p-4">
                    <div class="mb-3">
                        <i class="fas fa-calendar-check" style="font-size: 2.5rem; color: #17a2b8;"></i>
                    </div>
                    <h5 class="mb-2 fw-bold" style="color: #1b1b1b;">{{ \App\Models\Booking::whereDate('created_at', today())->count() }}</h5>
                    <p class="text-muted mb-0">Today's Bookings</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 text-center" 
                 style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); transition: transform 0.3s ease, box-shadow 0.3s ease;"
                 onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 20px 40px rgba(0, 0, 0, 0.12)';"
                 onmouseout="this.style.transform='translateY(0px)'; this.style.boxShadow='0 10px 30px rgba(0, 0, 0, 0.08)';">
                <div class="card-body p-4">
                    <div class="mb-3">
                        <i class="fas fa-bowling-ball" style="font-size: 2.5rem; color: #28a745;"></i>
                    </div>
                    <h5 class="mb-2 fw-bold" style="color: #1b1b1b;">{{ \App\Models\Lane::where('is_available', true)->count() }}</h5>
                    <p class="text-muted mb-0">Available Lanes</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 text-center" 
                 style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); transition: transform 0.3s ease, box-shadow 0.3s ease;"
                 onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 20px 40px rgba(0, 0, 0, 0.12)';"
                 onmouseout="this.style.transform='translateY(0px)'; this.style.boxShadow='0 10px 30px rgba(0, 0, 0, 0.08)';">
                <div class="card-body p-4">
                    <div class="mb-3">
                        <i class="fas fa-clock" style="font-size: 2.5rem; color: #ffc107;"></i>
                    </div>
                    <h5 class="mb-2 fw-bold" style="color: #1b1b1b;">{{ \App\Models\Booking::where('status', 'pending')->count() }}</h5>
                    <p class="text-muted mb-0">Pending Bookings</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 text-center" 
                 style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); transition: transform 0.3s ease, box-shadow 0.3s ease;"
                 onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 20px 40px rgba(0, 0, 0, 0.12)';"
                 onmouseout="this.style.transform='translateY(0px)'; this.style.boxShadow='0 10px 30px rgba(0, 0, 0, 0.08)';">
                <div class="card-body p-4">
                    <div class="mb-3">
                        <i class="fas fa-users" style="font-size: 2.5rem; color: #6f42c1;"></i>
                    </div>
                    <h5 class="mb-2 fw-bold" style="color: #1b1b1b;">{{ \App\Models\User::customers()->count() }}</h5>
                    <p class="text-muted mb-0">Total Customers</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                <div class="card-header" style="background: transparent; border-bottom: 1px solid rgba(0, 0, 0, 0.05); padding: 1.5rem 1.5rem 0; border-radius: 1.25rem 1.25rem 0 0;">
                    <h5 class="mb-0 fw-bold d-flex align-items-center" style="color: #1b1b1b;">
                        <i class="fas fa-bolt me-2" style="color: #17a2b8;"></i>
                        Quick Actions
                    </h5>
                    <p class="text-muted mb-0 mt-1" style="font-size: 0.9rem;">Common staff tasks</p>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <a href="{{ route('employee.schedule') }}" class="btn btn-outline-primary w-100 p-3 text-start" style="border-radius: 1rem; border: 1px solid #e0e6ed;">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-calendar-alt me-3" style="font-size: 1.5rem; color: #17a2b8;"></i>
                                    <div>
                                        <h6 class="mb-0 fw-semibold">My Schedule</h6>
                                        <small class="text-muted">View work schedule</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('employee.quick-actions') }}" class="btn btn-outline-primary w-100 p-3 text-start" style="border-radius: 1rem; border: 1px solid #e0e6ed;">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-zap me-3" style="font-size: 1.5rem; color: #ffc107;"></i>
                                    <div>
                                        <h6 class="mb-0 fw-semibold">Quick Actions</h6>
                                        <small class="text-muted">Common tasks</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <button type="button" class="btn btn-outline-primary w-100 p-3 text-start" style="border-radius: 1rem; border: 1px solid #e0e6ed;">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-headset me-3" style="font-size: 1.5rem; color: #28a745;"></i>
                                    <div>
                                        <h6 class="mb-0 fw-semibold">Customer Support</h6>
                                        <small class="text-muted">Help customers</small>
                                    </div>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Schedule & Recent Bookings -->
    <div class="row">
        <div class="col-md-6">
            <div class="card border-0" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                <div class="card-header" style="background: transparent; border-bottom: 1px solid rgba(0, 0, 0, 0.05); padding: 1.5rem 1.5rem 0; border-radius: 1.25rem 1.25rem 0 0;">
                    <h5 class="mb-0 fw-bold d-flex align-items-center" style="color: #1b1b1b;">
                        <i class="fas fa-clock me-2" style="color: #17a2b8;"></i>
                        Today's Schedule
                    </h5>
                    <p class="text-muted mb-0 mt-1" style="font-size: 0.9rem;">Your work schedule for today</p>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-center p-3 rounded-3 mb-3" style="background: rgba(23, 162, 184, 0.1); border: 1px solid rgba(23, 162, 184, 0.2);">
                        <div class="me-3">
                            <i class="fas fa-briefcase" style="color: #17a2b8; font-size: 1.2rem;"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-semibold" style="color: #1b1b1b;">Regular Shift</h6>
                            <p class="mb-0 text-muted" style="font-size: 0.85rem;">9:00 AM - 6:00 PM</p>
                        </div>
                        <div class="ms-3">
                            <span class="badge rounded-pill" style="background: #28a745;">Active</span>
                        </div>
                    </div>
                    
                    <div class="text-center py-3">
                        <div class="mb-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto" 
                                 style="width: 60px; height: 60px; background: rgba(23, 162, 184, 0.1);">
                                <i class="fas fa-clock" style="color: #17a2b8; font-size: 1.5rem;"></i>
                            </div>
                        </div>
                        <h6 class="fw-semibold mb-1" style="color: #1b1b1b;">Currently On Shift</h6>
                        <p class="text-muted mb-0" style="font-size: 0.85rem;">{{ now()->format('g:i A') }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card border-0" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                <div class="card-header" style="background: transparent; border-bottom: 1px solid rgba(0, 0, 0, 0.05); padding: 1.5rem 1.5rem 0; border-radius: 1.25rem 1.25rem 0 0;">
                    <h5 class="mb-0 fw-bold d-flex align-items-center" style="color: #1b1b1b;">
                        <i class="fas fa-calendar-check me-2" style="color: #17a2b8;"></i>
                        Recent Bookings
                    </h5>
                    <p class="text-muted mb-0 mt-1" style="font-size: 0.9rem;">Latest customer reservations</p>
                </div>
                <div class="card-body p-4">
                    @php
                        $todayBookings = \App\Models\Booking::with('user', 'lane')
                            ->whereDate('created_at', today())
                            ->orderBy('created_at', 'desc')
                            ->take(4)
                            ->get();
                    @endphp
                    
                    @if($todayBookings->count() > 0)
                        <div class="d-grid gap-2">
                            @foreach($todayBookings as $booking)
                                <div class="d-flex align-items-center p-2 rounded-3" style="background: #f8f9fa;">
                                    <div class="me-3">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                             style="width: 35px; height: 35px; background: rgba(23, 162, 184, 0.1);">
                                            <i class="fas fa-user" style="color: #17a2b8; font-size: 0.9rem;"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0 fw-semibold" style="font-size: 0.85rem;">{{ $booking->user->name }}</h6>
                                        <p class="mb-0 text-muted" style="font-size: 0.75rem;">
                                            {{ $booking->lane->name ?? 'Lane' }} • {{ $booking->created_at->format('g:i A') }}
                                        </p>
                                    </div>
                                    <div class="ms-2">
                                        <span class="badge rounded-pill" style="font-size: 0.7rem; background: {{ $booking->status === 'confirmed' ? '#28a745' : '#ffc107' }};">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-calendar-alt text-muted mb-3" style="font-size: 2rem; opacity: 0.3;"></i>
                            <h6 class="text-muted" style="font-size: 0.9rem;">No bookings today</h6>
                            <p class="text-muted mb-0" style="font-size: 0.8rem;">New bookings will appear here</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Lane Status -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                <div class="card-header" style="background: transparent; border-bottom: 1px solid rgba(0, 0, 0, 0.05); padding: 1.5rem 1.5rem 0; border-radius: 1.25rem 1.25rem 0 0;">
                    <h5 class="mb-0 fw-bold d-flex align-items-center" style="color: #1b1b1b;">
                        <i class="fas fa-bowling-ball me-2" style="color: #17a2b8;"></i>
                        Lane Status
                    </h5>
                    <p class="text-muted mb-0 mt-1" style="font-size: 0.9rem;">Current status of all lanes</p>
                </div>
                <div class="card-body p-4">
                    @php
                        $lanes = \App\Models\Lane::all();
                    @endphp
                    
                    @if($lanes->count() > 0)
                        <div class="row g-3">
                            @foreach($lanes as $lane)
                                <div class="col-md-3">
                                    <div class="card border" style="border-radius: 1rem; border-color: {{ $lane->is_available ? '#28a745' : '#dc3545' }} !important; background: {{ $lane->is_available ? 'rgba(40, 167, 69, 0.05)' : 'rgba(220, 53, 69, 0.05)' }};">
                                        <div class="card-body p-3 text-center">
                                            <div class="mb-2">
                                                <i class="fas fa-bowling-ball" style="font-size: 1.5rem; color: {{ $lane->is_available ? '#28a745' : '#dc3545' }};"></i>
                                            </div>
                                            <h6 class="mb-1 fw-semibold">{{ $lane->name }}</h6>
                                            <span class="badge rounded-pill" style="background: {{ $lane->is_available ? '#28a745' : '#dc3545' }};">
                                                {{ $lane->is_available ? 'Available' : 'Occupied' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-bowling-ball text-muted mb-3" style="font-size: 3rem; opacity: 0.3;"></i>
                            <h6 class="text-muted">No lanes configured</h6>
                            <p class="text-muted mb-0">Contact admin to set up lanes</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
