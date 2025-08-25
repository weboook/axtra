{{-- Employee Today's Bookings Page --}}
<div>
    <!-- Bookings Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0" style="background: linear-gradient(135deg, #c02425 0%, #d63031 100%); color: white; border-radius: 1.5rem; box-shadow: 0 20px 60px rgba(192, 36, 37, 0.3);">
                <div class="card-body py-4 px-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h2 class="mb-2 fw-bold">Today's Bookings</h2>
                            <p class="mb-3 opacity-90" style="font-size: 1.1rem;">Manage customer bookings and check-ins efficiently</p>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-users me-2"></i>
                                <span>Keep track of all customer sessions and statuses</span>
                            </div>
                        </div>
                        <div class="d-none d-md-block">
                            <button class="btn btn-light text-dark px-4 py-2" wire:click="goToToday" 
                                    style="border-radius: 1rem; font-weight: 600; transition: all 0.3s ease;"
                                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(255, 255, 255, 0.3)'"
                                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                <i class="fas fa-calendar-day me-2"></i>Go to Today
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Success Message --}}
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Date Selection & Filters --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                <div class="card-header" style="background: transparent; border-bottom: 1px solid rgba(0, 0, 0, 0.05); padding: 1.5rem 1.5rem 0; border-radius: 1.25rem 1.25rem 0 0;">
                    <h5 class="mb-0 fw-bold d-flex align-items-center" style="color: #1b1b1b;">
                        <i class="fas fa-filter me-2" style="color: #17a2b8;"></i>
                        Filters & Search
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        {{-- Date Picker --}}
                        <div class="col-md-4">
                            <label class="form-label fw-bold mb-2" style="color: #1b1b1b;">Select Date</label>
                            <input type="date" class="form-control" wire:model.live="selectedDate" 
                                   style="border: 2px solid rgba(0, 0, 0, 0.1); border-radius: 1rem; padding: 0.75rem 1rem; font-size: 1rem;"
                                   onfocus="this.style.borderColor='rgba(192, 36, 37, 0.5)'; this.style.boxShadow='0 0 0 0.2rem rgba(192, 36, 37, 0.1)'"
                                   onblur="this.style.borderColor='rgba(0, 0, 0, 0.1)'; this.style.boxShadow='none'">
                        </div>
                        
                        {{-- Search --}}
                        <div class="col-md-4">
                            <label class="form-label fw-bold mb-2" style="color: #1b1b1b;">Search Customer</label>
                            <input type="text" class="form-control" wire:model.live="searchTerm" placeholder="Search by customer name..." 
                                   style="border: 2px solid rgba(0, 0, 0, 0.1); border-radius: 1rem; padding: 0.75rem 1rem; font-size: 1rem;"
                                   onfocus="this.style.borderColor='rgba(192, 36, 37, 0.5)'; this.style.boxShadow='0 0 0 0.2rem rgba(192, 36, 37, 0.1)'"
                                   onblur="this.style.borderColor='rgba(0, 0, 0, 0.1)'; this.style.boxShadow='none'">
                        </div>
                        
                        {{-- Status Filter --}}
                        <div class="col-md-4">
                            <label class="form-label fw-bold mb-2" style="color: #1b1b1b;">Status Filter</label>
                            <select class="form-select" wire:model.live="statusFilter" 
                                    style="border: 2px solid rgba(0, 0, 0, 0.1); border-radius: 1rem; padding: 0.75rem 1rem; font-size: 1rem;"
                                    onfocus="this.style.borderColor='rgba(192, 36, 37, 0.5)'; this.style.boxShadow='0 0 0 0.2rem rgba(192, 36, 37, 0.1)'"
                                    onblur="this.style.borderColor='rgba(0, 0, 0, 0.1)'; this.style.boxShadow='none'">
                                <option value="all">All Bookings</option>
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="in_progress">In Progress</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled/No Show</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-2 col-6">
            <div class="card border-0 text-center h-100" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); transition: transform 0.3s ease, box-shadow 0.3s ease;"
                 onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 20px 40px rgba(0, 0, 0, 0.12)';"
                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(0, 0, 0, 0.08)';">
                <div class="card-body p-4">
                    <div class="mb-3" style="background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%); width: 60px; height: 60px; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                        <i class="fas fa-calendar-alt" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                    <h3 class="fw-bold mb-2" style="color: #1b1b1b;">{{ $stats['total'] }}</h3>
                    <p class="mb-0 text-muted fw-medium">Total Bookings</p>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-6">
            <div class="card border-0 text-center h-100" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); transition: transform 0.3s ease, box-shadow 0.3s ease;"
                 onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 20px 40px rgba(0, 0, 0, 0.12)';"
                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(0, 0, 0, 0.08)';">
                <div class="card-body p-4">
                    <div class="mb-3" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); width: 60px; height: 60px; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                        <i class="fas fa-clock" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                    <h3 class="fw-bold mb-2" style="color: #1b1b1b;">{{ $stats['pending'] }}</h3>
                    <p class="mb-0 text-muted fw-medium">Pending</p>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-6">
            <div class="card border-0 text-center h-100" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); transition: transform 0.3s ease, box-shadow 0.3s ease;"
                 onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 20px 40px rgba(0, 0, 0, 0.12)';"
                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(0, 0, 0, 0.08)';">
                <div class="card-body p-4">
                    <div class="mb-3" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); width: 60px; height: 60px; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                        <i class="fas fa-user-check" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                    <h3 class="fw-bold mb-2" style="color: #1b1b1b;">{{ $stats['checked_in'] }}</h3>
                    <p class="mb-0 text-muted fw-medium">Checked In</p>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-6">
            <div class="card border-0 text-center h-100" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); transition: transform 0.3s ease, box-shadow 0.3s ease;"
                 onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 20px 40px rgba(0, 0, 0, 0.12)';"
                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(0, 0, 0, 0.08)';">
                <div class="card-body p-4">
                    <div class="mb-3" style="background: linear-gradient(135deg, #6f42c1 0%, #e83e8c 100%); width: 60px; height: 60px; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                        <i class="fas fa-flag-checkered" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                    <h3 class="fw-bold mb-2" style="color: #1b1b1b;">{{ $stats['completed'] }}</h3>
                    <p class="mb-0 text-muted fw-medium">Completed</p>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-6">
            <div class="card border-0 text-center h-100" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); transition: transform 0.3s ease, box-shadow 0.3s ease;"
                 onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 20px 40px rgba(0, 0, 0, 0.12)';"
                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(0, 0, 0, 0.08)';">
                <div class="card-body p-4">
                    <div class="mb-3" style="background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%); width: 60px; height: 60px; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                        <i class="fas fa-user-times" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                    <h3 class="fw-bold mb-2" style="color: #1b1b1b;">{{ $stats['no_show'] }}</h3>
                    <p class="mb-0 text-muted fw-medium">No Show</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Selected Date Display --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0" style="background: rgba(23, 162, 184, 0.05); border-radius: 1.25rem; border: 1px solid rgba(23, 162, 184, 0.1) !important;">
                <div class="card-body py-3 px-4">
                    <h5 class="mb-0 fw-bold d-flex align-items-center" style="color: #17a2b8;">
                        <div class="me-3" style="background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%); width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white;">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        Showing bookings for: {{ $selectedDateFormatted }}
                    </h5>
                </div>
            </div>
        </div>
    </div>

    {{-- Bookings List --}}
    <div class="row">
        <div class="col-12">
            <div class="card border-0" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                <div class="card-header" style="background: transparent; border-bottom: 1px solid rgba(0, 0, 0, 0.05); padding: 1.5rem 1.5rem 0; border-radius: 1.25rem 1.25rem 0 0;">
                    <h5 class="mb-0 fw-bold d-flex align-items-center" style="color: #1b1b1b;">
                        <i class="fas fa-list me-2" style="color: #6f42c1;"></i>
                        Bookings ({{ count($bookings) }})
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if(count($bookings) > 0)
                        <div class="table-responsive" style="border-radius: 1rem; overflow: hidden;">
                            <table class="table mb-0" style="border-collapse: separate; border-spacing: 0;">
                                <thead style="background: rgba(248, 249, 250, 0.8);">
                                    <tr>
                                        <th class="fw-bold py-3" style="color: #1b1b1b; border: none;">Time</th>
                                        <th class="fw-bold py-3" style="color: #1b1b1b; border: none;">Customer</th>
                                        <th class="fw-bold py-3" style="color: #1b1b1b; border: none;">Lane</th>
                                        <th class="fw-bold py-3" style="color: #1b1b1b; border: none;">Product</th>
                                        <th class="fw-bold py-3" style="color: #1b1b1b; border: none;">Status</th>
                                        <th class="fw-bold py-3" style="color: #1b1b1b; border: none;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookings as $booking)
                                        <tr style="transition: background-color 0.2s ease;" onmouseover="this.style.backgroundColor='rgba(248, 249, 250, 0.5)'" onmouseout="this.style.backgroundColor='transparent'">
                                            <td class="py-3" style="border: none;">
                                                <div class="fw-bold" style="color: #1b1b1b;">{{ $booking->start_time }} - {{ $booking->end_time }}</div>
                                                <small class="text-muted fw-medium">60 minutes</small>
                                            </td>
                                            <td class="py-3" style="border: none;">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-3">
                                                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: linear-gradient(135deg, #c02425 0%, #d63031 100%); color: white; font-size: 0.9rem; font-weight: 600;">
                                                            {{ substr($booking->user->name, 0, 1) }}
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold" style="color: #1b1b1b;">{{ $booking->user->name }}</div>
                                                        <small class="text-muted">{{ $booking->user->email }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-3" style="border: none;">
                                                @if($booking->lane)
                                                    <span class="badge px-3 py-2" style="background: rgba(192, 36, 37, 0.1); color: #c02425; font-size: 0.75rem; border-radius: 1rem; font-weight: 600;">{{ $booking->lane->name }}</span>
                                                @else
                                                    <span class="badge px-3 py-2" style="background: rgba(108, 117, 125, 0.1); color: #6c757d; font-size: 0.75rem; border-radius: 1rem; font-weight: 600;">Lane TBD</span>
                                                @endif
                                            </td>
                                            <td class="py-3" style="border: none;">
                                                <span class="fw-semibold" style="color: #1b1b1b;">{{ $booking->product->name ?? $booking->service->name ?? 'Standard Booking' }}</span>
                                                @if($booking->total_price)
                                                    <br><small class="text-muted fw-medium">CHF {{ number_format($booking->total_price, 2) }}</small>
                                                @endif
                                            </td>
                                            <td class="py-3" style="border: none;">
                                                <span class="badge px-3 py-2" style="font-size: 0.75rem; border-radius: 1rem; font-weight: 600;
                                                    @if($booking->status === 'pending') background: rgba(255, 193, 7, 0.2); color: #ffc107;
                                                    @elseif($booking->status === 'checked_in') background: rgba(40, 167, 69, 0.2); color: #28a745;
                                                    @elseif($booking->status === 'completed') background: rgba(111, 66, 193, 0.2); color: #6f42c1;
                                                    @elseif($booking->status === 'no_show') background: rgba(220, 53, 69, 0.2); color: #dc3545;
                                                    @else background: rgba(108, 117, 125, 0.2); color: #6c757d;
                                                    @endif
                                                ">
                                                    {{ ucfirst(str_replace('_', ' ', $booking->status ?? 'pending')) }}
                                                </span>
                                            </td>
                                            <td class="py-3" style="border: none;">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    @if(in_array($booking->status, ['pending', 'confirmed']))
                                                        <button class="btn px-3 py-1 me-1" wire:click="markAsCheckedIn({{ $booking->id }})" title="Check In"
                                                                style="background: rgba(40, 167, 69, 0.1); color: #28a745; border: 1px solid rgba(40, 167, 69, 0.2); border-radius: 0.75rem; font-size: 0.8rem; transition: all 0.3s ease;"
                                                                onmouseover="this.style.backgroundColor='rgba(40, 167, 69, 0.2)'; this.style.transform='translateY(-1px)'"
                                                                onmouseout="this.style.backgroundColor='rgba(40, 167, 69, 0.1)'; this.style.transform='translateY(0)'">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                        <button class="btn px-3 py-1" wire:click="markAsNoShow({{ $booking->id }})" title="Mark as No-Show"
                                                                style="background: rgba(220, 53, 69, 0.1); color: #dc3545; border: 1px solid rgba(220, 53, 69, 0.2); border-radius: 0.75rem; font-size: 0.8rem; transition: all 0.3s ease;"
                                                                onmouseover="this.style.backgroundColor='rgba(220, 53, 69, 0.2)'; this.style.transform='translateY(-1px)'"
                                                                onmouseout="this.style.backgroundColor='rgba(220, 53, 69, 0.1)'; this.style.transform='translateY(0)'">
                                                            <i class="fas fa-user-times"></i>
                                                        </button>
                                                    @elseif($booking->status === 'in_progress')
                                                        <button class="btn px-3 py-1" wire:click="markAsCompleted({{ $booking->id }})" title="Mark as Completed"
                                                                style="background: rgba(111, 66, 193, 0.1); color: #6f42c1; border: 1px solid rgba(111, 66, 193, 0.2); border-radius: 0.75rem; font-size: 0.8rem; transition: all 0.3s ease;"
                                                                onmouseover="this.style.backgroundColor='rgba(111, 66, 193, 0.2)'; this.style.transform='translateY(-1px)'"
                                                                onmouseout="this.style.backgroundColor='rgba(111, 66, 193, 0.1)'; this.style.transform='translateY(0)'">
                                                            <i class="fas fa-flag-checkered"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-calendar-times mb-3" style="font-size: 3rem; color: rgba(111, 66, 193, 0.3);"></i>
                            <h5 class="fw-bold mb-2" style="color: #1b1b1b;">No bookings found</h5>
                            <p class="text-muted mb-0">
                                @if($searchTerm || $statusFilter !== 'all')
                                    Try adjusting your filters or search terms.
                                @else
                                    No bookings scheduled for {{ $selectedDateFormatted }}.
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <style>
    .card {
        transition: all 0.3s ease;
        border: none !important;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12) !important;
    }

    .btn-group-sm .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.8rem;
        border: none;
        margin: 0 2px;
        border-radius: 0.75rem !important;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-group-sm .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .table th,
    .table td {
        border: none !important;
        vertical-align: middle;
        padding: 1rem 0.75rem;
    }

    .table thead th {
        background: rgba(248, 249, 250, 0.8) !important;
        font-weight: 700 !important;
        color: #1b1b1b !important;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05) !important;
    }

    .table tbody tr {
        transition: all 0.2s ease;
    }

    .table tbody tr:hover {
        background-color: rgba(248, 249, 250, 0.5) !important;
        transform: translateX(3px);
    }

    .badge {
        font-size: 0.75rem;
        padding: 0.5rem 0.75rem;
        border-radius: 1rem !important;
        font-weight: 600;
        border: none;
    }

    .form-control,
    .form-select {
        transition: all 0.3s ease;
        font-weight: 500;
        border: 2px solid rgba(0, 0, 0, 0.1);
        border-radius: 1rem;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: rgba(192, 36, 37, 0.5) !important;
        box-shadow: 0 0 0 0.2rem rgba(192, 36, 37, 0.1) !important;
    }

    .alert {
        border: none !important;
        border-radius: 1rem !important;
        padding: 1rem 1.5rem;
        font-weight: 500;
    }

    .alert-success {
        background: rgba(40, 167, 69, 0.1);
        color: #28a745;
        border: 1px solid rgba(40, 167, 69, 0.2) !important;
    }

    .rounded-circle {
        transition: all 0.3s ease;
    }

    .table-responsive {
        border-radius: 1rem;
        overflow: hidden;
    }

    .btn-light:hover {
        background: rgba(255, 255, 255, 0.9) !important;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    @media (max-width: 768px) {
        .d-none.d-md-block {
            display: none !important;
        }
        
        .btn-light.text-dark {
            margin-top: 1rem;
            width: 100%;
        }
    }
    </style>
</div>