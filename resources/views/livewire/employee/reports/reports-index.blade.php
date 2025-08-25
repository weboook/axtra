{{-- Employee Daily Reports Page --}}
<div class="container-fluid p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 fw-bold">Daily Reports</h1>
            <p class="text-muted mb-0">Performance data and analytics</p>
        </div>
        
        {{-- Report Type Toggle --}}
        <div class="btn-group" role="group">
            <button type="button" class="btn {{ $reportType === 'daily' ? 'btn-primary' : 'btn-outline-primary' }}" 
                    wire:click="setReportType('daily')">
                <i class="fas fa-calendar-day me-1"></i>Daily
            </button>
            <button type="button" class="btn {{ $reportType === 'weekly' ? 'btn-primary' : 'btn-outline-primary' }}" 
                    wire:click="setReportType('weekly')">
                <i class="fas fa-calendar-week me-1"></i>Weekly
            </button>
            <button type="button" class="btn {{ $reportType === 'monthly' ? 'btn-primary' : 'btn-outline-primary' }}" 
                    wire:click="setReportType('monthly')">
                <i class="fas fa-calendar-alt me-1"></i>Monthly
            </button>
        </div>
    </div>

    {{-- Date Selector --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card" style="border: none; border-radius: 12px; box-shadow: 0 4px 16px rgba(0,0,0,0.1);">
                <div class="card-body">
                    <label class="form-label fw-semibold">Select Date</label>
                    <input type="date" class="form-control" wire:model.live="selectedDate">
                    <small class="text-muted mt-1">Showing data for: {{ $selectedDateFormatted }}</small>
                </div>
            </div>
        </div>
    </div>

    @if($reportType === 'daily')
        {{-- Daily Report View --}}
        
        {{-- Booking Statistics --}}
        <div class="row g-3 mb-4">
            <div class="col-md-2 col-6">
                <div class="card text-center h-100" style="border: none; border-radius: 12px; background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%);">
                    <div class="card-body">
                        <h3 class="text-white mb-1">{{ $bookingStats['total_bookings'] }}</h3>
                        <small class="text-white opacity-75">Total Bookings</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-6">
                <div class="card text-center h-100" style="border: none; border-radius: 12px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                    <div class="card-body">
                        <h3 class="text-white mb-1">{{ $bookingStats['completed_bookings'] }}</h3>
                        <small class="text-white opacity-75">Completed</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-6">
                <div class="card text-center h-100" style="border: none; border-radius: 12px; background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);">
                    <div class="card-body">
                        <h3 class="text-white mb-1">{{ $bookingStats['no_shows'] }}</h3>
                        <small class="text-white opacity-75">No Shows</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-6">
                <div class="card text-center h-100" style="border: none; border-radius: 12px; background: linear-gradient(135deg, #6610f2 0%, #6f42c1 100%);">
                    <div class="card-body">
                        <h3 class="text-white mb-1">{{ number_format($bookingStats['revenue'], 0) }}</h3>
                        <small class="text-white opacity-75">CHF Revenue</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-6">
                <div class="card text-center h-100" style="border: none; border-radius: 12px; background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);">
                    <div class="card-body">
                        <h3 class="text-white mb-1">{{ number_format($bookingStats['avg_duration'], 0) }}</h3>
                        <small class="text-white opacity-75">Avg Duration (min)</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- Lane Usage --}}
            <div class="col-lg-8">
                <div class="card h-100" style="border: none; border-radius: 16px; box-shadow: 0 8px 32px rgba(0,0,0,0.1);">
                    <div class="card-header border-0" style="background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%); border-radius: 16px 16px 0 0;">
                        <h5 class="mb-0 text-white">
                            <i class="fas fa-chart-bar me-2"></i>
                            Lane Usage Analytics
                        </h5>
                    </div>
                    <div class="card-body">
                        @if(count($laneUsage) > 0)
                            @foreach($laneUsage as $usage)
                                <div class="d-flex align-items-center mb-3 p-3 rounded-3" style="background-color: rgba(23, 162, 184, 0.05);">
                                    <div class="me-3">
                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                            <i class="fas fa-bowling-ball"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="mb-0">{{ $usage['lane']->name }}</h6>
                                            <div class="text-end">
                                                <span class="fw-bold text-primary">{{ $usage['bookings_count'] }} bookings</span>
                                                <br>
                                                <small class="text-muted">{{ $usage['utilization_rate'] }}% utilized</small>
                                            </div>
                                        </div>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $usage['utilization_rate'] }}%"></div>
                                        </div>
                                        <small class="text-muted">{{ $usage['total_minutes'] }} total minutes</small>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-chart-bar text-muted" style="font-size: 3rem;"></i>
                                <p class="text-muted mt-2 mb-0">No lane usage data for this date</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Maintenance Issues --}}
            <div class="col-lg-4">
                <div class="card h-100" style="border: none; border-radius: 16px; box-shadow: 0 8px 32px rgba(0,0,0,0.1);">
                    <div class="card-header border-0" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); border-radius: 16px 16px 0 0;">
                        <h5 class="mb-0 text-white">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Maintenance Issues
                        </h5>
                    </div>
                    <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                        @if(count($maintenanceIssues) > 0)
                            @foreach($maintenanceIssues as $issue)
                                <div class="d-flex align-items-start p-3 mb-3 rounded-3" style="background-color: rgba(255, 193, 7, 0.1);">
                                    <div class="me-3">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background-color: 
                                            @if($issue->severity === 'critical') #dc3545
                                            @elseif($issue->severity === 'high') #fd7e14
                                            @elseif($issue->severity === 'medium') #ffc107
                                            @else #28a745
                                            @endif
                                        ;">
                                            <i class="fas fa-wrench text-white" style="font-size: 0.7rem;"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 small">{{ $issue->lane->name ?? 'Unknown Lane' }}</h6>
                                        <p class="mb-1 text-muted small">{{ Str::limit($issue->description, 50) }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge 
                                                @if($issue->severity === 'critical') bg-danger
                                                @elseif($issue->severity === 'high') bg-warning
                                                @elseif($issue->severity === 'medium') bg-info
                                                @else bg-success
                                                @endif
                                            " style="font-size: 0.65rem;">
                                                {{ ucfirst($issue->severity) }}
                                            </span>
                                            <small class="text-muted">{{ $issue->created_at->format('H:i') }}</small>
                                        </div>
                                        @if($issue->cost)
                                            <div class="mt-1">
                                                <span class="badge bg-info" style="font-size: 0.65rem;">CHF {{ number_format($issue->cost, 2) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-check-circle text-success" style="font-size: 2rem;"></i>
                                <p class="text-muted mt-2 mb-0">No maintenance issues today</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    @elseif($reportType === 'weekly')
        {{-- Weekly Report View --}}
        <div class="row g-3 mb-4">
            <div class="col-md-2">
                <div class="card text-center h-100" style="border: none; border-radius: 12px; background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%);">
                    <div class="card-body">
                        <h3 class="text-white mb-1">{{ $weeklyStats['total_bookings'] }}</h3>
                        <small class="text-white opacity-75">Total Bookings</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card text-center h-100" style="border: none; border-radius: 12px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                    <div class="card-body">
                        <h3 class="text-white mb-1">{{ $weeklyStats['completed_bookings'] }}</h3>
                        <small class="text-white opacity-75">Completed</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card text-center h-100" style="border: none; border-radius: 12px; background: linear-gradient(135deg, #6610f2 0%, #6f42c1 100%);">
                    <div class="card-body">
                        <h3 class="text-white mb-1">{{ number_format($weeklyStats['total_revenue'], 0) }}</h3>
                        <small class="text-white opacity-75">CHF Revenue</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card text-center h-100" style="border: none; border-radius: 12px; background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);">
                    <div class="card-body">
                        <h3 class="text-white mb-1">{{ $weeklyStats['maintenance_issues'] }}</h3>
                        <small class="text-white opacity-75">Maintenance Issues</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100" style="border: none; border-radius: 12px; box-shadow: 0 4px 16px rgba(0,0,0,0.1);">
                    <div class="card-body text-center">
                        <h6 class="mb-2">Peak Day</h6>
                        <h4 class="text-primary mb-0">{{ $weeklyStats['peak_day'] ?? 'N/A' }}</h4>
                    </div>
                </div>
            </div>
        </div>

    @else
        {{-- Monthly Report View --}}
        <div class="row g-3 mb-4">
            <div class="col-md-2">
                <div class="card text-center h-100" style="border: none; border-radius: 12px; background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%);">
                    <div class="card-body">
                        <h3 class="text-white mb-1">{{ $monthlyStats['total_bookings'] }}</h3>
                        <small class="text-white opacity-75">Total Bookings</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card text-center h-100" style="border: none; border-radius: 12px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                    <div class="card-body">
                        <h3 class="text-white mb-1">{{ $monthlyStats['completed_bookings'] }}</h3>
                        <small class="text-white opacity-75">Completed</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card text-center h-100" style="border: none; border-radius: 12px; background: linear-gradient(135deg, #6610f2 0%, #6f42c1 100%);">
                    <div class="card-body">
                        <h3 class="text-white mb-1">{{ number_format($monthlyStats['total_revenue'], 0) }}</h3>
                        <small class="text-white opacity-75">CHF Revenue</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card text-center h-100" style="border: none; border-radius: 12px; background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);">
                    <div class="card-body">
                        <h3 class="text-white mb-1">{{ number_format($monthlyStats['maintenance_costs'], 0) }}</h3>
                        <small class="text-white opacity-75">CHF Maintenance</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100" style="border: none; border-radius: 12px; box-shadow: 0 4px 16px rgba(0,0,0,0.1);">
                    <div class="card-body text-center">
                        <h6 class="mb-2">Busiest Week</h6>
                        <h4 class="text-primary mb-0">Week {{ $monthlyStats['busiest_week'] ?? 'N/A' }}</h4>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
.btn-group .btn {
    border-radius: 8px;
}

.btn-group .btn:not(:first-child):not(:last-child) {
    border-radius: 0;
}

.btn-group .btn:first-child {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}

.btn-group .btn:last-child {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
}

.progress {
    border-radius: 4px;
}

::-webkit-scrollbar {
    width: 6px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}
</style>