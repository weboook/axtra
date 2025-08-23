@section('page-title', 'Dashboard')

<div>
    <!-- Dashboard Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0" style="background: linear-gradient(135deg, #c02425 0%, #d63031 100%); color: white; border-radius: 1.5rem; box-shadow: 0 20px 60px rgba(192, 36, 37, 0.3);">
                <div class="card-body py-4 px-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h2 class="mb-2 fw-bold">Welcome back, {{ auth()->user()->name }}!</h2>
                            <p class="mb-3 opacity-90" style="font-size: 1.1rem;">Ready for your next axe throwing adventure?</p>
                            @if($stats['upcoming_sessions'] > 0)
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-calendar-check me-2"></i>
                                    <span>You have {{ $stats['upcoming_sessions'] }} upcoming session{{ $stats['upcoming_sessions'] > 1 ? 's' : '' }}</span>
                                </div>
                            @else
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-plus-circle me-2"></i>
                                    <a href="{{ route('user.book') }}" class="text-white text-decoration-none fw-semibold">Book your next session now!</a>
                                </div>
                            @endif
                        </div>
                        <div class="d-none d-md-block">
                            <i class="fas fa-bullseye" style="font-size: 4rem; opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-0 h-100" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); transition: transform 0.3s ease, box-shadow 0.3s ease;" 
                 onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 20px 40px rgba(0, 0, 0, 0.12)';"
                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(0, 0, 0, 0.08)';">
                <div class="card-body p-4 text-center">
                    <div class="mb-3" style="background: linear-gradient(135deg, #c02425 0%, #d63031 100%); width: 60px; height: 60px; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                        <i class="fas fa-calendar-check" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                    <h3 class="fw-bold mb-2" style="color: #1b1b1b;">{{ $stats['total_sessions'] }}</h3>
                    <p class="mb-0 text-muted fw-medium">Total Sessions</p>
                    @if($stats['total_sessions'] > 0)
                        <small class="text-muted">Keep up the great work!</small>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-0 h-100" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); transition: transform 0.3s ease, box-shadow 0.3s ease;" 
                 onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 20px 40px rgba(0, 0, 0, 0.12)';"
                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(0, 0, 0, 0.08)';">
                <div class="card-body p-4 text-center">
                    <div class="mb-3" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); width: 60px; height: 60px; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                        <i class="fas fa-bullseye" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                    <h3 class="fw-bold mb-2" style="color: #1b1b1b;">{{ $stats['accuracy_rate'] }}%</h3>
                    <p class="mb-0 text-muted fw-medium">Accuracy Rate</p>
                    @if($stats['accuracy_rate'] >= 80)
                        <small class="text-success">Excellent accuracy!</small>
                    @elseif($stats['accuracy_rate'] >= 60)
                        <small class="text-warning">Good progress!</small>
                    @else
                        <small class="text-muted">Keep practicing!</small>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-0 h-100" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); transition: transform 0.3s ease, box-shadow 0.3s ease;" 
                 onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 20px 40px rgba(0, 0, 0, 0.12)';"
                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(0, 0, 0, 0.08)';">
                <div class="card-body p-4 text-center">
                    <div class="mb-3" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); width: 60px; height: 60px; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                        <i class="fas fa-trophy" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                    <h3 class="fw-bold mb-2" style="color: #1b1b1b;">#{{ $stats['leaderboard_rank'] }}</h3>
                    <p class="mb-0 text-muted fw-medium">Leaderboard Rank</p>
                    @if($stats['leaderboard_rank'] <= 3)
                        <small class="text-warning">Top performer!</small>
                    @elseif($stats['leaderboard_rank'] <= 10)
                        <small class="text-success">Great ranking!</small>
                    @else
                        <small class="text-muted">Room to climb!</small>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-0 h-100" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); transition: transform 0.3s ease, box-shadow 0.3s ease;" 
                 onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 20px 40px rgba(0, 0, 0, 0.12)';"
                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(0, 0, 0, 0.08)';">
                <div class="card-body p-4 text-center">
                    <div class="mb-3" style="background: linear-gradient(135deg, #6f42c1 0%, #e83e8c 100%); width: 60px; height: 60px; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                        <i class="fas fa-star" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                    <h3 class="fw-bold mb-2" style="color: #1b1b1b;">{{ $stats['skill_points'] }}</h3>
                    <p class="mb-0 text-muted fw-medium">Skill Points</p>
                    @php
                        $skillLevel = $stats['skill_points'] >= 1000 ? 'Expert' : ($stats['skill_points'] >= 500 ? 'Advanced' : ($stats['skill_points'] >= 200 ? 'Intermediate' : 'Beginner'));
                    @endphp
                    <small class="fw-semibold" style="color: #6f42c1;">{{ $skillLevel }} Level</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Row -->
    <div class="row">
        <!-- Left Column - Quick Actions & Upcoming Sessions -->
        <div class="col-lg-8 mb-4">
            <!-- Quick Actions -->
            <div class="card border-0 mb-4" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                <div class="card-header" style="background: transparent; border-bottom: 1px solid rgba(0, 0, 0, 0.05); padding: 1.5rem 1.5rem 0; border-radius: 1.25rem 1.25rem 0 0;">
                    <h5 class="mb-0 fw-bold d-flex align-items-center" style="color: #1b1b1b;">
                        <i class="fas fa-bolt me-2" style="color: #c02425;"></i>
                        Quick Actions
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <a href="{{ route('user.book') }}" class="btn w-100 d-flex flex-column align-items-center justify-content-center py-3 text-decoration-none" 
                               style="background: linear-gradient(135deg, #c02425 0%, #d63031 100%); color: white; border-radius: 1rem; border: none; min-height: 100px; transition: transform 0.3s ease;"
                               onmouseover="this.style.transform='translateY(-3px)'"
                               onmouseout="this.style.transform='translateY(0)'">
                                <i class="fas fa-plus-circle mb-2" style="font-size: 1.5rem;"></i>
                                <span class="fw-semibold">Book New Session</span>
                                <small class="opacity-75">Reserve your lane</small>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('user.bookings') }}" class="btn w-100 d-flex flex-column align-items-center justify-content-center py-3 text-decoration-none" 
                               style="background: linear-gradient(135deg, #1b1b1b 0%, #343a40 100%); color: white; border-radius: 1rem; border: none; min-height: 100px; transition: transform 0.3s ease;"
                               onmouseover="this.style.transform='translateY(-3px)'"
                               onmouseout="this.style.transform='translateY(0)'">
                                <i class="fas fa-calendar-alt mb-2" style="font-size: 1.5rem;"></i>
                                <span class="fw-semibold">View Bookings</span>
                                <small class="opacity-75">Manage reservations</small>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('leaderboard.public') }}" class="btn w-100 d-flex flex-column align-items-center justify-content-center py-3 text-decoration-none" 
                               style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); color: white; border-radius: 1rem; border: none; min-height: 100px; transition: transform 0.3s ease;"
                               onmouseover="this.style.transform='translateY(-3px)'"
                               onmouseout="this.style.transform='translateY(0)'">
                                <i class="fas fa-trophy mb-2" style="font-size: 1.5rem;"></i>
                                <span class="fw-semibold">Leaderboard</span>
                                <small class="opacity-75">Check rankings</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upcoming Sessions -->
            @if($upcomingSessions->isNotEmpty())
            <div class="card border-0" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                <div class="card-header" style="background: transparent; border-bottom: 1px solid rgba(0, 0, 0, 0.05); padding: 1.5rem 1.5rem 0; border-radius: 1.25rem 1.25rem 0 0;">
                    <h5 class="mb-0 fw-bold d-flex align-items-center" style="color: #1b1b1b;">
                        <i class="fas fa-clock me-2" style="color: #28a745;"></i>
                        Upcoming Sessions
                    </h5>
                </div>
                <div class="card-body p-4">
                    @foreach($upcomingSessions as $session)
                    <div class="d-flex align-items-center p-3 mb-3 rounded-3 {{ !$loop->last ? 'border-bottom' : '' }}" 
                         style="background: rgba(40, 167, 69, 0.05); border: 1px solid rgba(40, 167, 69, 0.1) !important;">
                        <div class="me-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 50px; height: 50px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white;">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-semibold" style="color: #1b1b1b;">{{ $session->product->name ?? 'Axe Throwing Session' }}</h6>
                            <p class="mb-1 text-muted">{{ \Carbon\Carbon::parse($session->booking_date)->format('l, F j, Y') }}</p>
                            <small class="text-success fw-medium">{{ \Carbon\Carbon::parse($session->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($session->end_time)->format('g:i A') }}</small>
                        </div>
                        <div class="text-end">
                            <span class="badge px-3 py-2" style="background: rgba(40, 167, 69, 0.2); color: #28a745; font-size: 0.8rem;">
                                {{ $session->participants }} player{{ $session->participants > 1 ? 's' : '' }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @else
            <div class="card border-0" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                <div class="card-body p-4 text-center">
                    <i class="fas fa-calendar-plus mb-3" style="font-size: 3rem; color: rgba(192, 36, 37, 0.3);"></i>
                    <h5 class="fw-bold mb-2" style="color: #1b1b1b;">No Upcoming Sessions</h5>
                    <p class="text-muted mb-3">Ready to book your next axe throwing adventure?</p>
                    <a href="{{ route('user.book') }}" class="btn px-4 py-2" style="background: linear-gradient(135deg, #c02425 0%, #d63031 100%); color: white; border-radius: 2rem; border: none;">
                        <i class="fas fa-plus-circle me-2"></i>Book New Session
                    </a>
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column - Recent Activity & Performance -->
        <div class="col-lg-4 mb-4">
            <!-- Recent Activity -->
            <div class="card border-0 mb-4" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                <div class="card-header" style="background: transparent; border-bottom: 1px solid rgba(0, 0, 0, 0.05); padding: 1.5rem 1.5rem 0; border-radius: 1.25rem 1.25rem 0 0;">
                    <h5 class="mb-0 fw-bold d-flex align-items-center" style="color: #1b1b1b;">
                        <i class="fas fa-activity me-2" style="color: #6f42c1;"></i>
                        Recent Activity
                    </h5>
                </div>
                <div class="card-body p-4">
                    @if($recentActivity->isNotEmpty())
                        @foreach($recentActivity as $activity)
                        <div class="d-flex align-items-center mb-3 {{ !$loop->last ? 'pb-3 border-bottom' : '' }}" 
                             style="border-color: rgba(0, 0, 0, 0.05) !important;">
                            <div class="me-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 40px; height: 40px; background: {{ $activity['color'] }}; color: white;">
                                    <i class="fas {{ $activity['icon'] }}"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1 fw-semibold" style="color: #1b1b1b; font-size: 0.9rem;">{{ $activity['title'] }}</h6>
                                <small class="text-muted">{{ $activity['description'] }}</small>
                                <br><small class="text-muted">{{ $activity['time']->diffForHumans() }}</small>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-clock mb-3" style="font-size: 2rem; color: rgba(111, 66, 193, 0.3);"></i>
                            <p class="text-muted mb-0">No recent activity</p>
                            <small class="text-muted">Start playing to see your progress here!</small>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Skill Progress -->
            <div class="card border-0" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                <div class="card-header" style="background: transparent; border-bottom: 1px solid rgba(0, 0, 0, 0.05); padding: 1.5rem 1.5rem 0; border-radius: 1.25rem 1.25rem 0 0;">
                    <h5 class="mb-0 fw-bold d-flex align-items-center" style="color: #1b1b1b;">
                        <i class="fas fa-chart-line me-2" style="color: #17a2b8;"></i>
                        Skill Progress
                    </h5>
                </div>
                <div class="card-body p-4">
                    @php
                        $currentLevel = $stats['skill_points'] >= 1000 ? 'Expert' : ($stats['skill_points'] >= 500 ? 'Advanced' : ($stats['skill_points'] >= 200 ? 'Intermediate' : 'Beginner'));
                        $nextThreshold = $stats['skill_points'] >= 1000 ? 1000 : ($stats['skill_points'] >= 500 ? 1000 : ($stats['skill_points'] >= 200 ? 500 : 200));
                        $previousThreshold = $stats['skill_points'] >= 1000 ? 500 : ($stats['skill_points'] >= 500 ? 200 : ($stats['skill_points'] >= 200 ? 0 : 0));
                        $progress = $nextThreshold > $stats['skill_points'] ? (($stats['skill_points'] - $previousThreshold) / ($nextThreshold - $previousThreshold)) * 100 : 100;
                    @endphp
                    
                    <div class="text-center mb-4">
                        <div class="mb-3" style="background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%); width: 80px; height: 80px; border-radius: 25px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                            <i class="fas fa-medal" style="font-size: 2rem; color: white;"></i>
                        </div>
                        <h4 class="fw-bold mb-1" style="color: #1b1b1b;">{{ $currentLevel }}</h4>
                        <p class="text-muted mb-0">Current Level</p>
                    </div>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <small class="text-muted fw-medium">Progress to {{ $nextThreshold > $stats['skill_points'] ? ($nextThreshold == 1000 ? 'Expert' : ($nextThreshold == 500 ? 'Advanced' : 'Intermediate')) : 'Max Level' }}</small>
                            <small class="fw-bold" style="color: #17a2b8;">{{ round($progress) }}%</small>
                        </div>
                        <div class="progress" style="height: 8px; background: rgba(23, 162, 184, 0.1); border-radius: 4px;">
                            <div class="progress-bar" 
                                 style="background: linear-gradient(90deg, #17a2b8 0%, #6f42c1 100%); width: {{ $progress }}%; border-radius: 4px;"></div>
                        </div>
                    </div>
                    
                    <div class="text-center">
                        <small class="text-muted">{{ $stats['skill_points'] }} / {{ $nextThreshold > $stats['skill_points'] ? $nextThreshold : $stats['skill_points'] }} points</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($recentBookings->isNotEmpty())
    <!-- Recent Bookings -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                <div class="card-header" style="background: transparent; border-bottom: 1px solid rgba(0, 0, 0, 0.05); padding: 1.5rem 1.5rem 0; border-radius: 1.25rem 1.25rem 0 0;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold d-flex align-items-center" style="color: #1b1b1b;">
                            <i class="fas fa-history me-2" style="color: #fd7e14;"></i>
                            Recent Bookings
                        </h5>
                        <a href="{{ route('user.bookings') }}" class="btn btn-sm" style="background: rgba(192, 36, 37, 0.1); color: #c02425; border: 1px solid rgba(192, 36, 37, 0.2); border-radius: 1rem;">
                            View All
                        </a>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        @foreach($recentBookings->take(3) as $booking)
                        <div class="col-md-4 mb-3">
                            <div class="card border-0 h-100" style="background: rgba(248, 249, 250, 0.5); border-radius: 1rem;">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="me-2">
                                            <div class="rounded d-flex align-items-center justify-content-center" 
                                                 style="width: 35px; height: 35px; background: rgba(192, 36, 37, 0.1); color: #c02425;">
                                                <i class="fas fa-calendar"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0 fw-semibold" style="color: #1b1b1b; font-size: 0.9rem;">{{ $booking->booking_reference }}</h6>
                                            <small class="text-muted">{{ $booking->created_at->format('M j, Y') }}</small>
                                        </div>
                                    </div>
                                    <p class="mb-2 text-muted" style="font-size: 0.85rem;">{{ $booking->product->name ?? 'Axe Throwing Session' }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge px-2 py-1" style="background: 
                                            @if($booking->status == 'confirmed') rgba(40, 167, 69, 0.2); color: #28a745;
                                            @elseif($booking->status == 'pending') rgba(255, 193, 7, 0.2); color: #ffc107;
                                            @else rgba(220, 53, 69, 0.2); color: #dc3545; @endif
                                            font-size: 0.75rem;">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                        <small class="text-muted">{{ $booking->participants }} player{{ $booking->participants > 1 ? 's' : '' }}</small>
                                    </div>
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
</div>