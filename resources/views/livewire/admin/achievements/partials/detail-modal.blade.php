<!-- Achievement Detail Modal -->
@if($showDetailModal && $selectedAchievement)
<div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Achievement Details - {{ $selectedAchievement->name }}</h5>
                <button type="button" class="btn-close" wire:click="closeModals"></button>
            </div>
            <div class="modal-body">
                <div class="row g-4">
                    <!-- Achievement Information -->
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header">
                                <h6 class="card-title mb-0"><i class="fas fa-info-circle me-2"></i>Achievement Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="me-3 d-flex align-items-center justify-content-center" 
                                         style="width: 60px; height: 60px; background: {{ $selectedAchievement->color }}15; border: 2px solid {{ $selectedAchievement->color }}; border-radius: 16px;">
                                        <i class="{{ $selectedAchievement->icon }}" style="color: {{ $selectedAchievement->color }}; font-size: 1.8rem;"></i>
                                    </div>
                                    <div>
                                        <h4 class="mb-1">{{ $selectedAchievement->name }}</h4>
                                        <div class="d-flex gap-2 mb-2">
                                            <span class="badge bg-{{ $selectedAchievement->type === 'milestone' ? 'primary' : ($selectedAchievement->type === 'streak' ? 'success' : ($selectedAchievement->type === 'total' ? 'info' : 'warning')) }}">
                                                {{ ucfirst($selectedAchievement->type) }}
                                            </span>
                                            <span class="badge bg-{{ $selectedAchievement->is_active ? 'success' : 'danger' }}">
                                                {{ $selectedAchievement->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                            @if($selectedAchievement->is_hidden)
                                            <span class="badge bg-warning text-dark">Hidden</span>
                                            @endif
                                        </div>
                                        <span class="badge bg-dark">{{ $selectedAchievement->points_reward }} points reward</span>
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-12">
                                        <small class="text-muted">Description</small>
                                        <div class="bg-light p-3 rounded mt-1">
                                            {{ $selectedAchievement->description }}
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Display Order</small>
                                        <div class="fw-bold">{{ $selectedAchievement->order }}</div>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Times Earned</small>
                                        <div class="fw-bold text-success">{{ $selectedAchievement->user_achievements_count }}</div>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Created</small>
                                        <div class="fw-bold">{{ $selectedAchievement->created_at->format('M j, Y') }}</div>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Last Updated</small>
                                        <div class="fw-bold">{{ $selectedAchievement->updated_at->format('M j, Y') }}</div>
                                    </div>
                                    @if($selectedAchievement->requirements)
                                    <div class="col-12">
                                        <small class="text-muted">Requirements</small>
                                        <div class="bg-light p-3 rounded mt-1">
                                            <code>{{ is_array($selectedAchievement->requirements) ? json_encode($selectedAchievement->requirements, JSON_PRETTY_PRINT) : $selectedAchievement->requirements }}</code>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Achievement Statistics -->
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header">
                                <h6 class="card-title mb-0"><i class="fas fa-chart-bar me-2"></i>Achievement Statistics</h6>
                            </div>
                            <div class="card-body">
                                @php
                                    $totalUsers = \App\Models\User::count();
                                    $earnedCount = $selectedAchievement->user_achievements_count;
                                    $earnedPercentage = $totalUsers > 0 ? round(($earnedCount / $totalUsers) * 100, 1) : 0;
                                    $recentEarners = $selectedAchievement->userAchievements()->with('user')->orderBy('created_at', 'desc')->limit(5)->get();
                                @endphp

                                <div class="row g-3 mb-4">
                                    <div class="col-6">
                                        <div class="text-center">
                                            <div class="h3 text-primary mb-1">{{ $earnedCount }}</div>
                                            <small class="text-muted">Times Earned</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-center">
                                            <div class="h3 text-success mb-1">{{ $earnedPercentage }}%</div>
                                            <small class="text-muted">of Users</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Progress Bar -->
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between mb-1">
                                        <small class="text-muted">Completion Rate</small>
                                        <small class="text-muted">{{ $earnedCount }}/{{ $totalUsers }}</small>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $earnedPercentage }}%"></div>
                                    </div>
                                </div>

                                <!-- Rarity Badge -->
                                <div class="mb-4 text-center">
                                    @if($earnedPercentage >= 75)
                                        <span class="badge bg-secondary px-3 py-2">Common Achievement</span>
                                    @elseif($earnedPercentage >= 50)
                                        <span class="badge bg-success px-3 py-2">Uncommon Achievement</span>
                                    @elseif($earnedPercentage >= 25)
                                        <span class="badge bg-warning px-3 py-2">Rare Achievement</span>
                                    @elseif($earnedPercentage >= 10)
                                        <span class="badge bg-danger px-3 py-2">Epic Achievement</span>
                                    @else
                                        <span class="badge bg-dark px-3 py-2">Legendary Achievement</span>
                                    @endif
                                </div>

                                <!-- Recent Earners -->
                                @if($recentEarners->isNotEmpty())
                                <div>
                                    <small class="text-muted mb-2 d-block">Recent Earners</small>
                                    <div class="d-flex flex-column gap-2">
                                        @foreach($recentEarners as $userAchievement)
                                        <div class="d-flex align-items-center p-2 bg-light rounded">
                                            <div class="me-2">
                                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 28px; height: 28px;">
                                                    <span class="text-white fw-bold" style="font-size: 0.7rem;">{{ substr($userAchievement->user->name, 0, 2) }}</span>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 min-w-0">
                                                <div class="fw-semibold text-truncate" style="font-size: 0.9rem;">{{ $userAchievement->user->name }}</div>
                                                <small class="text-muted">{{ $userAchievement->created_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Users Who Earned This Achievement -->
                    @if($selectedAchievement->userAchievements->isNotEmpty())
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title mb-0">
                                    <i class="fas fa-users me-2"></i>
                                    Users Who Earned This Achievement ({{ $selectedAchievement->user_achievements_count }})
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-2">
                                    @foreach($selectedAchievement->userAchievements->take(16) as $userAchievement)
                                    <div class="col-md-3">
                                        <div class="d-flex align-items-center p-2 bg-light rounded">
                                            <div class="me-2">
                                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                    <span class="text-white fw-bold" style="font-size: 0.8rem;">{{ substr($userAchievement->user->name, 0, 2) }}</span>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 min-w-0">
                                                <div class="fw-semibold text-truncate" style="font-size: 0.9rem;">{{ $userAchievement->user->name }}</div>
                                                <small class="text-muted">{{ $userAchievement->created_at->format('M j') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    @if($selectedAchievement->user_achievements_count > 16)
                                    <div class="col-12">
                                        <small class="text-muted">And {{ $selectedAchievement->user_achievements_count - 16 }} more users...</small>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body text-center py-5">
                                <i class="fas fa-users-slash fa-3x text-muted mb-3"></i>
                                <h6 class="text-muted">No Users Have Earned This Achievement Yet</h6>
                                <small class="text-muted">This achievement is waiting for its first earner!</small>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" wire:click="closeModals">Close</button>
                <button type="button" class="btn btn-outline-primary" wire:click="showEditAchievement({{ $selectedAchievement->id }})">
                    <i class="fas fa-edit me-2"></i>Edit Achievement
                </button>
                @if($selectedAchievement->userAchievements()->count() === 0)
                <button type="button" wire:click="deleteAchievement({{ $selectedAchievement->id }})" 
                        class="btn btn-outline-danger"
                        onclick="return confirm('Are you sure you want to delete this achievement?')">
                    <i class="fas fa-trash me-2"></i>Delete Achievement
                </button>
                @endif
            </div>
        </div>
    </div>
</div>
@endif