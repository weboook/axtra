{{-- Employee Reports Page --}}
<div>
    {{-- Dashboard Welcome Section --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 1.5rem; box-shadow: 0 20px 60px rgba(102, 126, 234, 0.3);">
                <div class="card-body py-4 px-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h2 class="mb-2 fw-bold">Performance Reports</h2>
                            <p class="mb-3 opacity-90" style="font-size: 1.1rem;">Comprehensive analytics and performance insights</p>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-chart-line me-2"></i>
                                <span>Track daily, weekly, and monthly performance metrics</span>
                            </div>
                        </div>
                        <div class="d-none d-md-block">
                            <i class="fas fa-chart-bar" style="font-size: 4rem; opacity: 0.3;"></i>
                        </div>
                    </div>
                    
                    {{-- Report Type Toggle in Banner --}}
                    <div class="mt-4 pt-3" style="border-top: 1px solid rgba(255, 255, 255, 0.2);">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="opacity-90" style="font-size: 0.9rem;">Select Report Period:</span>
                            <div class="btn-group" role="group">
                                <button type="button" 
                                        class="btn {{ $reportType === 'daily' ? 'btn-light' : 'btn-outline-light' }} btn-sm px-3" 
                                        wire:click="setReportType('daily')"
                                        style="border-radius: 8px 0 0 8px; font-weight: 600;">
                                    <i class="fas fa-calendar-day me-1"></i>Daily
                                </button>
                                <button type="button" 
                                        class="btn {{ $reportType === 'weekly' ? 'btn-light' : 'btn-outline-light' }} btn-sm px-3" 
                                        wire:click="setReportType('weekly')"
                                        style="border-radius: 0; font-weight: 600;">
                                    <i class="fas fa-calendar-week me-1"></i>Weekly
                                </button>
                                <button type="button" 
                                        class="btn {{ $reportType === 'monthly' ? 'btn-light' : 'btn-outline-light' }} btn-sm px-3" 
                                        wire:click="setReportType('monthly')"
                                        style="border-radius: 0 8px 8px 0; font-weight: 600;">
                                    <i class="fas fa-calendar-alt me-1"></i>Monthly
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Date Selector --}}
    <div class="row mb-4">
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 h-100" 
                 style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); transition: all 0.3s ease;"
                 onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 20px 40px rgba(0, 0, 0, 0.15)'"
                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(0, 0, 0, 0.08)'">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 50px; height: 50px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <i class="fas fa-calendar-alt text-white"></i>
                            </div>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold text-dark">Date Selection</h6>
                            <small class="text-muted">Choose report period</small>
                        </div>
                    </div>
                    <input type="date" 
                           class="form-control" 
                           wire:model.live="selectedDate"
                           style="border: 2px solid #e9ecef; border-radius: 0.75rem; padding: 0.75rem; transition: all 0.3s ease;"
                           onfocus="this.style.borderColor='#667eea'; this.style.boxShadow='0 0 0 0.2rem rgba(102, 126, 234, 0.25)'"
                           onblur="this.style.borderColor='#e9ecef'; this.style.boxShadow='none'">
                    <small class="text-muted mt-2 d-block">
                        <i class="fas fa-info-circle me-1"></i>
                        Showing data for: <span class="fw-semibold">{{ $selectedDateFormatted }}</span>
                    </small>
                </div>
            </div>
        </div>
    </div>

    @if($reportType === 'daily')
        {{-- Daily Report View --}}
        
        {{-- Booking Statistics --}}
        <div class="row g-4 mb-4">
            <div class="col-xl-2 col-lg-4 col-md-6">
                <div class="card border-0 text-center h-100" 
                     style="background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%); border-radius: 1.25rem; transition: all 0.3s ease; cursor: pointer;"
                     onmouseover="this.style.transform='translateY(-8px) scale(1.02)'; this.style.boxShadow='0 20px 40px rgba(23, 162, 184, 0.3)'"
                     onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 10px 30px rgba(23, 162, 184, 0.15)'">
                    <div class="card-body py-4">
                        <div class="mb-3">
                            <i class="fas fa-calendar-check" style="font-size: 2rem; color: white; opacity: 0.9;"></i>
                        </div>
                        <h2 class="text-white mb-2 fw-bold">{{ $bookingStats['total_bookings'] }}</h2>
                        <p class="text-white mb-0" style="opacity: 0.85; font-weight: 500;">Total Bookings</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-4 col-md-6">
                <div class="card border-0 text-center h-100" 
                     style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border-radius: 1.25rem; transition: all 0.3s ease; cursor: pointer;"
                     onmouseover="this.style.transform='translateY(-8px) scale(1.02)'; this.style.boxShadow='0 20px 40px rgba(40, 167, 69, 0.3)'"
                     onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 10px 30px rgba(40, 167, 69, 0.15)'">
                    <div class="card-body py-4">
                        <div class="mb-3">
                            <i class="fas fa-check-circle" style="font-size: 2rem; color: white; opacity: 0.9;"></i>
                        </div>
                        <h2 class="text-white mb-2 fw-bold">{{ $bookingStats['completed_bookings'] }}</h2>
                        <p class="text-white mb-0" style="opacity: 0.85; font-weight: 500;">Completed</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-4 col-md-6">
                <div class="card border-0 text-center h-100" 
                     style="background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%); border-radius: 1.25rem; transition: all 0.3s ease; cursor: pointer;"
                     onmouseover="this.style.transform='translateY(-8px) scale(1.02)'; this.style.boxShadow='0 20px 40px rgba(220, 53, 69, 0.3)'"
                     onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 10px 30px rgba(220, 53, 69, 0.15)'">
                    <div class="card-body py-4">
                        <div class="mb-3">
                            <i class="fas fa-user-times" style="font-size: 2rem; color: white; opacity: 0.9;"></i>
                        </div>
                        <h2 class="text-white mb-2 fw-bold">{{ $bookingStats['no_shows'] }}</h2>
                        <p class="text-white mb-0" style="opacity: 0.85; font-weight: 500;">No Shows</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-4 col-md-6">
                <div class="card border-0 text-center h-100" 
                     style="background: linear-gradient(135deg, #6610f2 0%, #6f42c1 100%); border-radius: 1.25rem; transition: all 0.3s ease; cursor: pointer;"
                     onmouseover="this.style.transform='translateY(-8px) scale(1.02)'; this.style.boxShadow='0 20px 40px rgba(102, 16, 242, 0.3)'"
                     onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 10px 30px rgba(102, 16, 242, 0.15)'">
                    <div class="card-body py-4">
                        <div class="mb-3">
                            <i class="fas fa-coins" style="font-size: 2rem; color: white; opacity: 0.9;"></i>
                        </div>
                        <h2 class="text-white mb-2 fw-bold">{{ number_format($bookingStats['revenue'], 0) }}</h2>
                        <p class="text-white mb-0" style="opacity: 0.85; font-weight: 500;">CHF Revenue</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-4 col-md-6">
                <div class="card border-0 text-center h-100" 
                     style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); border-radius: 1.25rem; transition: all 0.3s ease; cursor: pointer;"
                     onmouseover="this.style.transform='translateY(-8px) scale(1.02)'; this.style.boxShadow='0 20px 40px rgba(255, 193, 7, 0.3)'"
                     onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 10px 30px rgba(255, 193, 7, 0.15)'">
                    <div class="card-body py-4">
                        <div class="mb-3">
                            <i class="fas fa-clock" style="font-size: 2rem; color: white; opacity: 0.9;"></i>
                        </div>
                        <h2 class="text-white mb-2 fw-bold">{{ number_format($bookingStats['avg_duration'], 0) }}</h2>
                        <p class="text-white mb-0" style="opacity: 0.85; font-weight: 500;">Avg Duration (min)</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- Lane Usage --}}
            <div class="col-lg-8">
                <div class="card border-0 h-100" 
                     style="background: white; border-radius: 1.5rem; box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1); transition: all 0.3s ease;"
                     onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 20px 40px rgba(0, 0, 0, 0.15)'"
                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 15px 35px rgba(0, 0, 0, 0.1)'">
                    <div class="card-header border-0 p-0" 
                         style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 1.5rem 1.5rem 0 0; padding: 1.5rem !important;">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px);">
                                    <i class="fas fa-chart-bar text-white" style="font-size: 1.2rem;"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="mb-0 text-white fw-bold">Lane Usage Analytics</h5>
                                <p class="mb-0 text-white" style="opacity: 0.8; font-size: 0.9rem;">Performance metrics by lane</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        @if(count($laneUsage) > 0)
                            @foreach($laneUsage as $usage)
                                <div class="d-flex align-items-center mb-4 p-4 rounded-4" 
                                     style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%); transition: all 0.3s ease; cursor: pointer;"
                                     onmouseover="this.style.background='linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%)'; this.style.transform='translateX(5px)'"
                                     onmouseout="this.style.background='linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%)'; this.style.transform='translateX(0)'">
                                    <div class="me-4">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                             style="width: 60px; height: 60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);">
                                            <i class="fas fa-bowling-ball text-white" style="font-size: 1.3rem;"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div>
                                                <h6 class="mb-1 fw-bold text-dark">{{ $usage['lane']->name }}</h6>
                                                <small class="text-muted">{{ $usage['total_minutes'] }} total minutes</small>
                                            </div>
                                            <div class="text-end">
                                                <span class="badge" 
                                                      style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); font-size: 0.8rem; padding: 0.4rem 0.8rem;">
                                                    {{ $usage['bookings_count'] }} bookings
                                                </span>
                                                <div class="mt-1">
                                                    <small class="fw-semibold text-primary">{{ $usage['utilization_rate'] }}% utilized</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="progress" style="height: 10px; border-radius: 10px; background-color: #e9ecef;">
                                            <div class="progress-bar" 
                                                 role="progressbar" 
                                                 style="width: {{ $usage['utilization_rate'] }}%; background: linear-gradient(90deg, #667eea 0%, #764ba2 100%); border-radius: 10px; transition: width 1s ease-in-out;"
                                                 aria-valuenow="{{ $usage['utilization_rate'] }}" 
                                                 aria-valuemin="0" 
                                                 aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="fas fa-chart-bar" style="font-size: 4rem; color: #e9ecef;"></i>
                                </div>
                                <h6 class="text-muted mb-2">No Usage Data Available</h6>
                                <p class="text-muted mb-0">No lane usage data found for the selected date period.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Maintenance Issues --}}
            <div class="col-lg-4">
                <div class="card border-0 h-100" 
                     style="background: white; border-radius: 1.5rem; box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1); transition: all 0.3s ease;"
                     onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 20px 40px rgba(0, 0, 0, 0.15)'"
                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 15px 35px rgba(0, 0, 0, 0.1)'">
                    <div class="card-header border-0 p-0" 
                         style="background: linear-gradient(135deg, #ff6b6b 0%, #feca57 100%); border-radius: 1.5rem 1.5rem 0 0; padding: 1.5rem !important;">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px);">
                                    <i class="fas fa-exclamation-triangle text-white" style="font-size: 1.2rem;"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="mb-0 text-white fw-bold">Maintenance Issues</h5>
                                <p class="mb-0 text-white" style="opacity: 0.8; font-size: 0.9rem;">Active maintenance reports</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4" style="max-height: 500px; overflow-y: auto;">
                        @if(count($maintenanceIssues) > 0)
                            @foreach($maintenanceIssues as $issue)
                                <div class="d-flex align-items-start p-3 mb-3 rounded-4" 
                                     style="background: linear-gradient(135deg, rgba(255, 107, 107, 0.05) 0%, rgba(254, 202, 87, 0.05) 100%); border: 1px solid rgba(255, 107, 107, 0.1); transition: all 0.3s ease; cursor: pointer;"
                                     onmouseover="this.style.background='linear-gradient(135deg, rgba(255, 107, 107, 0.1) 0%, rgba(254, 202, 87, 0.1) 100%)'; this.style.borderColor='rgba(255, 107, 107, 0.2)'; this.style.transform='translateX(3px)'"
                                     onmouseout="this.style.background='linear-gradient(135deg, rgba(255, 107, 107, 0.05) 0%, rgba(254, 202, 87, 0.05) 100%)'; this.style.borderColor='rgba(255, 107, 107, 0.1)'; this.style.transform='translateX(0)'">
                                    <div class="me-3">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                             style="width: 45px; height: 45px; background: 
                                            @if($issue->severity === 'critical') linear-gradient(135deg, #dc3545 0%, #c82333 100%)
                                            @elseif($issue->severity === 'high') linear-gradient(135deg, #fd7e14 0%, #e55a00 100%)
                                            @elseif($issue->severity === 'medium') linear-gradient(135deg, #ffc107 0%, #e0a800 100%)
                                            @else linear-gradient(135deg, #28a745 0%, #1e7e34 100%)
                                            @endif
                                            ; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);">
                                            <i class="fas fa-tools text-white" style="font-size: 0.9rem;"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h6 class="mb-1 fw-bold text-dark">{{ $issue->lane->name ?? 'Unknown Lane' }}</h6>
                                                <p class="mb-2 text-muted" style="font-size: 0.9rem; line-height: 1.4;">{{ Str::limit($issue->description, 60) }}</p>
                                            </div>
                                            <small class="text-muted" style="font-size: 0.8rem;">{{ $issue->created_at->format('H:i') }}</small>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                            <div class="d-flex gap-2">
                                                <span class="badge" 
                                                      style="background: 
                                                    @if($issue->severity === 'critical') linear-gradient(135deg, #dc3545 0%, #c82333 100%)
                                                    @elseif($issue->severity === 'high') linear-gradient(135deg, #fd7e14 0%, #e55a00 100%)
                                                    @elseif($issue->severity === 'medium') linear-gradient(135deg, #ffc107 0%, #e0a800 100%)
                                                    @else linear-gradient(135deg, #28a745 0%, #1e7e34 100%)
                                                    @endif
                                                    ; font-size: 0.7rem; padding: 0.3rem 0.6rem; border-radius: 0.5rem;">
                                                    {{ ucfirst($issue->severity) }}
                                                </span>
                                                @if($issue->cost)
                                                    <span class="badge" 
                                                          style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); font-size: 0.7rem; padding: 0.3rem 0.6rem; border-radius: 0.5rem;">
                                                        CHF {{ number_format($issue->cost, 2) }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="fas fa-check-circle" style="font-size: 4rem; color: #28a745;"></i>
                                </div>
                                <h6 class="text-success mb-2 fw-bold">All Clear!</h6>
                                <p class="text-muted mb-0">No maintenance issues reported for today.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    @elseif($reportType === 'weekly')
        {{-- Weekly Report View --}}
        <div class="row g-4 mb-4">
            <div class="col-xl-2 col-lg-4 col-md-6">
                <div class="card border-0 text-center h-100" 
                     style="background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%); border-radius: 1.25rem; transition: all 0.3s ease; cursor: pointer;"
                     onmouseover="this.style.transform='translateY(-8px) scale(1.02)'; this.style.boxShadow='0 20px 40px rgba(23, 162, 184, 0.3)'"
                     onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 10px 30px rgba(23, 162, 184, 0.15)'">
                    <div class="card-body py-4">
                        <div class="mb-3">
                            <i class="fas fa-calendar-week" style="font-size: 2rem; color: white; opacity: 0.9;"></i>
                        </div>
                        <h2 class="text-white mb-2 fw-bold">{{ $weeklyStats['total_bookings'] }}</h2>
                        <p class="text-white mb-0" style="opacity: 0.85; font-weight: 500;">Total Bookings</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-4 col-md-6">
                <div class="card border-0 text-center h-100" 
                     style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border-radius: 1.25rem; transition: all 0.3s ease; cursor: pointer;"
                     onmouseover="this.style.transform='translateY(-8px) scale(1.02)'; this.style.boxShadow='0 20px 40px rgba(40, 167, 69, 0.3)'"
                     onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 10px 30px rgba(40, 167, 69, 0.15)'">
                    <div class="card-body py-4">
                        <div class="mb-3">
                            <i class="fas fa-check-circle" style="font-size: 2rem; color: white; opacity: 0.9;"></i>
                        </div>
                        <h2 class="text-white mb-2 fw-bold">{{ $weeklyStats['completed_bookings'] }}</h2>
                        <p class="text-white mb-0" style="opacity: 0.85; font-weight: 500;">Completed</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-4 col-md-6">
                <div class="card border-0 text-center h-100" 
                     style="background: linear-gradient(135deg, #6610f2 0%, #6f42c1 100%); border-radius: 1.25rem; transition: all 0.3s ease; cursor: pointer;"
                     onmouseover="this.style.transform='translateY(-8px) scale(1.02)'; this.style.boxShadow='0 20px 40px rgba(102, 16, 242, 0.3)'"
                     onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 10px 30px rgba(102, 16, 242, 0.15)'">
                    <div class="card-body py-4">
                        <div class="mb-3">
                            <i class="fas fa-coins" style="font-size: 2rem; color: white; opacity: 0.9;"></i>
                        </div>
                        <h2 class="text-white mb-2 fw-bold">{{ number_format($weeklyStats['total_revenue'], 0) }}</h2>
                        <p class="text-white mb-0" style="opacity: 0.85; font-weight: 500;">CHF Revenue</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-4 col-md-6">
                <div class="card border-0 text-center h-100" 
                     style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); border-radius: 1.25rem; transition: all 0.3s ease; cursor: pointer;"
                     onmouseover="this.style.transform='translateY(-8px) scale(1.02)'; this.style.boxShadow='0 20px 40px rgba(255, 193, 7, 0.3)'"
                     onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 10px 30px rgba(255, 193, 7, 0.15)'">
                    <div class="card-body py-4">
                        <div class="mb-3">
                            <i class="fas fa-exclamation-triangle" style="font-size: 2rem; color: white; opacity: 0.9;"></i>
                        </div>
                        <h2 class="text-white mb-2 fw-bold">{{ $weeklyStats['maintenance_issues'] }}</h2>
                        <p class="text-white mb-0" style="opacity: 0.85; font-weight: 500;">Maintenance Issues</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-8">
                <div class="card border-0 h-100" 
                     style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); transition: all 0.3s ease;"
                     onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 20px 40px rgba(0, 0, 0, 0.15)'"
                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(0, 0, 0, 0.08)'">
                    <div class="card-body text-center py-4">
                        <div class="mb-3">
                            <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center" 
                                 style="width: 70px; height: 70px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <i class="fas fa-chart-line text-white" style="font-size: 1.5rem;"></i>
                            </div>
                        </div>
                        <h6 class="mb-2 text-muted fw-semibold">Peak Performance Day</h6>
                        <h3 class="mb-0 fw-bold" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                            {{ $weeklyStats['peak_day'] ?? 'N/A' }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Weekly Details Section --}}
        <div class="row g-4">
            {{-- Weekly Performance Chart --}}
            <div class="col-lg-8">
                <div class="card border-0 h-100" 
                     style="background: white; border-radius: 1.5rem; box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1); transition: all 0.3s ease;"
                     onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 20px 40px rgba(0, 0, 0, 0.15)'"
                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 15px 35px rgba(0, 0, 0, 0.1)'">
                    <div class="card-header border-0 p-0" 
                         style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 1.5rem 1.5rem 0 0; padding: 1.5rem !important;">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px);">
                                    <i class="fas fa-chart-area text-white" style="font-size: 1.2rem;"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="mb-0 text-white fw-bold">Weekly Performance Overview</h5>
                                <p class="mb-0 text-white" style="opacity: 0.8; font-size: 0.9rem;">7-day activity breakdown</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-chart-area" style="font-size: 4rem; color: #e9ecef;"></i>
                            </div>
                            <h6 class="text-muted mb-2">Weekly Analytics Coming Soon</h6>
                            <p class="text-muted mb-0">Detailed weekly performance charts will be available here.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Weekly Summary --}}
            <div class="col-lg-4">
                <div class="card border-0 h-100" 
                     style="background: white; border-radius: 1.5rem; box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1); transition: all 0.3s ease;"
                     onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 20px 40px rgba(0, 0, 0, 0.15)'"
                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 15px 35px rgba(0, 0, 0, 0.1)'">
                    <div class="card-header border-0 p-0" 
                         style="background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%); border-radius: 1.5rem 1.5rem 0 0; padding: 1.5rem !important;">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px);">
                                    <i class="fas fa-list-alt text-white" style="font-size: 1.2rem;"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="mb-0 text-white fw-bold">Weekly Summary</h5>
                                <p class="mb-0 text-white" style="opacity: 0.8; font-size: 0.9rem;">Key insights and metrics</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-clipboard-list" style="font-size: 4rem; color: #17a2b8;"></i>
                            </div>
                            <h6 class="text-info mb-2 fw-bold">Week Overview</h6>
                            <p class="text-muted mb-0">Detailed weekly breakdown and insights will appear here.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @else
        {{-- Monthly Report View --}}
        <div class="row g-4 mb-4">
            <div class="col-xl-2 col-lg-4 col-md-6">
                <div class="card border-0 text-center h-100" 
                     style="background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%); border-radius: 1.25rem; transition: all 0.3s ease; cursor: pointer;"
                     onmouseover="this.style.transform='translateY(-8px) scale(1.02)'; this.style.boxShadow='0 20px 40px rgba(23, 162, 184, 0.3)'"
                     onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 10px 30px rgba(23, 162, 184, 0.15)'">
                    <div class="card-body py-4">
                        <div class="mb-3">
                            <i class="fas fa-calendar-alt" style="font-size: 2rem; color: white; opacity: 0.9;"></i>
                        </div>
                        <h2 class="text-white mb-2 fw-bold">{{ $monthlyStats['total_bookings'] }}</h2>
                        <p class="text-white mb-0" style="opacity: 0.85; font-weight: 500;">Total Bookings</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-4 col-md-6">
                <div class="card border-0 text-center h-100" 
                     style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border-radius: 1.25rem; transition: all 0.3s ease; cursor: pointer;"
                     onmouseover="this.style.transform='translateY(-8px) scale(1.02)'; this.style.boxShadow='0 20px 40px rgba(40, 167, 69, 0.3)'"
                     onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 10px 30px rgba(40, 167, 69, 0.15)'">
                    <div class="card-body py-4">
                        <div class="mb-3">
                            <i class="fas fa-check-circle" style="font-size: 2rem; color: white; opacity: 0.9;"></i>
                        </div>
                        <h2 class="text-white mb-2 fw-bold">{{ $monthlyStats['completed_bookings'] }}</h2>
                        <p class="text-white mb-0" style="opacity: 0.85; font-weight: 500;">Completed</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-4 col-md-6">
                <div class="card border-0 text-center h-100" 
                     style="background: linear-gradient(135deg, #6610f2 0%, #6f42c1 100%); border-radius: 1.25rem; transition: all 0.3s ease; cursor: pointer;"
                     onmouseover="this.style.transform='translateY(-8px) scale(1.02)'; this.style.boxShadow='0 20px 40px rgba(102, 16, 242, 0.3)'"
                     onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 10px 30px rgba(102, 16, 242, 0.15)'">
                    <div class="card-body py-4">
                        <div class="mb-3">
                            <i class="fas fa-coins" style="font-size: 2rem; color: white; opacity: 0.9;"></i>
                        </div>
                        <h2 class="text-white mb-2 fw-bold">{{ number_format($monthlyStats['total_revenue'], 0) }}</h2>
                        <p class="text-white mb-0" style="opacity: 0.85; font-weight: 500;">CHF Revenue</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-4 col-md-6">
                <div class="card border-0 text-center h-100" 
                     style="background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%); border-radius: 1.25rem; transition: all 0.3s ease; cursor: pointer;"
                     onmouseover="this.style.transform='translateY(-8px) scale(1.02)'; this.style.boxShadow='0 20px 40px rgba(220, 53, 69, 0.3)'"
                     onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 10px 30px rgba(220, 53, 69, 0.15)'">
                    <div class="card-body py-4">
                        <div class="mb-3">
                            <i class="fas fa-tools" style="font-size: 2rem; color: white; opacity: 0.9;"></i>
                        </div>
                        <h2 class="text-white mb-2 fw-bold">{{ number_format($monthlyStats['maintenance_costs'], 0) }}</h2>
                        <p class="text-white mb-0" style="opacity: 0.85; font-weight: 500;">CHF Maintenance</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-8">
                <div class="card border-0 h-100" 
                     style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); transition: all 0.3s ease;"
                     onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 20px 40px rgba(0, 0, 0, 0.15)'"
                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(0, 0, 0, 0.08)'">
                    <div class="card-body text-center py-4">
                        <div class="mb-3">
                            <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center" 
                                 style="width: 70px; height: 70px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <i class="fas fa-trophy text-white" style="font-size: 1.5rem;"></i>
                            </div>
                        </div>
                        <h6 class="mb-2 text-muted fw-semibold">Busiest Period</h6>
                        <h3 class="mb-0 fw-bold" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                            Week {{ $monthlyStats['busiest_week'] ?? 'N/A' }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Monthly Details Section --}}
        <div class="row g-4">
            {{-- Monthly Trend Analysis --}}
            <div class="col-lg-8">
                <div class="card border-0 h-100" 
                     style="background: white; border-radius: 1.5rem; box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1); transition: all 0.3s ease;"
                     onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 20px 40px rgba(0, 0, 0, 0.15)'"
                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 15px 35px rgba(0, 0, 0, 0.1)'">
                    <div class="card-header border-0 p-0" 
                         style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 1.5rem 1.5rem 0 0; padding: 1.5rem !important;">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px);">
                                    <i class="fas fa-chart-line text-white" style="font-size: 1.2rem;"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="mb-0 text-white fw-bold">Monthly Trend Analysis</h5>
                                <p class="mb-0 text-white" style="opacity: 0.8; font-size: 0.9rem;">30-day performance tracking</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-chart-line" style="font-size: 4rem; color: #e9ecef;"></i>
                            </div>
                            <h6 class="text-muted mb-2">Monthly Analytics Coming Soon</h6>
                            <p class="text-muted mb-0">Comprehensive monthly trend analysis and forecasting will be available here.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Monthly Insights --}}
            <div class="col-lg-4">
                <div class="card border-0 h-100" 
                     style="background: white; border-radius: 1.5rem; box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1); transition: all 0.3s ease;"
                     onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 20px 40px rgba(0, 0, 0, 0.15)'"
                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 15px 35px rgba(0, 0, 0, 0.1)'">
                    <div class="card-header border-0 p-0" 
                         style="background: linear-gradient(135deg, #6610f2 0%, #6f42c1 100%); border-radius: 1.5rem 1.5rem 0 0; padding: 1.5rem !important;">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px);">
                                    <i class="fas fa-lightbulb text-white" style="font-size: 1.2rem;"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="mb-0 text-white fw-bold">Monthly Insights</h5>
                                <p class="mb-0 text-white" style="opacity: 0.8; font-size: 0.9rem;">Key takeaways and recommendations</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-brain" style="font-size: 4rem; color: #6610f2;"></i>
                            </div>
                            <h6 class="text-primary mb-2 fw-bold">Smart Insights</h6>
                            <p class="text-muted mb-0">AI-powered insights and recommendations based on monthly patterns.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <style>
    /* Modern button group styling */
    .btn-group .btn {
        border: 2px solid rgba(255, 255, 255, 0.2);
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-group .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .btn-group .btn:not(:first-child):not(:last-child) {
        border-radius: 0;
        border-left: 1px solid rgba(255, 255, 255, 0.1);
        border-right: 1px solid rgba(255, 255, 255, 0.1);
    }

    .btn-group .btn:first-child {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        border-right: 1px solid rgba(255, 255, 255, 0.1);
    }

    .btn-group .btn:last-child {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        border-left: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* Enhanced progress bars */
    .progress {
        border-radius: 10px;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .progress-bar {
        position: relative;
        overflow: hidden;
    }

    .progress-bar::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, 
            rgba(255, 255, 255, 0.2) 25%, 
            transparent 25%, 
            transparent 50%, 
            rgba(255, 255, 255, 0.2) 50%, 
            rgba(255, 255, 255, 0.2) 75%, 
            transparent 75%);
        background-size: 20px 20px;
        animation: progress-shine 2s linear infinite;
    }

    @keyframes progress-shine {
        0% { background-position: 0 0; }
        100% { background-position: 20px 20px; }
    }

    /* Custom scrollbar styling */
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.05);
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
        transform: scale(1.1);
    }

    /* Card hover animations */
    .card {
        overflow: hidden;
        position: relative;
    }

    .card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        transition: left 0.5s;
        z-index: 1;
    }

    .card:hover::before {
        left: 100%;
    }

    /* Form focus states */
    .form-control:focus {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15) !important;
    }

    /* Breadcrumb styling */
    .breadcrumb-item + .breadcrumb-item::before {
        content: '→';
        color: rgba(255, 255, 255, 0.6);
        font-weight: bold;
    }

    /* Badge enhancements */
    .badge {
        position: relative;
        overflow: hidden;
    }

    .badge::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: left 0.3s;
    }

    .badge:hover::before {
        left: 100%;
    }

    /* Mobile optimizations for employee reports page */
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
        
        /* Report type buttons mobile - vertical stack */
        .btn-group {
            display: flex !important;
            flex-direction: column !important;
            width: 100% !important;
        }
        
        .btn-group .btn {
            border-radius: 12px !important;
            margin-bottom: 0.5rem !important;
            padding: 12px 16px !important;
            font-size: 0.9rem !important;
        }
        
        .btn-group .btn:last-child {
            margin-bottom: 0 !important;
        }
        
        /* Disable hover effects on mobile */
        .card:hover,
        .card:hover::before,
        div[onmouseover]:hover,
        button:hover {
            transform: none !important;
            box-shadow: none !important;
        }
        
        /* Date selector mobile */
        .col-lg-4.col-md-6 {
            flex: 0 0 100% !important;
            max-width: 100% !important;
            margin-bottom: 1rem;
        }
        
        .card-body.p-4 {
            padding: 1rem !important;
        }
        
        .rounded-circle {
            width: 40px !important;
            height: 40px !important;
        }
        
        /* Stats cards mobile layout */
        .col-xl-2,
        .col-lg-4,
        .col-md-6 {
            flex: 0 0 50% !important;
            max-width: 50% !important;
            margin-bottom: 1rem;
        }
        
        .card-body.py-4 {
            padding: 1rem !important;
        }
        
        .card-body h2 {
            font-size: 1.5rem !important;
        }
        
        .card-body p {
            font-size: 0.85rem !important;
        }
        
        .card-body i {
            font-size: 1.5rem !important;
        }
        
        /* Lane usage section mobile */
        .col-lg-8 {
            flex: 0 0 100% !important;
            max-width: 100% !important;
            margin-bottom: 1rem;
        }
        
        .card-header.p-0 {
            padding: 1rem !important;
        }
        
        .card-header .rounded-circle {
            width: 40px !important;
            height: 40px !important;
        }
        
        .card-header h5 {
            font-size: 1.1rem !important;
        }
        
        /* Lane usage items mobile */
        .d-flex.align-items-center.mb-4 {
            flex-direction: column !important;
            align-items: flex-start !important;
            padding: 1rem !important;
        }
        
        .me-4 {
            margin-right: 0 !important;
            margin-bottom: 1rem !important;
            align-self: center;
        }
        
        .me-4 .rounded-circle {
            width: 50px !important;
            height: 50px !important;
        }
        
        .flex-grow-1 {
            width: 100%;
        }
        
        .d-flex.justify-content-between.align-items-center {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 0.5rem;
        }
        
        .text-end {
            align-self: stretch !important;
            text-align: left !important;
        }
        
        .progress {
            height: 8px !important;
        }
        
        /* Maintenance issues mobile */
        .col-lg-4 {
            flex: 0 0 100% !important;
            max-width: 100% !important;
        }
        
        .card-body[style*="max-height"] {
            max-height: 400px !important;
        }
        
        .d-flex.align-items-start.p-3 {
            padding: 1rem !important;
        }
        
        .me-3 .rounded-circle {
            width: 35px !important;
            height: 35px !important;
        }
        
        .d-flex.justify-content-between.align-items-start {
            flex-direction: column !important;
            align-items: flex-start !important;
        }
        
        /* Weekly/Monthly specific mobile */
        .col-xl-4,
        .col-lg-8 {
            flex: 0 0 100% !important;
            max-width: 100% !important;
            margin-bottom: 1rem;
        }
        
        /* Performance highlight cards mobile */
        .rounded-circle.mx-auto {
            width: 60px !important;
            height: 60px !important;
        }
        
        .card-body.text-center h3 {
            font-size: 1.3rem !important;
        }
        
        .card-body.text-center h6 {
            font-size: 1rem !important;
        }
        
        /* Empty states mobile */
        .text-center.py-5 {
            padding: 30px 15px !important;
        }
        
        .text-center .fa-4x,
        .text-center [style*="font-size: 4rem"] {
            font-size: 2.5rem !important;
        }
        
        .text-center h6 {
            font-size: 1rem !important;
        }
        
        /* Badge adjustments mobile */
        .badge {
            font-size: 0.7rem !important;
            padding: 4px 8px !important;
        }
    }

    /* Small mobile screens */
    @media (max-width: 576px) {
        .container-fluid {
            padding-left: 10px !important;
            padding-right: 10px !important;
        }
        
        /* Header more compact */
        .card-body h2 {
            font-size: 1.25rem !important;
        }
        
        .card-body p {
            font-size: 0.9rem !important;
        }
        
        /* Stats cards single column */
        .col-xl-2,
        .col-lg-4,
        .col-md-6 {
            flex: 0 0 100% !important;
            max-width: 100% !important;
        }
        
        .card-body h2 {
            font-size: 1.3rem !important;
        }
        
        /* Date selector more compact */
        .rounded-circle {
            width: 35px !important;
            height: 35px !important;
        }
        
        /* Lane usage more compact */
        .me-4 .rounded-circle {
            width: 45px !important;
            height: 45px !important;
        }
        
        /* Maintenance issues more compact */
        .me-3 .rounded-circle {
            width: 30px !important;
            height: 30px !important;
        }
        
        .card-body[style*="max-height"] {
            max-height: 300px !important;
        }
        
        /* Performance highlights more compact */
        .rounded-circle.mx-auto {
            width: 50px !important;
            height: 50px !important;
        }
    }

    /* Extra small mobile screens */
    @media (max-width: 480px) {
        /* Most compact layout */
        .card-body h2 {
            font-size: 1.1rem !important;
        }
        
        /* Report buttons more compact */
        .btn-group .btn {
            padding: 10px 12px !important;
            font-size: 0.85rem !important;
        }
        
        /* Stats cards most compact */
        .card-body h2 {
            font-size: 1.2rem !important;
        }
        
        .card-body i {
            font-size: 1.25rem !important;
        }
        
        /* Lane usage most compact */
        .me-4 .rounded-circle {
            width: 40px !important;
            height: 40px !important;
        }
        
        .progress {
            height: 6px !important;
        }
        
        /* Maintenance issues most compact */
        .me-3 .rounded-circle {
            width: 25px !important;
            height: 25px !important;
        }
        
        .badge {
            font-size: 0.65rem !important;
            padding: 2px 6px !important;
        }
    }

    /* Reports-specific mobile optimizations */
    @media (max-width: 768px) {
        /* Better touch targets */
        .btn-group .btn {
            min-height: 44px;
            touch-action: manipulation;
        }
        
        /* Gradient backgrounds maintained */
        .bg-info { background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%) !important; }
        .bg-success { background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important; }
        .bg-danger { background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%) !important; }
        .bg-warning { background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%) !important; }
        .bg-primary { background: linear-gradient(135deg, #6610f2 0%, #6f42c1 100%) !important; }
        
        /* Progress animations disabled on mobile */
        .progress-bar::before {
            animation: none;
        }
        
        /* Form elements mobile */
        input[type="date"] {
            font-size: 0.9rem !important;
            padding: 12px !important;
        }
        
        /* Scrollbar mobile */
        ::-webkit-scrollbar {
            width: 4px;
        }
        
        /* Card animations disabled */
        .card::before,
        .badge::before {
            display: none;
        }
    }
    </style>
</div>