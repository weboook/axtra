{{-- Employee Schedule Page --}}
<div>
    <!-- Schedule Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0" style="background: linear-gradient(135deg, #c02425 0%, #d63031 100%); color: white; border-radius: 1.5rem; box-shadow: 0 20px 60px rgba(192, 36, 37, 0.3);">
                <div class="card-body py-4 px-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h2 class="mb-2 fw-bold">My Schedule</h2>
                            <p class="mb-3 opacity-90" style="font-size: 1.1rem;">View bookings and manage your work schedule</p>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-calendar-check me-2"></i>
                                <span>Stay organized and manage your shifts effectively</span>
                            </div>
                        </div>
                        <div class="d-none d-md-block">
                            <i class="fas fa-calendar-alt" style="font-size: 4rem; opacity: 0.3;"></i>
                        </div>
                    </div>
                    
                    {{-- View Mode Toggles --}}
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="btn-group w-100" role="group" style="max-width: 400px;">
                                <button type="button" class="btn {{ $viewMode === 'daily' ? 'btn-light text-dark' : 'btn-outline-light' }} flex-fill" 
                                        wire:click="setViewMode('daily')" style="border-radius: 1rem 0 0 1rem;">
                                    <i class="fas fa-calendar-day me-1"></i>Daily
                                </button>
                                <button type="button" class="btn {{ $viewMode === 'weekly' ? 'btn-light text-dark' : 'btn-outline-light' }} flex-fill" 
                                        wire:click="setViewMode('weekly')">
                                    <i class="fas fa-calendar-week me-1"></i>Weekly
                                </button>
                                <button type="button" class="btn {{ $viewMode === 'monthly' ? 'btn-light text-dark' : 'btn-outline-light' }} flex-fill" 
                                        wire:click="setViewMode('monthly')" style="border-radius: 0 1rem 1rem 0;">
                                    <i class="fas fa-calendar-alt me-1"></i>Monthly
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Navigation Controls --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                <div class="card-body d-flex justify-content-between align-items-center py-4">
                    <button class="btn" wire:click="previousPeriod" 
                            style="background: linear-gradient(135deg, #1b1b1b 0%, #343a40 100%); color: white; border-radius: 1rem; border: none; padding: 0.75rem 1.5rem; transition: transform 0.3s ease;"
                            onmouseover="this.style.transform='translateY(-2px)'"
                            onmouseout="this.style.transform='translateY(0)'">
                        <i class="fas fa-chevron-left me-1"></i>Previous
                    </button>
                    
                    <div class="text-center">
                        <h4 class="mb-2 fw-bold" style="color: #1b1b1b;">
                            @if($viewMode === 'daily')
                                {{ $currentDay->format('l, F j, Y') }}
                            @elseif($viewMode === 'weekly') 
                                {{ $weekStart->format('M j') }} - {{ $weekEnd->format('M j, Y') }}
                            @else
                                {{ $currentDateFormatted }}
                            @endif
                        </h4>
                        <button class="btn btn-sm" wire:click="goToToday" 
                                style="background: rgba(192, 36, 37, 0.1); color: #c02425; border: 1px solid rgba(192, 36, 37, 0.2); border-radius: 1rem; padding: 0.5rem 1rem;">
                            <i class="fas fa-calendar-check me-1"></i>Go to Today
                        </button>
                    </div>
                    
                    <button class="btn" wire:click="nextPeriod"
                            style="background: linear-gradient(135deg, #1b1b1b 0%, #343a40 100%); color: white; border-radius: 1rem; border: none; padding: 0.75rem 1.5rem; transition: transform 0.3s ease;"
                            onmouseover="this.style.transform='translateY(-2px)'"
                            onmouseout="this.style.transform='translateY(0)'">
                        Next<i class="fas fa-chevron-right ms-1"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Today's Quick Overview --}}
    @if(count($todayBookings) > 0)
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                    <div class="card-header" style="background: transparent; border-bottom: 1px solid rgba(0, 0, 0, 0.05); padding: 1.5rem 1.5rem 0; border-radius: 1.25rem 1.25rem 0 0;">
                        <h5 class="mb-0 fw-bold d-flex align-items-center" style="color: #1b1b1b;">
                            <i class="fas fa-star me-2" style="color: #28a745;"></i>
                            Today's Schedule ({{ count($todayBookings) }} bookings)
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            @foreach($todayBookings as $booking)
                                <div class="col-md-6 col-lg-4">
                                    <div class="card border-0 h-100" style="background: rgba(40, 167, 69, 0.05); border-radius: 1rem; border: 1px solid rgba(40, 167, 69, 0.1) !important;">
                                        <div class="card-body p-3">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h6 class="mb-0 fw-bold" style="color: #1b1b1b;">{{ $booking->start_time }} - {{ $booking->end_time }}</h6>
                                                <span class="badge px-2 py-1" style="background: rgba(40, 167, 69, 0.2); color: #28a745; font-size: 0.75rem;">{{ $booking->lane->name ?? 'Lane TBD' }}</span>
                                            </div>
                                            <p class="text-muted small mb-1">
                                                <i class="fas fa-user me-1"></i>
                                                {{ $booking->user->name }}
                                            </p>
                                            <p class="text-muted small mb-0">
                                                <i class="fas fa-tag me-1"></i>
                                                {{ $booking->product->name ?? $booking->service->name ?? 'Standard Booking' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Calendar Views --}}
    @if($viewMode === 'daily')
        {{-- Daily View --}}
        <div class="row">
            <div class="col-12">
                <div class="card border-0" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                    <div class="card-header" style="background: transparent; border-bottom: 1px solid rgba(0, 0, 0, 0.05); padding: 1.5rem 1.5rem 0; border-radius: 1.25rem 1.25rem 0 0;">
                        <h5 class="mb-0 fw-bold d-flex align-items-center" style="color: #1b1b1b;">
                            <i class="fas fa-calendar-day me-2" style="color: #17a2b8;"></i>
                            Daily Schedule - {{ $currentDay->format('l, F j, Y') }}
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        @if(count($dayBookings) > 0)
                            <div class="timeline">
                                @foreach($dayBookings as $booking)
                                    <div class="d-flex align-items-center p-3 mb-3 rounded-3 {{ !$loop->last ? 'border-bottom' : '' }}" 
                                         style="background: rgba(23, 162, 184, 0.05); border: 1px solid rgba(23, 162, 184, 0.1) !important;">
                                        <div class="me-3">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                                 style="width: 50px; height: 50px; background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%); color: white;">
                                                <i class="fas fa-clock"></i>
                                            </div>
                                        </div>
                                        <div class="me-3" style="min-width: 100px;">
                                            <div class="fw-bold" style="color: #17a2b8;">{{ $booking->start_time }}</div>
                                            <div class="text-muted small">{{ $booking->end_time }}</div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-semibold" style="color: #1b1b1b;">{{ $booking->user->name }}</h6>
                                            <p class="mb-1 text-muted small">{{ $booking->product->name ?? $booking->service->name ?? 'Standard Booking' }}</p>
                                            @if($booking->notes)
                                                <small class="text-muted"><i class="fas fa-note-sticky me-1"></i>{{ $booking->notes }}</small>
                                            @endif
                                        </div>
                                        <div class="text-end">
                                            <span class="badge px-3 py-2" style="background: rgba(23, 162, 184, 0.2); color: #17a2b8; font-size: 0.8rem;">
                                                {{ $booking->lane->name ?? 'Lane TBD' }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-calendar-plus mb-3" style="font-size: 3rem; color: rgba(23, 162, 184, 0.3);"></i>
                                <h5 class="fw-bold mb-2" style="color: #1b1b1b;">No bookings scheduled</h5>
                                <p class="text-muted mb-0">This day has no scheduled bookings</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    @elseif($viewMode === 'weekly')
        {{-- Weekly View --}}
        <div class="row">
            <div class="col-12">
                <div class="card border-0" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                    <div class="card-header" style="background: transparent; border-bottom: 1px solid rgba(0, 0, 0, 0.05); padding: 1.5rem 1.5rem 0; border-radius: 1.25rem 1.25rem 0 0;">
                        <h5 class="mb-0 fw-bold d-flex align-items-center" style="color: #1b1b1b;">
                            <i class="fas fa-calendar-week me-2" style="color: #6f42c1;"></i>
                            Weekly Schedule
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table mb-0" style="border-collapse: separate; border-spacing: 0;">
                                <thead style="background: rgba(248, 249, 250, 0.8);">
                                    <tr>
                                        @foreach($weekDays as $day)
                                            <th class="text-center fw-bold py-3" style="width: 14.28%; color: #1b1b1b; border: none;">
                                                <div class="mb-1">{{ $day['date']->format('l') }}</div>
                                                <div class="text-muted small fw-medium">{{ $day['date']->format('M j') }}</div>
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        @foreach($weekDays as $day)
                                            <td class="align-top p-3" style="height: 320px; border: 1px solid rgba(0, 0, 0, 0.05); background: rgba(248, 249, 250, 0.3);">
                                                @foreach($day['bookings'] as $booking)
                                                    <div class="mb-2 p-2 rounded-3" style="background: linear-gradient(135deg, rgba(111, 66, 193, 0.1) 0%, rgba(232, 62, 140, 0.1) 100%); border: 1px solid rgba(111, 66, 193, 0.2); font-size: 0.8rem;">
                                                        <div class="fw-bold mb-1" style="color: #6f42c1;">{{ $booking->start_time }}</div>
                                                        <div class="text-truncate fw-medium" style="color: #1b1b1b;">{{ $booking->user->name }}</div>
                                                        <div class="text-muted small">{{ $booking->lane->name ?? 'Lane TBD' }}</div>
                                                    </div>
                                                @endforeach
                                                @if(count($day['bookings']) === 0)
                                                    <div class="text-center text-muted small mt-4">
                                                        <i class="fas fa-calendar-times mb-2" style="font-size: 1.2rem; opacity: 0.5;"></i>
                                                        <br><span style="font-size: 0.75rem;">No bookings</span>
                                                    </div>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @else
        {{-- Monthly View --}}
        <div class="row">
            <div class="col-12">
                <div class="card border-0" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                    <div class="card-header" style="background: transparent; border-bottom: 1px solid rgba(0, 0, 0, 0.05); padding: 1.5rem 1.5rem 0; border-radius: 1.25rem 1.25rem 0 0;">
                        <h5 class="mb-0 fw-bold d-flex align-items-center" style="color: #1b1b1b;">
                            <i class="fas fa-calendar-alt me-2" style="color: #ffc107;"></i>
                            Monthly Schedule
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table mb-0" style="border-collapse: separate; border-spacing: 0;">
                                <thead style="background: rgba(248, 249, 250, 0.8);">
                                    <tr>
                                        <th class="text-center fw-bold py-3" style="color: #1b1b1b; border: none;">Sunday</th>
                                        <th class="text-center fw-bold py-3" style="color: #1b1b1b; border: none;">Monday</th>
                                        <th class="text-center fw-bold py-3" style="color: #1b1b1b; border: none;">Tuesday</th>
                                        <th class="text-center fw-bold py-3" style="color: #1b1b1b; border: none;">Wednesday</th>
                                        <th class="text-center fw-bold py-3" style="color: #1b1b1b; border: none;">Thursday</th>
                                        <th class="text-center fw-bold py-3" style="color: #1b1b1b; border: none;">Friday</th>
                                        <th class="text-center fw-bold py-3" style="color: #1b1b1b; border: none;">Saturday</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($monthCalendar as $week)
                                        <tr>
                                            @foreach($week as $day)
                                                <td class="align-top p-3" style="height: 140px; width: 14.28%; border: 1px solid rgba(0, 0, 0, 0.05); background: {{ $day['isToday'] ? 'rgba(255, 193, 7, 0.1)' : 'rgba(248, 249, 250, 0.3)' }};">
                                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                                        <span class="fw-bold {{ $day['isCurrentMonth'] ? ($day['isToday'] ? 'text-warning' : 'text-dark') : 'text-muted' }}" style="{{ $day['isToday'] ? 'font-size: 1.1rem;' : '' }}">
                                                            {{ $day['date']->format('j') }}
                                                        </span>
                                                        @if(count($day['bookings']) > 0)
                                                            <span class="badge rounded-pill px-2 py-1" style="background: rgba(255, 193, 7, 0.2); color: #ffc107; font-size: 0.75rem;">{{ count($day['bookings']) }}</span>
                                                        @endif
                                                    </div>
                                                    
                                                    @if(count($day['bookings']) > 0)
                                                        <div style="font-size: 0.7rem;">
                                                            @foreach($day['bookings']->take(2) as $booking)
                                                                <div class="mb-1 p-1 rounded text-truncate" style="background: linear-gradient(135deg, rgba(255, 193, 7, 0.2) 0%, rgba(253, 126, 20, 0.2) 100%); color: #1b1b1b; border: 1px solid rgba(255, 193, 7, 0.3);">
                                                                    {{ $booking->start_time }}
                                                                </div>
                                                            @endforeach
                                                            @if(count($day['bookings']) > 2)
                                                                <div class="text-muted small fw-medium">+{{ count($day['bookings']) - 2 }} more</div>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <style>
    .timeline {
        position: relative;
    }

    .btn-group {
        display: flex;
        width: 100%;
    }

    .btn-group .btn {
        flex: 1;
        border: 2px solid rgba(255, 255, 255, 0.3);
        transition: all 0.3s ease;
    }

    .btn-group .btn:hover {
        transform: translateY(-2px);
        border-color: rgba(255, 255, 255, 0.6);
    }

    .btn-group .btn.btn-light {
        background: rgba(255, 255, 255, 0.95) !important;
        border-color: rgba(255, 255, 255, 0.8) !important;
        color: #1b1b1b !important;
        font-weight: 600;
    }

    .btn-group .btn.btn-outline-light {
        background: transparent;
        border-color: rgba(255, 255, 255, 0.4);
        color: rgba(255, 255, 255, 0.9);
    }

    .table td {
        vertical-align: top;
        border: none !important;
    }

    .table th {
        border: none !important;
    }

    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12) !important;
    }

    /* Mobile optimizations for employee schedule page */
    @media (max-width: 768px) {
        /* Header section mobile */
        .card-body.py-4.px-4 {
            padding: 1.5rem !important;
        }
        
        .card-body h2 {
            font-size: 1.5rem !important;
        }
        
        .card-body p {
            font-size: 1rem !important;
        }
        
        /* View mode buttons mobile */
        .btn-group {
            max-width: none !important;
        }
        
        .btn-group .btn {
            padding: 12px 8px !important;
            font-size: 0.85rem !important;
        }
        
        /* Disable hover effects on mobile */
        .btn-group .btn:hover,
        .card:hover,
        button:hover {
            transform: none !important;
            box-shadow: none !important;
        }
        
        /* Navigation controls mobile */
        .card-body.d-flex.justify-content-between {
            flex-direction: column !important;
            gap: 1rem;
            padding: 1.5rem !important;
        }
        
        .card-body.d-flex .btn {
            flex: 1;
            padding: 12px 16px !important;
            font-size: 0.9rem !important;
        }
        
        .text-center h4 {
            font-size: 1.2rem !important;
            margin-bottom: 12px !important;
        }
        
        .text-center .btn-sm {
            font-size: 0.8rem !important;
            padding: 8px 12px !important;
        }
        
        /* Today's schedule mobile */
        .col-md-6,
        .col-lg-4 {
            flex: 0 0 100% !important;
            max-width: 100% !important;
            margin-bottom: 1rem;
        }
        
        .card-body.p-3 {
            padding: 1rem !important;
        }
        
        .card-body.p-4 {
            padding: 1rem !important;
        }
        
        .card-header {
            padding: 1rem !important;
        }
        
        /* Daily view mobile */
        .timeline .d-flex {
            flex-direction: column !important;
            align-items: flex-start !important;
            padding: 1rem !important;
        }
        
        .timeline .me-3 {
            margin-right: 0 !important;
            margin-bottom: 1rem !important;
            align-self: center;
        }
        
        .timeline .rounded-circle {
            width: 40px !important;
            height: 40px !important;
        }
        
        .timeline .text-end {
            align-self: stretch !important;
            text-align: left !important;
            margin-top: 0.5rem;
        }
        
        /* Weekly view mobile - horizontal scroll */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        .table {
            min-width: 800px;
        }
        
        .table th {
            padding: 12px 8px !important;
            font-size: 0.8rem !important;
        }
        
        .table td {
            padding: 8px 6px !important;
            height: 200px !important;
        }
        
        .table .mb-2.p-2 {
            padding: 6px !important;
            margin-bottom: 6px !important;
            font-size: 0.7rem !important;
        }
        
        /* Monthly view mobile - horizontal scroll */
        .table {
            min-width: 700px;
        }
        
        .table td {
            height: 100px !important;
            padding: 6px 4px !important;
        }
        
        .table .d-flex.justify-content-between {
            margin-bottom: 4px !important;
        }
        
        .table .fw-bold {
            font-size: 0.9rem !important;
        }
        
        .table .badge {
            font-size: 0.65rem !important;
            padding: 2px 4px !important;
        }
        
        /* Booking cards mobile */
        .mb-1.p-1 {
            padding: 4px !important;
            margin-bottom: 4px !important;
            font-size: 0.65rem !important;
        }
        
        /* Empty states mobile */
        .text-center.py-5 {
            padding: 30px 15px !important;
        }
        
        .text-center .fa-3x,
        .text-center [style*="font-size: 3rem"] {
            font-size: 2rem !important;
        }
        
        .text-center h5 {
            font-size: 1.1rem !important;
        }
        
        /* Badge and small text mobile */
        .badge {
            font-size: 0.7rem !important;
            padding: 4px 8px !important;
        }
        
        .small {
            font-size: 0.75rem !important;
        }
    }

    /* Small mobile screens */
    @media (max-width: 576px) {
        .container-fluid {
            padding-left: 10px !important;
            padding-right: 10px !important;
        }
        
        /* Header even more compact */
        .card-body h2 {
            font-size: 1.25rem !important;
        }
        
        .card-body p {
            font-size: 0.9rem !important;
        }
        
        /* View buttons more compact */
        .btn-group .btn {
            padding: 10px 6px !important;
            font-size: 0.8rem !important;
        }
        
        /* Navigation more compact */
        .text-center h4 {
            font-size: 1.1rem !important;
        }
        
        /* Table more compact */
        .table {
            min-width: 600px;
        }
        
        .table td {
            height: 80px !important;
            padding: 4px 2px !important;
        }
        
        .table th {
            padding: 8px 4px !important;
            font-size: 0.75rem !important;
        }
        
        /* Timeline more compact */
        .timeline .rounded-circle {
            width: 35px !important;
            height: 35px !important;
        }
        
        /* Booking cards smaller */
        .card-body.p-3 {
            padding: 0.75rem !important;
        }
        
        .badge {
            font-size: 0.65rem !important;
            padding: 2px 6px !important;
        }
    }

    /* Extra small mobile screens */
    @media (max-width: 480px) {
        /* Most compact layout */
        .card-body h2 {
            font-size: 1.1rem !important;
        }
        
        /* View buttons stack vertically */
        .btn-group {
            flex-direction: column !important;
        }
        
        .btn-group .btn {
            border-radius: 1rem !important;
            margin-bottom: 0.5rem;
            font-size: 0.85rem !important;
        }
        
        /* Table most compact */
        .table {
            min-width: 500px;
        }
        
        .table td {
            height: 60px !important;
        }
        
        /* Timeline most compact */
        .timeline .rounded-circle {
            width: 30px !important;
            height: 30px !important;
        }
        
        .timeline .fw-bold {
            font-size: 0.9rem !important;
        }
    }

    /* Employee schedule-specific mobile optimizations */
    @media (max-width: 768px) {
        /* Better touch targets */
        .btn-group .btn {
            min-height: 44px;
            touch-action: manipulation;
        }
        
        /* Calendar responsiveness */
        .table-responsive {
            border-radius: 1rem;
            margin: 0 -4px;
        }
        
        /* Booking status colors maintained */
        .bg-success { background-color: rgba(40, 167, 69, 0.1) !important; }
        .bg-info { background-color: rgba(23, 162, 184, 0.1) !important; }
        .bg-warning { background-color: rgba(255, 193, 7, 0.1) !important; }
        .bg-primary { background-color: rgba(111, 66, 193, 0.1) !important; }
        
        /* Timeline responsiveness */
        .timeline {
            padding: 0;
        }
        
        .timeline .d-flex {
            border-radius: 1rem !important;
        }
        
        /* Today indicator preserved */
        .text-warning { color: #ffc107 !important; }
        .bg-warning { background-color: rgba(255, 193, 7, 0.1) !important; }
    }
    </style>
</div>