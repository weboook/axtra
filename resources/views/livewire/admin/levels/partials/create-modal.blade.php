<!-- Create Level Modal -->
@if($showCreateModal)
<div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Level</h5>
                <button type="button" class="btn-close" wire:click="closeModals"></button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="createLevel">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label">Level Name <span class="text-danger">*</span></label>
                            <input type="text" wire:model="form.name" class="form-control @error('form.name') is-invalid @enderror"
                                   placeholder="e.g. Beginner, Intermediate, Expert">
                            @error('form.name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Sort Order <span class="text-danger">*</span></label>
                            <input type="number" wire:model="form.sort_order" class="form-control @error('form.sort_order') is-invalid @enderror">
                            @error('form.sort_order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea wire:model="form.description" class="form-control @error('form.description') is-invalid @enderror" 
                                      rows="3" placeholder="Describe this level and what skills it represents..."></textarea>
                            @error('form.description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Points Required <span class="text-danger">*</span></label>
                            <input type="number" wire:model="form.points_required" class="form-control @error('form.points_required') is-invalid @enderror"
                                   placeholder="0">
                            @error('form.points_required') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Level Color <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="color" wire:model="form.color" class="form-control form-control-color @error('form.color') is-invalid @enderror">
                                <input type="text" wire:model="form.color" class="form-control @error('form.color') is-invalid @enderror">
                            </div>
                            @error('form.color') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Icon <span class="text-danger">*</span></label>
                            <select wire:model="form.icon" class="form-select @error('form.icon') is-invalid @enderror">
                                <option value="fas fa-star">⭐ Star</option>
                                <option value="fas fa-medal">🏅 Medal</option>
                                <option value="fas fa-trophy">🏆 Trophy</option>
                                <option value="fas fa-crown">👑 Crown</option>
                                <option value="fas fa-gem">💎 Gem</option>
                                <option value="fas fa-fire">🔥 Fire</option>
                                <option value="fas fa-bolt">⚡ Bolt</option>
                                <option value="fas fa-shield-alt">🛡️ Shield</option>
                                <option value="fas fa-target">🎯 Target</option>
                                <option value="fas fa-bullseye">🎯 Bullseye</option>
                                <option value="fas fa-rocket">🚀 Rocket</option>
                                <option value="fas fa-mountain">🏔️ Mountain</option>
                            </select>
                            @error('form.icon') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <!-- Preview -->
                        <div class="col-12">
                            <label class="form-label">Preview</label>
                            <div class="card bg-light">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3 d-flex align-items-center justify-content-center" 
                                             style="width: 40px; height: 40px; background: {{ $form['color'] }}15; border: 2px solid {{ $form['color'] }}; border-radius: 12px;">
                                            <i class="{{ $form['icon'] }}" style="color: {{ $form['color'] }}; font-size: 1.2rem;"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $form['name'] ?: 'Level Name' }}</div>
                                            <small class="text-muted">{{ number_format($form['points_required'] ?: 0) }} points required</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model="form.is_active" id="createActive">
                                <label class="form-check-label" for="createActive">
                                    Active (users can achieve this level)
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" wire:click="closeModals">Cancel</button>
                <button type="button" wire:click="createLevel" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Create Level
                </button>
            </div>
        </div>
    </div>
</div>
@endif