<x-slot name="header">
    Admin Dashboard
</x-slot>

<div>
    <!-- Stats Overview -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 text-center" 
                 style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); transition: transform 0.3s ease, box-shadow 0.3s ease;"
                 onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 20px 40px rgba(0, 0, 0, 0.12)';"
                 onmouseout="this.style.transform='translateY(0px)'; this.style.boxShadow='0 10px 30px rgba(0, 0, 0, 0.08)';">
                <div class="card-body p-4">
                    <div class="mb-3">
                        <i class="fas fa-users" style="font-size: 2.5rem; color: #c02425;"></i>
                    </div>
                    <h5 class="mb-2 fw-bold" style="color: #1b1b1b;">{{ \App\Models\User::count() }}</h5>
                    <p class="text-muted mb-0">Total Users</p>
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
                        <i class="fas fa-calendar-alt" style="font-size: 2.5rem; color: #28a745;"></i>
                    </div>
                    <h5 class="mb-2 fw-bold" style="color: #1b1b1b;">{{ \App\Models\Booking::count() }}</h5>
                    <p class="text-muted mb-0">Total Bookings</p>
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
                        <i class="fas fa-gift" style="font-size: 2.5rem; color: #17a2b8;"></i>
                    </div>
                    <h5 class="mb-2 fw-bold" style="color: #1b1b1b;">{{ \App\Models\GiftCard::count() }}</h5>
                    <p class="text-muted mb-0">Gift Cards</p>
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
                        <i class="fas fa-dollar-sign" style="font-size: 2.5rem; color: #ffc107;"></i>
                    </div>
                    <h5 class="mb-2 fw-bold" style="color: #1b1b1b;">${{ number_format(\App\Models\GiftCard::sum('original_amount'), 2) }}</h5>
                    <p class="text-muted mb-0">Gift Card Revenue</p>
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
                        <i class="fas fa-bolt me-2" style="color: #c02425;"></i>
                        Quick Actions
                    </h5>
                    <p class="text-muted mb-0 mt-1" style="font-size: 0.9rem;">Common administrative tasks</p>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <a href="{{ route('admin.users') }}" class="btn btn-outline-primary w-100 p-3 text-start" style="border-radius: 1rem; border: 1px solid #e0e6ed;">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-users me-3" style="font-size: 1.5rem; color: #c02425;"></i>
                                    <div>
                                        <h6 class="mb-0 fw-semibold">Manage Users</h6>
                                        <small class="text-muted">View and edit users</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('admin.lanes') }}" class="btn btn-outline-primary w-100 p-3 text-start" style="border-radius: 1rem; border: 1px solid #e0e6ed;">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-bowling-ball me-3" style="font-size: 1.5rem; color: #28a745;"></i>
                                    <div>
                                        <h6 class="mb-0 fw-semibold">Manage Lanes</h6>
                                        <small class="text-muted">Configure lanes</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('admin.gift-cards') }}" class="btn btn-outline-primary w-100 p-3 text-start" style="border-radius: 1rem; border: 1px solid #e0e6ed;">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-gift me-3" style="font-size: 1.5rem; color: #17a2b8;"></i>
                                    <div>
                                        <h6 class="mb-0 fw-semibold">Gift Cards</h6>
                                        <small class="text-muted">Manage gift cards</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('admin.products') }}" class="btn btn-outline-primary w-100 p-3 text-start" style="border-radius: 1rem; border: 1px solid #e0e6ed;">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-box me-3" style="font-size: 1.5rem; color: #ffc107;"></i>
                                    <div>
                                        <h6 class="mb-0 fw-semibold">Products</h6>
                                        <small class="text-muted">Manage inventory</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('admin.employees') }}" class="btn btn-outline-primary w-100 p-3 text-start" style="border-radius: 1rem; border: 1px solid #e0e6ed;">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user-tie me-3" style="font-size: 1.5rem; color: #6f42c1;"></i>
                                    <div>
                                        <h6 class="mb-0 fw-semibold">Employees</h6>
                                        <small class="text-muted">Staff management</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('admin.coupons') }}" class="btn btn-outline-primary w-100 p-3 text-start" style="border-radius: 1rem; border: 1px solid #e0e6ed;">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-tags me-3" style="font-size: 1.5rem; color: #fd7e14;"></i>
                                    <div>
                                        <h6 class="mb-0 fw-semibold">Coupons</h6>
                                        <small class="text-muted">Discount management</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <div class="col-md-8">
            <div class="card border-0" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                <div class="card-header" style="background: transparent; border-bottom: 1px solid rgba(0, 0, 0, 0.05); padding: 1.5rem 1.5rem 0; border-radius: 1.25rem 1.25rem 0 0;">
                    <h5 class="mb-0 fw-bold d-flex align-items-center" style="color: #1b1b1b;">
                        <i class="fas fa-clock me-2" style="color: #c02425;"></i>
                        Recent Bookings
                    </h5>
                    <p class="text-muted mb-0 mt-1" style="font-size: 0.9rem;">Latest customer bookings</p>
                </div>
                <div class="card-body p-4">
                    @php
                        $recentBookings = \App\Models\Booking::with('user', 'lane')
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();
                    @endphp
                    
                    @if($recentBookings->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentBookings as $booking)
                                <div class="list-group-item border-0 px-0 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                                 style="width: 40px; height: 40px; background: rgba(192, 36, 37, 0.1);">
                                                <i class="fas fa-user" style="color: #c02425;"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-semibold">{{ $booking->user->name }}</h6>
                                            <p class="mb-0 text-muted" style="font-size: 0.85rem;">
                                                Booked {{ $booking->lane->name ?? 'Lane' }} • {{ $booking->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                        <div class="ms-3">
                                            <span class="badge rounded-pill" 
                                                  style="background: {{ $booking->status === 'confirmed' ? '#28a745' : ($booking->status === 'pending' ? '#ffc107' : '#6c757d') }};">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-calendar-alt text-muted mb-3" style="font-size: 3rem; opacity: 0.3;"></i>
                            <h6 class="text-muted">No recent bookings</h6>
                            <p class="text-muted mb-0">New bookings will appear here</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-0" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                <div class="card-header" style="background: transparent; border-bottom: 1px solid rgba(0, 0, 0, 0.05); padding: 1.5rem 1.5rem 0; border-radius: 1.25rem 1.25rem 0 0;">
                    <h5 class="mb-0 fw-bold d-flex align-items-center" style="color: #1b1b1b;">
                        <i class="fas fa-chart-line me-2" style="color: #c02425;"></i>
                        System Status
                    </h5>
                    <p class="text-muted mb-0 mt-1" style="font-size: 0.9rem;">Current system health</p>
                </div>
                <div class="card-body p-4">
                    <div class="d-grid gap-3">
                        <div class="d-flex align-items-center justify-content-between p-3 rounded-3" style="background: rgba(40, 167, 69, 0.1); border: 1px solid rgba(40, 167, 69, 0.2);">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-server me-3" style="color: #28a745;"></i>
                                <div>
                                    <h6 class="mb-0 fw-semibold" style="font-size: 0.9rem;">Server Status</h6>
                                    <small class="text-muted">Operational</small>
                                </div>
                            </div>
                            <div class="text-success">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center justify-content-between p-3 rounded-3" style="background: rgba(40, 167, 69, 0.1); border: 1px solid rgba(40, 167, 69, 0.2);">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-database me-3" style="color: #28a745;"></i>
                                <div>
                                    <h6 class="mb-0 fw-semibold" style="font-size: 0.9rem;">Database</h6>
                                    <small class="text-muted">Connected</small>
                                </div>
                            </div>
                            <div class="text-success">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center justify-content-between p-3 rounded-3" style="background: rgba(255, 193, 7, 0.1); border: 1px solid rgba(255, 193, 7, 0.2);">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-memory me-3" style="color: #ffc107;"></i>
                                <div>
                                    <h6 class="mb-0 fw-semibold" style="font-size: 0.9rem;">Memory Usage</h6>
                                    <small class="text-muted">{{ round(memory_get_usage(true) / 1024 / 1024, 2) }} MB</small>
                                </div>
                            </div>
                            <div class="text-warning">
                                <i class="fas fa-info-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
