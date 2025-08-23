@section('page-title', 'Leaderboard')

<div>
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); color: white; border-radius: 1.5rem; box-shadow: 0 20px 60px rgba(255, 193, 7, 0.3);">
                <div class="card-body py-4 px-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h2 class="mb-2 fw-bold">Community Leaderboard</h2>
                            <p class="mb-3 opacity-90" style="font-size: 1.1rem;">Compete with fellow axe throwers</p>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-users me-2"></i>
                                <span>{{ $stats['total_players'] }} players competing</span>
                                @if($currentUserRank)
                                    <span class="mx-2">•</span>
                                    <span class="fw-bold">You're ranked #{{ $currentUserRank }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="d-none d-md-block">
                            <i class="fas fa-trophy" style="font-size: 4rem; opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-0 h-100" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); transition: transform 0.3s ease;"
                 onmouseover="this.style.transform='translateY(-3px)'"
                 onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body p-4 text-center">
                    <div class="mb-3" style="background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%); width: 60px; height: 60px; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                        <i class="fas fa-users" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                    <h3 class="fw-bold mb-2" style="color: #1b1b1b;">{{ $stats['total_players'] }}</h3>
                    <p class="mb-0 text-muted fw-medium">Total Players</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-0 h-100" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); transition: transform 0.3s ease;"
                 onmouseover="this.style.transform='translateY(-3px)'"
                 onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body p-4 text-center">
                    <div class="mb-3" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); width: 60px; height: 60px; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                        <i class="fas fa-user-clock" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                    <h3 class="fw-bold mb-2" style="color: #1b1b1b;">{{ $stats['active_players'] }}</h3>
                    <p class="mb-0 text-muted fw-medium">Active Players</p>
                    <small class="text-success">This month</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-0 h-100" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); transition: transform 0.3s ease;"
                 onmouseover="this.style.transform='translateY(-3px)'"
                 onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body p-4 text-center">
                    <div class="mb-3" style="background: linear-gradient(135deg, #6f42c1 0%, #e83e8c 100%); width: 60px; height: 60px; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                        <i class="fas fa-calendar-check" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                    <h3 class="fw-bold mb-2" style="color: #1b1b1b;">{{ number_format($stats['total_sessions']) }}</h3>
                    <p class="mb-0 text-muted fw-medium">Sessions Played</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-0 h-100" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); transition: transform 0.3s ease;"
                 onmouseover="this.style.transform='translateY(-3px)'"
                 onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body p-4 text-center">
                    <div class="mb-3" style="background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%); width: 60px; height: 60px; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                        <i class="fas fa-bullseye" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                    <h3 class="fw-bold mb-2" style="color: #1b1b1b;">{{ number_format($stats['total_throws']) }}</h3>
                    <p class="mb-0 text-muted fw-medium">Total Throws</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Controls -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <!-- Ranking Type -->
                            <label class="form-label fw-semibold mb-2" style="color: #1b1b1b;">Rank By</label>
                            <div class="btn-group w-100" role="group">
                                <button type="button" wire:click="$set('filter', 'skill_points')" 
                                        class="btn {{ $filter === 'skill_points' ? 'btn-primary' : 'btn-outline-secondary' }}" 
                                        style="border-radius: 1rem 0 0 1rem; {{ $filter === 'skill_points' ? 'background: #ffc107; border-color: #ffc107; color: #1b1b1b;' : '' }}">
                                    <i class="fas fa-star me-1"></i> Points
                                </button>
                                <button type="button" wire:click="$set('filter', 'accuracy')" 
                                        class="btn {{ $filter === 'accuracy' ? 'btn-primary' : 'btn-outline-secondary' }}"
                                        style="{{ $filter === 'accuracy' ? 'background: #ffc107; border-color: #ffc107; color: #1b1b1b;' : '' }}">
                                    <i class="fas fa-bullseye me-1"></i> Accuracy
                                </button>
                                <button type="button" wire:click="$set('filter', 'sessions')" 
                                        class="btn {{ $filter === 'sessions' ? 'btn-primary' : 'btn-outline-secondary' }}" 
                                        style="border-radius: 0 1rem 1rem 0; {{ $filter === 'sessions' ? 'background: #ffc107; border-color: #ffc107; color: #1b1b1b;' : '' }}">
                                    <i class="fas fa-calendar me-1"></i> Sessions
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4 mt-3 mt-md-0">
                            <!-- Time Period -->
                            <label class="form-label fw-semibold mb-2" style="color: #1b1b1b;">Time Period</label>
                            <div class="btn-group w-100" role="group">
                                <button type="button" wire:click="$set('period', 'all')" 
                                        class="btn {{ $period === 'all' ? 'btn-secondary' : 'btn-outline-secondary' }}" 
                                        style="border-radius: 1rem 0 0 1rem;">
                                    All Time
                                </button>
                                <button type="button" wire:click="$set('period', 'month')" 
                                        class="btn {{ $period === 'month' ? 'btn-secondary' : 'btn-outline-secondary' }}">
                                    Month
                                </button>
                                <button type="button" wire:click="$set('period', 'week')" 
                                        class="btn {{ $period === 'week' ? 'btn-secondary' : 'btn-outline-secondary' }}" 
                                        style="border-radius: 0 1rem 1rem 0;">
                                    Week
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4 mt-3 mt-md-0">
                            <!-- Search -->
                            <label class="form-label fw-semibold mb-2" style="color: #1b1b1b;">Search Players</label>
                            <div class="input-group">
                                <span class="input-group-text" style="background: rgba(255, 193, 7, 0.1); border: 1px solid rgba(255, 193, 7, 0.2); color: #ffc107;">
                                    <i class="fas fa-search"></i>
                                </span>
                                <input type="text" wire:model.live="search" class="form-control" 
                                       placeholder="Search by name..."
                                       style="border: 1px solid rgba(255, 193, 7, 0.2); border-left: none;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Current User Rank Highlight -->
    @if($currentUserRank)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0" style="background: linear-gradient(135deg, rgba(255, 193, 7, 0.1) 0%, rgba(253, 126, 20, 0.1) 100%); border: 2px solid rgba(255, 193, 7, 0.3); border-radius: 1.25rem;">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="me-3" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); width: 50px; height: 50px; border-radius: 25px; display: flex; align-items: center; justify-content: center;">
                                <span class="fw-bold" style="color: white; font-size: 1.2rem;">#{{ $currentUserRank }}</span>
                            </div>
                            <div>
                                <h5 class="mb-1 fw-bold" style="color: #1b1b1b;">Your Current Rank</h5>
                                <small class="text-muted">
                                    Based on {{ $filter === 'skill_points' ? 'skill points' : ($filter === 'accuracy' ? 'accuracy rate' : 'sessions played') }}
                                    {{ $period !== 'all' ? '(' . $period . ')' : '' }}
                                </small>
                            </div>
                        </div>
                        <div class="text-end">
                            @if($filter === 'skill_points')
                                <h4 class="fw-bold mb-0" style="color: #ffc107;">{{ auth()->user()->skill_points ?? 0 }} pts</h4>
                            @elseif($filter === 'accuracy')
                                <h4 class="fw-bold mb-0" style="color: #ffc107;">{{ auth()->user()->accuracy_rate ?? 0 }}%</h4>
                            @else
                                <h4 class="fw-bold mb-0" style="color: #ffc107;">{{ auth()->user()->total_sessions ?? 0 }} sessions</h4>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Leaderboard -->
    @if($leaderboard->count() > 0)
        <div class="row">
            <div class="col-12">
                <div class="card border-0" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                    <div class="card-body p-0">
                        @foreach($leaderboard as $player)
                        @php
                            $rank = ($leaderboard->currentPage() - 1) * $leaderboard->perPage() + $loop->iteration;
                            $isCurrentUser = auth()->id() === $player->id;
                        @endphp
                        <div class="d-flex align-items-center p-4 {{ !$loop->last ? 'border-bottom' : '' }} {{ $isCurrentUser ? 'bg-warning bg-opacity-10' : '' }}" 
                             style="border-color: rgba(0, 0, 0, 0.05) !important; transition: background 0.3s ease;"
                             @if(!$isCurrentUser)
                             onmouseover="this.style.background='rgba(255, 193, 7, 0.05)'"
                             onmouseout="this.style.background='transparent'"
                             @endif>
                            
                            <!-- Rank Badge -->
                            <div class="me-4 text-center" style="min-width: 80px;">
                                @if($rank <= 3)
                                    <div class="mb-2" style="background: 
                                        @if($rank === 1) linear-gradient(135deg, #ffd700 0%, #ffed4a 100%);
                                        @elseif($rank === 2) linear-gradient(135deg, #c0c0c0 0%, #e5e7eb 100%);
                                        @else linear-gradient(135deg, #cd7f32 0%, #d69e2e 100%); @endif
                                        width: 60px; height: 60px; border-radius: 30px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                        @if($rank === 1)
                                            <i class="fas fa-crown" style="font-size: 1.5rem; color: #1b1b1b;"></i>
                                        @elseif($rank === 2)
                                            <i class="fas fa-medal" style="font-size: 1.5rem; color: #1b1b1b;"></i>
                                        @else
                                            <i class="fas fa-award" style="font-size: 1.5rem; color: #1b1b1b;"></i>
                                        @endif
                                    </div>
                                    <h4 class="fw-bold mb-0" style="color: 
                                        @if($rank === 1) #ffd700;
                                        @elseif($rank === 2) #c0c0c0;
                                        @else #cd7f32; @endif">
                                        #{{ $rank }}
                                    </h4>
                                @else
                                    <div class="mb-2" style="background: rgba(111, 66, 193, 0.1); width: 60px; height: 60px; border-radius: 30px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                        <span class="fw-bold" style="color: #6f42c1; font-size: 1.5rem;">#{{ $rank }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Player Info -->
                            <div class="flex-grow-1 me-4">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="me-3">
                                        @if($player->profile_photo_path)
                                            <img src="{{ $player->profile_photo_url }}" alt="{{ $player->name }}" 
                                                 style="width: 45px; height: 45px; border-radius: 50%; border: 2px solid #ffc107; object-fit: cover;">
                                        @else
                                            <div style="width: 45px; height: 45px; background: #ffc107; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; color: #1b1b1b;">
                                                {{ strtoupper(substr($player->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <h5 class="mb-1 fw-bold d-flex align-items-center" style="color: #1b1b1b;">
                                            {{ $player->name }}
                                            @if($isCurrentUser)
                                                <span class="badge ms-2 px-2 py-1" style="background: #ffc107; color: #1b1b1b; font-size: 0.7rem;">You</span>
                                            @endif
                                        </h5>
                                        <div class="d-flex align-items-center">
                                            <span class="badge me-2 px-2 py-1" style="background: 
                                                @php
                                                    $skillLevel = $player->skill_points >= 1000 ? 'Expert' : ($player->skill_points >= 500 ? 'Advanced' : ($player->skill_points >= 200 ? 'Intermediate' : 'Beginner'));
                                                    echo $skillLevel === 'Expert' ? '#dc3545' : ($skillLevel === 'Advanced' ? '#ffc107' : ($skillLevel === 'Intermediate' ? '#28a745' : '#6c757d'));
                                                @endphp; 
                                                color: white; font-size: 0.7rem;">
                                                {{ $skillLevel }}
                                            </span>
                                            <small class="text-muted">
                                                <i class="fas fa-calendar-alt me-1"></i>
                                                {{ $player->total_sessions }} sessions
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Stats -->
                            <div class="text-end" style="min-width: 120px;">
                                @if($filter === 'skill_points')
                                    <h3 class="fw-bold mb-1" style="color: #ffc107;">{{ number_format($player->skill_points ?? 0) }}</h3>
                                    <small class="text-muted">Skill Points</small>
                                @elseif($filter === 'accuracy')
                                    <h3 class="fw-bold mb-1" style="color: #28a745;">{{ $player->accuracy_rate }}%</h3>
                                    <small class="text-muted">{{ $player->total_hits }}/{{ $player->total_throws }} hits</small>
                                @else
                                    <h3 class="fw-bold mb-1" style="color: #6f42c1;">{{ $player->total_sessions }}</h3>
                                    <small class="text-muted">Completed Sessions</small>
                                @endif
                                
                                @if($player->accuracy_rate > 0 && $filter !== 'accuracy')
                                    <div class="mt-1">
                                        <small class="text-success">{{ $player->accuracy_rate }}% accuracy</small>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $leaderboard->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                    <div class="card-body p-5 text-center">
                        <i class="fas fa-trophy mb-4" style="font-size: 4rem; color: rgba(255, 193, 7, 0.3);"></i>
                        <h3 class="fw-bold mb-3" style="color: #1b1b1b;">No Players Found</h3>
                        <p class="text-muted mb-4" style="font-size: 1.1rem;">
                            @if($search)
                                No players match your search criteria.
                            @else
                                The leaderboard is waiting for its first competitors!
                            @endif
                        </p>
                        @if(!$search)
                            <a href="{{ route('user.book') }}" class="btn btn-lg px-5 py-3" 
                               style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); color: #1b1b1b; border-radius: 2rem; border: none; font-weight: bold;">
                                <i class="fas fa-plus-circle me-2"></i>Start Your Journey
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Call to Action -->
    @if($leaderboard->count() > 0)
        <div class="row mt-5">
            <div class="col-12">
                <div class="card border-0" style="background: rgba(255, 193, 7, 0.05); border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                    <div class="card-body p-4 text-center">
                        <h5 class="fw-bold mb-3" style="color: #1b1b1b;">Ready to Climb the Rankings?</h5>
                        <a href="{{ route('user.book') }}" class="btn btn-lg px-4 py-2 me-3" 
                           style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); color: #1b1b1b; border-radius: 2rem; border: none; font-weight: bold;">
                            <i class="fas fa-plus-circle me-2"></i>Book a Session
                        </a>
                        <a href="{{ route('dashboard') }}" class="btn btn-lg btn-outline-secondary px-4 py-2" 
                           style="border-radius: 2rem; border-color: #ffc107; color: #ffc107;">
                            <i class="fas fa-chart-line me-2"></i>View My Stats
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>