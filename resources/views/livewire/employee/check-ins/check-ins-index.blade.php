{{-- Employee Check-ins Page --}}
<div>
    <!-- Check-ins Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0" style="background: linear-gradient(135deg, #c02425 0%, #d63031 100%); color: white; border-radius: 1.5rem; box-shadow: 0 20px 60px rgba(192, 36, 37, 0.3);">
                <div class="card-body py-4 px-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h2 class="mb-2 fw-bold">Check-ins</h2>
                            <p class="mb-3 opacity-90" style="font-size: 1.1rem;">Process customer arrivals and manage check-ins efficiently</p>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user-check me-2"></i>
                                <span>Streamline customer arrivals with quick check-in tools</span>
                            </div>
                        </div>
                        <div class="d-none d-md-block">
                            <i class="fas fa-sign-in-alt" style="font-size: 4rem; opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Success/Error Messages --}}
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Quick Check-in Section --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                <div class="card-header" style="background: transparent; border-bottom: 1px solid rgba(0, 0, 0, 0.05); padding: 1.5rem 1.5rem 0; border-radius: 1.25rem 1.25rem 0 0;">
                    <h5 class="mb-0 fw-bold d-flex align-items-center" style="color: #1b1b1b;">
                        <i class="fas fa-qrcode me-2" style="color: #17a2b8;"></i>
                        Quick Check-in
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-8">
                            <label class="form-label fw-bold mb-3" style="color: #1b1b1b; font-size: 1.1rem;">Enter Booking Code</label>
                            <div class="input-group" style="border-radius: 1rem; overflow: hidden; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);">
                                <input type="text" class="form-control form-control-lg" 
                                       wire:model="bookingCode" 
                                       wire:keydown.enter="searchBooking"
                                       placeholder="Enter booking reference code..."
                                       style="border: 2px solid rgba(0, 0, 0, 0.1); border-right: none; padding: 1rem 1.5rem; font-size: 1.1rem; font-weight: 500;"
                                       onfocus="this.style.borderColor='rgba(192, 36, 37, 0.5)'; this.nextElementSibling.style.borderColor='rgba(192, 36, 37, 0.5)'"
                                       onblur="this.style.borderColor='rgba(0, 0, 0, 0.1)'; this.nextElementSibling.style.borderColor='rgba(192, 36, 37, 0.8)'">
                                <button class="btn btn-lg px-4" wire:click="searchBooking"
                                        style="background: linear-gradient(135deg, #c02425 0%, #d63031 100%); color: white; border: 2px solid rgba(192, 36, 37, 0.8); font-weight: 600; transition: all 0.3s ease;"
                                        onmouseover="this.style.transform='scale(1.02)'; this.style.boxShadow='0 8px 25px rgba(192, 36, 37, 0.3)'"
                                        onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='none'">
                                    <i class="fas fa-search me-2"></i>Search
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button class="btn w-100 py-3" wire:click="clearSearch"
                                    style="background: rgba(108, 117, 125, 0.1); color: #6c757d; border: 2px solid rgba(108, 117, 125, 0.2); border-radius: 1rem; font-weight: 600; transition: all 0.3s ease;"
                                    onmouseover="this.style.backgroundColor='rgba(108, 117, 125, 0.2)'; this.style.transform='translateY(-2px)'"
                                    onmouseout="this.style.backgroundColor='rgba(108, 117, 125, 0.1)'; this.style.transform='translateY(0)'">
                                <i class="fas fa-times me-2"></i>Clear
                            </button>
                        </div>
                    </div>
                    
                    {{-- Booking Found --}}
                    @if($selectedBooking)
                        <div class="mt-4 p-4 rounded-3" style="background: rgba(40, 167, 69, 0.05); border: 2px solid rgba(40, 167, 69, 0.2); border-radius: 1.5rem;">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="me-3" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); width: 50px; height: 50px; border-radius: 15px; display: flex; align-items: center; justify-content: center; color: white;">
                                            <i class="fas fa-check-circle" style="font-size: 1.2rem;"></i>
                                        </div>
                                        <h5 class="mb-0 fw-bold" style="color: #28a745;">Booking Found!</h5>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-sm-6">
                                            <div class="p-3 rounded-3" style="background: rgba(255, 255, 255, 0.7);">
                                                <div class="fw-bold mb-1" style="color: #1b1b1b;">Customer</div>
                                                <div class="text-muted">{{ $selectedBooking->user->name }}</div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="p-3 rounded-3" style="background: rgba(255, 255, 255, 0.7);">
                                                <div class="fw-bold mb-1" style="color: #1b1b1b;">Time</div>
                                                <div class="text-muted">{{ $selectedBooking->start_time }} - {{ $selectedBooking->end_time }}</div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="p-3 rounded-3" style="background: rgba(255, 255, 255, 0.7);">
                                                <div class="fw-bold mb-1" style="color: #1b1b1b;">Lane</div>
                                                <div class="text-muted">{{ $selectedBooking->lane->name ?? 'Lane TBD' }}</div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="p-3 rounded-3" style="background: rgba(255, 255, 255, 0.7);">
                                                <div class="fw-bold mb-1" style="color: #1b1b1b;">Product</div>
                                                <div class="text-muted">{{ $selectedBooking->product->name ?? $selectedBooking->service->name ?? 'Standard Booking' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-3 mt-md-0">
                                    @if(in_array($selectedBooking->status, ['pending', 'confirmed']))
                                        <button class="btn btn-lg w-100 py-3" wire:click="checkIn({{ $selectedBooking->id }})"
                                                style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; border: none; border-radius: 1rem; font-weight: 600; transition: all 0.3s ease;"
                                                onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 30px rgba(40, 167, 69, 0.4)'"
                                                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                            <i class="fas fa-sign-in-alt me-2"></i>Check In Customer
                                        </button>
                                    @else
                                        <div class="text-center">
                                            <span class="badge px-4 py-3" style="background: rgba(111, 66, 193, 0.2); color: #6f42c1; font-size: 1rem; border-radius: 1rem; font-weight: 600;">Already Checked In</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Statistics --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6">
            <div class="card border-0 text-center h-100" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); transition: transform 0.3s ease, box-shadow 0.3s ease;"
                 onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 20px 40px rgba(0, 0, 0, 0.12)';"
                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(0, 0, 0, 0.08)';">
                <div class="card-body p-4">
                    <div class="mb-3" style="background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%); width: 60px; height: 60px; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                        <i class="fas fa-calendar-day" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                    <h3 class="fw-bold mb-2" style="color: #1b1b1b;">{{ $stats['total_today'] }}</h3>
                    <p class="mb-0 text-muted fw-medium">Total Today</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
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
        <div class="col-md-3 col-6">
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
        <div class="col-md-3 col-6">
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
    </div>

    <div class="row g-4">
        {{-- Upcoming Bookings --}}
        <div class="col-lg-6">
            <div class="card border-0 h-100" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                <div class="card-header" style="background: transparent; border-bottom: 1px solid rgba(0, 0, 0, 0.05); padding: 1.5rem 1.5rem 0; border-radius: 1.25rem 1.25rem 0 0;">
                    <h5 class="mb-0 fw-bold d-flex align-items-center" style="color: #1b1b1b;">
                        <i class="fas fa-clock me-2" style="color: #ffc107;"></i>
                        Upcoming Bookings
                    </h5>
                </div>
                <div class="card-body p-4" style="max-height: 500px; overflow-y: auto;">
                    @if(count($upcomingBookings) > 0)
                        @foreach($upcomingBookings as $booking)
                            <div class="d-flex align-items-center p-3 mb-3 rounded-3 {{ !$loop->last ? 'border-bottom' : '' }}" 
                                 style="background: rgba(255, 193, 7, 0.05); border: 1px solid rgba(255, 193, 7, 0.1) !important; transition: all 0.3s ease;"
                                 onmouseover="this.style.backgroundColor='rgba(255, 193, 7, 0.1)'; this.style.transform='translateX(3px)'"
                                 onmouseout="this.style.backgroundColor='rgba(255, 193, 7, 0.05)'; this.style.transform='translateX(0)'">
                                <div class="me-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); color: white;">
                                        <i class="fas fa-user" style="font-size: 1.2rem;"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-semibold" style="color: #1b1b1b;">{{ $booking->user->name }}</h6>
                                    <div class="text-muted small mb-1">
                                        <i class="fas fa-clock me-1"></i>{{ $booking->start_time }}
                                        <span class="ms-3">
                                            <i class="fas fa-bowling-ball me-1"></i>{{ $booking->lane->name ?? 'Lane TBD' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <span class="badge px-3 py-2" style="background: rgba(255, 193, 7, 0.2); color: #ffc107; font-size: 0.8rem; border-radius: 1rem; font-weight: 600;">{{ $booking->booking_reference }}</span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-clock mb-3" style="font-size: 3rem; color: rgba(255, 193, 7, 0.3);"></i>
                            <h5 class="fw-bold mb-2" style="color: #1b1b1b;">No upcoming bookings</h5>
                            <p class="text-muted mb-0">All caught up! No upcoming sessions to check in.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Recent Check-ins --}}
        <div class="col-lg-6">
            <div class="card border-0 h-100" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                <div class="card-header d-flex justify-content-between align-items-center" style="background: transparent; border-bottom: 1px solid rgba(0, 0, 0, 0.05); padding: 1.5rem; border-radius: 1.25rem 1.25rem 0 0;">
                    <h5 class="mb-0 fw-bold d-flex align-items-center" style="color: #1b1b1b;">
                        <i class="fas fa-check-circle me-2" style="color: #28a745;"></i>
                        Recent Check-ins
                    </h5>
                    <div class="input-group" style="max-width: 200px;">
                        <input type="text" class="form-control form-control-sm" wire:model.live="searchTerm" placeholder="Search..." 
                               style="border: 2px solid rgba(0, 0, 0, 0.1); border-radius: 1rem; padding: 0.5rem 0.75rem; font-weight: 500;"
                               onfocus="this.style.borderColor='rgba(40, 167, 69, 0.5)'; this.style.boxShadow='0 0 0 0.2rem rgba(40, 167, 69, 0.1)'"
                               onblur="this.style.borderColor='rgba(0, 0, 0, 0.1)'; this.style.boxShadow='none'">
                    </div>
                </div>
                <div class="card-body p-4" style="max-height: 500px; overflow-y: auto;">
                    @if(count($checkIns) > 0)
                        @foreach($checkIns as $checkIn)
                            <div class="d-flex align-items-center p-3 mb-3 rounded-3 {{ !$loop->last ? 'border-bottom' : '' }}" 
                                 style="background: rgba(40, 167, 69, 0.05); border: 1px solid rgba(40, 167, 69, 0.1) !important; transition: all 0.3s ease;"
                                 onmouseover="this.style.backgroundColor='rgba(40, 167, 69, 0.1)'; this.style.transform='translateX(3px)'"
                                 onmouseout="this.style.backgroundColor='rgba(40, 167, 69, 0.05)'; this.style.transform='translateX(0)'">
                                <div class="me-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; font-size: 1.1rem; font-weight: 600;">
                                        {{ substr($checkIn->user->name, 0, 1) }}
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-semibold" style="color: #1b1b1b;">{{ $checkIn->user->name }}</h6>
                                    <div class="text-muted small mb-1">
                                        <i class="fas fa-clock me-1"></i>{{ $checkIn->start_time }}
                                        <span class="ms-3">
                                            <i class="fas fa-bowling-ball me-1"></i>{{ $checkIn->lane->name ?? 'Lane TBD' }}
                                        </span>
                                    </div>
                                    <div class="small" style="color: #28a745; font-weight: 500;">
                                        <i class="fas fa-check me-1"></i>Updated {{ $checkIn->updated_at->format('H:i') }}
                                    </div>
                                </div>
                                <div class="text-end">
                                    <span class="badge px-3 py-2" style="font-size: 0.75rem; border-radius: 1rem; font-weight: 600;
                                        @if($checkIn->status === 'in_progress') background: rgba(40, 167, 69, 0.2); color: #28a745;
                                        @elseif($checkIn->status === 'completed') background: rgba(111, 66, 193, 0.2); color: #6f42c1;
                                        @else background: rgba(108, 117, 125, 0.2); color: #6c757d;
                                        @endif
                                    ">
                                        {{ ucfirst(str_replace('_', ' ', $checkIn->status == 'in_progress' ? 'checked_in' : $checkIn->status)) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-user-check mb-3" style="font-size: 3rem; color: rgba(40, 167, 69, 0.3);"></i>
                            <h5 class="fw-bold mb-2" style="color: #1b1b1b;">No check-ins today</h5>
                            <p class="text-muted mb-0">Customer check-ins will appear here once processed.</p>
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

    .input-group .form-control {
        border-radius: 1rem 0 0 1rem;
        border: 2px solid rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .input-group .btn {
        border-radius: 0 1rem 1rem 0;
        border: 2px solid rgba(192, 36, 37, 0.8);
        transition: all 0.3s ease;
    }

    .input-group .form-control:focus {
        border-color: rgba(192, 36, 37, 0.5);
        box-shadow: 0 0 0 0.2rem rgba(192, 36, 37, 0.1);
    }

    .input-group .form-control:focus + .btn {
        border-color: rgba(192, 36, 37, 0.5);
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

    .alert-danger {
        background: rgba(220, 53, 69, 0.1);
        color: #dc3545;
        border: 1px solid rgba(220, 53, 69, 0.2) !important;
    }

    .rounded-circle {
        transition: all 0.3s ease;
    }

    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: rgba(248, 249, 250, 0.8);
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #c02425 0%, #d63031 100%);
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, #a01e20 0%, #b52a2b 100%);
    }

    .btn:hover {
        transform: translateY(-1px);
    }

    @media (max-width: 768px) {
        .input-group {
            flex-direction: column;
        }
        
        .input-group .form-control,
        .input-group .btn {
            border-radius: 1rem !important;
            margin-bottom: 0.5rem;
        }
        
        .col-md-8,
        .col-md-4 {
            margin-bottom: 1rem;
        }
    }
    </style>
</div>