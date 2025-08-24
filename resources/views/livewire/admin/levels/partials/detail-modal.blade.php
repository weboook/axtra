<!-- Level Detail Modal -->
@if($showDetailModal && $selectedLevel)
<div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Level Details - {{ $selectedLevel->name }}</h5>
                <button type="button" class="btn-close" wire:click="closeModals"></button>
            </div>
            <div class="modal-body">
                <div class="row g-4">
                    <!-- Level Information -->
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header">
                                <h6 class="card-title mb-0"><i class="fas fa-info-circle me-2"></i>Level Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="me-3 d-flex align-items-center justify-content-center" 
                                         style="width: 60px; height: 60px; background: {{ $selectedLevel->color }}15; border: 2px solid {{ $selectedLevel->color }}; border-radius: 16px;">
                                        <i class="{{ $selectedLevel->icon }}" style="color: {{ $selectedLevel->color }}; font-size: 1.8rem;"></i>
                                    </div>
                                    <div>
                                        <h4 class="mb-1">{{ $selectedLevel->name }}</h4>
                                        <span class="badge bg-{{ $selectedLevel->is_active ? 'success' : 'danger' }} me-2">
                                            {{ $selectedLevel->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                        <span class="badge bg-secondary">Order: {{ $selectedLevel->sort_order }}</span>
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-6">
                                        <small class="text-muted">Points Required</small>
                                        <div class="fw-bold text-primary">{{ number_format($selectedLevel->points_required) }}</div>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Users at Level</small>
                                        <div class="fw-bold">{{ $selectedLevel->users_count }}</div>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Created</small>
                                        <div class="fw-bold">{{ $selectedLevel->created_at->format('M j, Y') }}</div>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Last Updated</small>
                                        <div class="fw-bold">{{ $selectedLevel->updated_at->format('M j, Y') }}</div>
                                    </div>
                                    @if($selectedLevel->description)
                                    <div class="col-12">
                                        <small class="text-muted">Description</small>
                                        <div class="bg-light p-3 rounded mt-1">
                                            {{ $selectedLevel->description }}
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Level Progression -->
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header">
                                <h6 class="card-title mb-0"><i class="fas fa-chart-line me-2"></i>Progression Context</h6>
                            </div>
                            <div class="card-body">
                                @php
                                    $previousLevel = $selectedLevel->getPreviousLevel();
                                    $nextLevel = $selectedLevel->getNextLevel();
                                @endphp

                                <!-- Previous Level -->
                                @if($previousLevel)
                                <div class="mb-3">
                                    <small class="text-muted">Previous Level</small>
                                    <div class="d-flex align-items-center mt-1">
                                        <div class="me-2 d-flex align-items-center justify-content-center" 
                                             style="width: 30px; height: 30px; background: {{ $previousLevel->color }}15; border: 1px solid {{ $previousLevel->color }}; border-radius: 8px;">
                                            <i class="{{ $previousLevel->icon }}" style="color: {{ $previousLevel->color }}; font-size: 0.9rem;"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $previousLevel->name }}</div>
                                            <small class="text-muted">{{ number_format($previousLevel->points_required) }} points</small>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <!-- Current Level (Highlighted) -->
                                <div class="mb-3 p-3 bg-primary bg-opacity-10 rounded border border-primary border-opacity-25">
                                    <small class="text-primary fw-semibold">Current Level</small>
                                    <div class="d-flex align-items-center mt-1">
                                        <div class="me-2 d-flex align-items-center justify-content-center" 
                                             style="width: 30px; height: 30px; background: {{ $selectedLevel->color }}; border-radius: 8px;">
                                            <i class="{{ $selectedLevel->icon }}" style="color: white; font-size: 0.9rem;"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $selectedLevel->name }}</div>
                                            <small class="text-muted">{{ number_format($selectedLevel->points_required) }} points</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Next Level -->
                                @if($nextLevel)
                                <div class="mb-3">
                                    <small class="text-muted">Next Level</small>
                                    <div class="d-flex align-items-center mt-1">
                                        <div class="me-2 d-flex align-items-center justify-content-center" 
                                             style="width: 30px; height: 30px; background: {{ $nextLevel->color }}15; border: 1px solid {{ $nextLevel->color }}; border-radius: 8px;">
                                            <i class="{{ $nextLevel->icon }}" style="color: {{ $nextLevel->color }}; font-size: 0.9rem;"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $nextLevel->name }}</div>
                                            <small class="text-muted">{{ number_format($nextLevel->points_required) }} points</small>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div class="alert alert-info">
                                    <i class="fas fa-crown me-2"></i>This is the highest level available!
                                </div>
                                @endif

                                @if($nextLevel)
                                <div class="mt-3">
                                    <small class="text-muted">Points gap to next level</small>
                                    <div class="fw-bold text-success">{{ number_format($nextLevel->points_required - $selectedLevel->points_required) }} points</div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Users at This Level -->
                    @if($selectedLevel->users_count > 0)
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title mb-0">
                                    <i class="fas fa-users me-2"></i>
                                    Users at This Level ({{ $selectedLevel->users_count }})
                                </h6>
                            </div>
                            <div class="card-body">
                                @if($selectedLevel->users->isNotEmpty())
                                <div class="row g-2">
                                    @foreach($selectedLevel->users->take(12) as $user)
                                    <div class="col-md-3">
                                        <div class="d-flex align-items-center p-2 bg-light rounded">
                                            <div class="me-2">
                                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                    <span class="text-white fw-bold" style="font-size: 0.8rem;">{{ substr($user->name, 0, 2) }}</span>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 min-w-0">
                                                <div class="fw-semibold text-truncate" style="font-size: 0.9rem;">{{ $user->name }}</div>
                                                @if($user->pivot && $user->pivot->current_points)
                                                <small class="text-muted">{{ number_format($user->pivot->current_points) }} pts</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    @if($selectedLevel->users_count > 12)
                                    <div class="col-12">
                                        <small class="text-muted">And {{ $selectedLevel->users_count - 12 }} more users...</small>
                                    </div>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" wire:click="closeModals">Close</button>
                <button type="button" class="btn btn-outline-primary" wire:click="showEditLevel({{ $selectedLevel->id }})">
                    <i class="fas fa-edit me-2"></i>Edit Level
                </button>
            </div>
        </div>
    </div>
</div>
@endif