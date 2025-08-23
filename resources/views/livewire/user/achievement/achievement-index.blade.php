<div>
    <!-- Current Level Banner -->
    @if($currentSkillLevel && $levelProgress)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0" style="background: linear-gradient(135deg, {{ $currentSkillLevel->color }} 0%, {{ $currentSkillLevel->color }}dd 100%); color: white; border-radius: 1.5rem; box-shadow: 0 20px 60px rgba({{ str_replace('#', '', $currentSkillLevel->color) }}, 0.3);">
                <div class="card-body py-4 px-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h2 class="mb-2 fw-bold">{{ $currentSkillLevel->name }} Level</h2>
                            <p class="mb-3 opacity-90" style="font-size: 1.1rem;">{{ $currentSkillLevel->description ?? 'Your current skill level' }}</p>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-star me-2"></i>
                                <span>{{ number_format($userPoints) }} skill points earned</span>
                                @if($levelProgress['next_level'])
                                    <span class="ms-3 opacity-75">{{ $levelProgress['points_needed'] }} more to {{ $levelProgress['next_level']->name }}</span>
                                @endif
                            </div>
                            @if($levelProgress['next_level'])
                                <div class="mt-3">
                                    <div class="progress" style="height: 8px; background: rgba(255,255,255,0.2); border-radius: 10px;">
                                        <div class="progress-bar" 
                                             role="progressbar" 
                                             style="width: {{ $levelProgress['progress_percentage'] }}%; background: rgba(255,255,255,0.8); border-radius: 10px;"
                                             aria-valuenow="{{ $levelProgress['progress_percentage'] }}" 
                                             aria-valuemin="0" 
                                             aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="d-none d-md-block">
                            <div class="text-center">
                                <div class="mb-3" style="width: 80px; height: 80px; border-radius: 20px; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                    <i class="fas {{ $currentSkillLevel->icon ?? 'fa-user' }}" style="font-size: 2.5rem; opacity: 0.8;"></i>
                                </div>
                                @if($currentSkillLevel->perks)
                                    <div class="d-flex flex-wrap justify-content-center gap-1">
                                        @foreach(array_slice($currentSkillLevel->perks, 0, 3) as $perk)
                                            <span class="badge px-2 py-1" style="background: rgba(255,255,255,0.2); color: white; border-radius: 10px; font-size: 0.75rem;">
                                                {{ $perk }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Quick Stats -->
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-0 h-100" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); transition: transform 0.3s ease, box-shadow 0.3s ease;" 
                 onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 20px 40px rgba(0, 0, 0, 0.12)';"
                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(0, 0, 0, 0.08)';">
                <div class="card-body p-4 text-center">
                    <div class="mb-3" style="background: linear-gradient(135deg, #6f42c1 0%, #e83e8c 100%); width: 60px; height: 60px; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                        <i class="fas fa-star" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                    <h3 class="fw-bold mb-2" style="color: #1b1b1b;">{{ number_format($userPoints) }}</h3>
                    <p class="mb-0 text-muted fw-medium">Skill Points</p>
                    <small class="fw-semibold" style="color: #6f42c1;">{{ $currentSkillLevel->name ?? 'Beginner' }} Level</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-0 h-100" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); transition: transform 0.3s ease, box-shadow 0.3s ease;" 
                 onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 20px 40px rgba(0, 0, 0, 0.12)';"
                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(0, 0, 0, 0.08)';">
                <div class="card-body p-4 text-center">
                    <div class="mb-3" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); width: 60px; height: 60px; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                        <i class="fas fa-trophy" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                    <h3 class="fw-bold mb-2" style="color: #1b1b1b;">{{ $completedAchievements }}</h3>
                    <p class="mb-0 text-muted fw-medium">Completed</p>
                    <small class="text-success">{{ $completedAchievements }}/{{ $totalAchievements }} achievements</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-0 h-100" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); transition: transform 0.3s ease, box-shadow 0.3s ease;" 
                 onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 20px 40px rgba(0, 0, 0, 0.12)';"
                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(0, 0, 0, 0.08)';">
                <div class="card-body p-4 text-center">
                    <div class="mb-3" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); width: 60px; height: 60px; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                        <i class="fas fa-clock" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                    <h3 class="fw-bold mb-2" style="color: #1b1b1b;">{{ $inProgressAchievements }}</h3>
                    <p class="mb-0 text-muted fw-medium">In Progress</p>
                    <small class="text-warning">Keep going!</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-0 h-100" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); transition: transform 0.3s ease, box-shadow 0.3s ease;" 
                 onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 20px 40px rgba(0, 0, 0, 0.12)';"
                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(0, 0, 0, 0.08)';">
                <div class="card-body p-4 text-center">
                    <div class="mb-3" style="background: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%); width: 60px; height: 60px; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                        <i class="fas fa-medal" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                    <h3 class="fw-bold mb-2" style="color: #1b1b1b;">{{ $skillLevels->where('min_points', '<=', $userPoints)->count() }}</h3>
                    <p class="mb-0 text-muted fw-medium">Levels Unlocked</p>
                    <small class="text-info">{{ $skillLevels->count() - $skillLevels->where('min_points', '<=', $userPoints)->count() }} remaining</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Row -->
    <div class="row">
        <!-- Left Column - Achievements -->
        <div class="col-lg-8 mb-4">
            <!-- Achievements Section -->
            <div class="card border-0 mb-4" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                <div class="card-header" style="background: transparent; border-bottom: 1px solid rgba(0, 0, 0, 0.05); padding: 1.5rem 1.5rem 0; border-radius: 1.25rem 1.25rem 0 0;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold d-flex align-items-center" style="color: #1b1b1b;">
                            <i class="fas fa-medal me-2" style="color: #c02425;"></i>
                            Achievements
                        </h5>
                        <div class="d-flex gap-2 flex-wrap">
                            <button wire:click="setFilter('all')" 
                                    class="btn btn-sm {{ $filterType === 'all' ? 'btn-primary' : 'btn-outline-secondary' }}"
                                    style="border-radius: 1rem; font-size: 0.8rem;">
                                All
                            </button>
                            <button wire:click="setFilter('completed')" 
                                    class="btn btn-sm {{ $filterType === 'completed' ? 'btn-primary' : 'btn-outline-secondary' }}"
                                    style="border-radius: 1rem; font-size: 0.8rem;">
                                Completed
                            </button>
                            <button wire:click="setFilter('in_progress')" 
                                    class="btn btn-sm {{ $filterType === 'in_progress' ? 'btn-primary' : 'btn-outline-secondary' }}"
                                    style="border-radius: 1rem; font-size: 0.8rem;">
                                In Progress  
                            </button>
                            <button wire:click="setFilter('locked')" 
                                    class="btn btn-sm {{ $filterType === 'locked' ? 'btn-primary' : 'btn-outline-secondary' }}"
                                    style="border-radius: 1rem; font-size: 0.8rem;">
                                Locked
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        @forelse($achievements as $achievement)
                            @php
                                $userAchievement = $userAchievements->get($achievement->id);
                                $isCompleted = $userAchievement && $userAchievement->isCompleted();
                                $progress = $userAchievement ? $userAchievement->getProgressPercentage() : 0;
                                $currentValue = $userAchievement->current_value ?? 0;
                                $targetValue = $achievement->requirements['target'] ?? 1;
                            @endphp
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center p-3 rounded-3 {{ $isCompleted ? 'border' : '' }}" 
                                     style="background: {{ $isCompleted ? 'rgba(40, 167, 69, 0.05)' : 'rgba(0, 0, 0, 0.02)' }}; border: 1px solid {{ $isCompleted ? 'rgba(40, 167, 69, 0.2)' : 'rgba(0, 0, 0, 0.05)' }} !important; transition: all 0.3s ease;"
                                     onmouseover="this.style.background='{{ $isCompleted ? 'rgba(40, 167, 69, 0.08)' : 'rgba(0, 0, 0, 0.04)' }}';"
                                     onmouseout="this.style.background='{{ $isCompleted ? 'rgba(40, 167, 69, 0.05)' : 'rgba(0, 0, 0, 0.02)' }}';">
                                    <div class="me-3">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                             style="width: 50px; height: 50px; background: {{ $isCompleted ? 'linear-gradient(135deg, #28a745 0%, #20c997 100%)' : $achievement->color }}; color: white;">
                                            <i class="fas {{ $achievement->icon ?? 'fa-award' }}"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <h6 class="mb-0 fw-semibold" style="color: #1b1b1b;">{{ $achievement->name }}</h6>
                                            @if($isCompleted)
                                                <span class="badge px-2 py-1" style="background: rgba(40, 167, 69, 0.2); color: #28a745; font-size: 0.7rem;">
                                                    <i class="fas fa-check me-1"></i>Completed
                                                </span>
                                            @elseif($progress > 0)
                                                <span class="badge px-2 py-1" style="background: rgba(255, 193, 7, 0.2); color: #ffc107; font-size: 0.7rem;">
                                                    {{ $progress }}%
                                                </span>
                                            @else
                                                <span class="badge px-2 py-1" style="background: rgba(108, 117, 125, 0.2); color: #6c757d; font-size: 0.7rem;">
                                                    <i class="fas fa-lock me-1"></i>Locked
                                                </span>
                                            @endif
                                        </div>
                                        <p class="mb-2 text-muted" style="font-size: 0.9rem;">{{ $achievement->description }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="fw-medium" style="color: #c02425;">{{ $achievement->points_reward }} points</small>
                                            @if($isCompleted && $userAchievement->completed_at)
                                                <small class="text-success">
                                                    {{ $userAchievement->completed_at->format('M j, Y') }}
                                                </small>
                                            @elseif($progress > 0)
                                                <small class="text-muted">{{ $currentValue }}/{{ $targetValue }}</small>
                                            @endif
                                        </div>
                                        @if(!$isCompleted && $progress > 0)
                                            <div class="mt-2">
                                                <div class="progress" style="height: 4px; background: rgba(0, 0, 0, 0.1); border-radius: 10px;">
                                                    <div class="progress-bar" 
                                                         role="progressbar" 
                                                         style="width: {{ $progress }}%; background: {{ $achievement->color }}; border-radius: 10px;"
                                                         aria-valuenow="{{ $progress }}" 
                                                         aria-valuemin="0" 
                                                         aria-valuemax="100">
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="text-center py-5">
                                    <i class="fas fa-trophy mb-3" style="font-size: 3rem; color: rgba(192, 36, 37, 0.3);"></i>
                                    <h5 class="fw-bold mb-2" style="color: #1b1b1b;">No achievements found</h5>
                                    <p class="text-muted mb-3">
                                        @if($filterType === 'completed')
                                            You haven't completed any achievements yet. Keep playing to unlock them!
                                        @elseif($filterType === 'in_progress')
                                            You don't have any achievements in progress.
                                        @elseif($filterType === 'locked')
                                            All available achievements are already unlocked or in progress!
                                        @else
                                            No achievements are available at the moment.
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Skill Levels -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                <div class="card-header" style="background: transparent; border-bottom: 1px solid rgba(0, 0, 0, 0.05); padding: 1.5rem 1.5rem 0; border-radius: 1.25rem 1.25rem 0 0;">
                    <h5 class="mb-0 fw-bold d-flex align-items-center" style="color: #1b1b1b;">
                        <i class="fas fa-chart-line me-2" style="color: #28a745;"></i>
                        Skill Levels
                    </h5>
                </div>
                <div class="card-body p-4">
                    @foreach($skillLevels as $level)
                        @php
                            $isCurrentLevel = $currentSkillLevel && $currentSkillLevel->id === $level->id;
                            $isUnlocked = $userPoints >= $level->min_points;
                        @endphp
                        <div class="d-flex align-items-center p-3 mb-3 rounded-3 {{ $isCurrentLevel ? 'border' : '' }}" 
                             style="background: {{ $isCurrentLevel ? 'rgba(192, 36, 37, 0.05)' : ($isUnlocked ? 'rgba(40, 167, 69, 0.05)' : 'rgba(0, 0, 0, 0.02)') }}; 
                                     border: 1px solid {{ $isCurrentLevel ? 'rgba(192, 36, 37, 0.2)' : ($isUnlocked ? 'rgba(40, 167, 69, 0.1)' : 'rgba(0, 0, 0, 0.05)') }} !important;">
                            <div class="me-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 45px; height: 45px; background: {{ $isCurrentLevel ? 'linear-gradient(135deg, #c02425 0%, #d63031 100%)' : ($isUnlocked ? 'linear-gradient(135deg, #28a745 0%, #20c997 100%)' : 'linear-gradient(135deg, #6c757d 0%, #adb5bd 100%)') }}; color: white;">
                                    <i class="fas {{ $level->icon ?? 'fa-star' }}" style="font-size: 1.2rem;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h6 class="mb-0 fw-semibold" style="color: #1b1b1b;">{{ $level->name }}</h6>
                                    @if($isCurrentLevel)
                                        <span class="badge px-2 py-1" style="background: rgba(192, 36, 37, 0.2); color: #c02425; font-size: 0.7rem;">Current</span>
                                    @elseif($isUnlocked)
                                        <span class="badge px-2 py-1" style="background: rgba(40, 167, 69, 0.2); color: #28a745; font-size: 0.7rem;">
                                            <i class="fas fa-check"></i>
                                        </span>
                                    @else
                                        <span class="badge px-2 py-1" style="background: rgba(108, 117, 125, 0.2); color: #6c757d; font-size: 0.7rem;">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                    @endif
                                </div>
                                <small class="text-muted d-block">{{ number_format($level->min_points) }}+ points</small>
                                @if($level->perks && count($level->perks) > 0)
                                    <div class="d-flex flex-wrap gap-1 mt-2">
                                        @foreach(array_slice($level->perks, 0, 2) as $perk)
                                            <span class="badge" style="background: rgba({{ str_replace('#', '', $level->color) }}, 0.1); color: {{ $level->color }}; font-size: 0.65rem; padding: 0.25rem 0.5rem;">
                                                {{ $perk }}
                                            </span>
                                        @endforeach
                                        @if(count($level->perks) > 2)
                                            <span class="badge" style="background: rgba(0, 0, 0, 0.05); color: #6c757d; font-size: 0.65rem; padding: 0.25rem 0.5rem;">
                                                +{{ count($level->perks) - 2 }}
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
