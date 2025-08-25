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
    </style>
</div>