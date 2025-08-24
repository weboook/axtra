<!-- Edit Achievement Modal -->
@if($showEditModal && $selectedAchievement)
<div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Achievement - {{ $selectedAchievement->name }}</h5>
                <button type="button" class="btn-close" wire:click="closeModals"></button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="updateAchievement">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label">Achievement Name <span class="text-danger">*</span></label>
                            <input type="text" wire:model="form.name" class="form-control @error('form.name') is-invalid @enderror">
                            @error('form.name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Display Order <span class="text-danger">*</span></label>
                            <input type="number" wire:model="form.order" class="form-control @error('form.order') is-invalid @enderror">
                            @error('form.order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea wire:model="form.description" class="form-control @error('form.description') is-invalid @enderror" 
                                      rows="3"></textarea>
                            @error('form.description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Achievement Type <span class="text-danger">*</span></label>
                            <select wire:model="form.type" class="form-select @error('form.type') is-invalid @enderror">
                                <option value="milestone">🎯 Milestone - One-time achievement</option>
                                <option value="streak">🔥 Streak - Consecutive actions</option>
                                <option value="total">📊 Total - Cumulative achievements</option>
                                <option value="special">⭐ Special - Unique/rare achievements</option>
                            </select>
                            @error('form.type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Points Reward <span class="text-danger">*</span></label>
                            <input type="number" wire:model="form.points_reward" class="form-control @error('form.points_reward') is-invalid @enderror"
                                   min="1" max="10000">
                            @error('form.points_reward') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Icon <span class="text-danger">*</span></label>
                            <select wire:model="form.icon" class="form-select @error('form.icon') is-invalid @enderror">
                                <option value="fas fa-trophy">🏆 Trophy</option>
                                <option value="fas fa-medal">🏅 Medal</option>
                                <option value="fas fa-star">⭐ Star</option>
                                <option value="fas fa-crown">👑 Crown</option>
                                <option value="fas fa-gem">💎 Gem</option>
                                <option value="fas fa-fire">🔥 Fire</option>
                                <option value="fas fa-bolt">⚡ Bolt</option>
                                <option value="fas fa-shield-alt">🛡️ Shield</option>
                                <option value="fas fa-target">🎯 Target</option>
                                <option value="fas fa-bullseye">🎯 Bullseye</option>
                                <option value="fas fa-rocket">🚀 Rocket</option>
                                <option value="fas fa-mountain">🏔️ Mountain</option>
                                <option value="fas fa-award">🥇 Award</option>
                                <option value="fas fa-ribbon">🎀 Ribbon</option>
                                <option value="fas fa-magic">✨ Magic</option>
                                <option value="fas fa-heart">❤️ Heart</option>
                                <option value="fas fa-thumbs-up">👍 Thumbs Up</option>
                                <option value="fas fa-certificate">📜 Certificate</option>
                            </select>
                            @error('form.icon') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Achievement Color <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="color" wire:model="form.color" class="form-control form-control-color @error('form.color') is-invalid @enderror">
                                <input type="text" wire:model="form.color" class="form-control @error('form.color') is-invalid @enderror">
                            </div>
                            @error('form.color') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Settings</label>
                            <div class="d-flex flex-column gap-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" wire:model="form.is_active" id="editActive">
                                    <label class="form-check-label" for="editActive">
                                        Active (users can earn this achievement)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" wire:model="form.is_hidden" id="editHidden">
                                    <label class="form-check-label" for="editHidden">
                                        Hidden (achievement is secret until earned)
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Requirements Section -->
                        <div class="col-12">
                            <label class="form-label">Achievement Requirements</label>
                            <div class="card bg-light">
                                <div class="card-body">
                                    <div class="row g-2">
                                        <div class="col-12">
                                            <small class="text-muted">
                                                Define what conditions must be met to earn this achievement. 
                                                Leave empty for manual awarding only.
                                            </small>
                                        </div>
                                        <div class="col-12">
                                            <textarea wire:model="form.requirements" class="form-control" rows="2" 
                                                      placeholder="JSON format requirements (optional)"></textarea>
                                            <small class="text-muted">Advanced: JSON format for automated achievement checking</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- User Earnings Warning -->
                        @if($selectedAchievement->userAchievements()->count() > 0)
                        <div class="col-12">
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Note:</strong> This achievement has been earned by {{ $selectedAchievement->userAchievements()->count() }} user(s). 
                                Changing point values may affect user progression and leaderboards.
                            </div>
                        </div>
                        @endif
                        
                        <!-- Preview -->
                        <div class="col-12">
                            <label class="form-label">Preview</label>
                            <div class="card bg-light">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3 d-flex align-items-center justify-content-center" 
                                             style="width: 50px; height: 50px; background: {{ $form['color'] }}15; border: 2px solid {{ $form['color'] }}; border-radius: 16px;">
                                            <i class="{{ $form['icon'] }}" style="color: {{ $form['color'] }}; font-size: 1.5rem;"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center gap-2">
                                                <h6 class="mb-0">{{ $form['name'] ?: 'Achievement Name' }}</h6>
                                                <span class="badge bg-{{ $form['type'] === 'milestone' ? 'primary' : ($form['type'] === 'streak' ? 'success' : ($form['type'] === 'total' ? 'info' : 'warning')) }}">
                                                    {{ ucfirst($form['type']) }}
                                                </span>
                                                <span class="badge bg-dark">{{ $form['points_reward'] ?: '0' }} pts</span>
                                            </div>
                                            <p class="text-muted mb-0 mt-1">{{ $form['description'] ?: 'Achievement description...' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" wire:click="closeModals">Cancel</button>
                <button type="button" wire:click="updateAchievement" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Update Achievement
                </button>
            </div>
        </div>
    </div>
</div>
@endif