<div class="modal fade show" style="display: block; background: rgba(0,0,0,0.5);">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 16px;">
            <div class="modal-header border-0 p-4">
                <h5 class="modal-title fw-bold">Create New User</h5>
                <button type="button" class="btn-close" wire:click="$dispatch('closeModals')"></button>
            </div>
            <form wire:submit="createUser">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <!-- Basic Information -->
                        <div class="col-12">
                            <h6 class="fw-semibold text-primary mb-3">Basic Information</h6>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Full Name *</label>
                            <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror" 
                                   placeholder="Enter full name" style="border-radius: 8px;">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email Address *</label>
                            <input type="email" wire:model="email" class="form-control @error('email') is-invalid @enderror" 
                                   placeholder="Enter email address" style="border-radius: 8px;">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Phone Number</label>
                            <input type="tel" wire:model="phone" class="form-control @error('phone') is-invalid @enderror" 
                                   placeholder="Enter phone number" style="border-radius: 8px;">
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Date of Birth</label>
                            <input type="date" wire:model="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror" 
                                   style="border-radius: 8px;">
                            @error('date_of_birth') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Account Credentials -->
                        <div class="col-12 mt-4">
                            <h6 class="fw-semibold text-primary mb-3">Account Credentials</h6>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Password *</label>
                            <div class="input-group">
                                <input type="password" wire:model="password" class="form-control @error('password') is-invalid @enderror" 
                                       placeholder="Enter password" style="border-radius: 8px 0 0 8px;">
                                <button type="button" class="btn btn-outline-secondary" wire:click="generatePassword"
                                        style="border-radius: 0 8px 8px 0;">
                                    <i class="fas fa-random"></i>
                                </button>
                            </div>
                            @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            <small class="text-muted">Click the button to generate a random password</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Confirm Password *</label>
                            <input type="password" wire:model="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" 
                                   placeholder="Confirm password" style="border-radius: 8px;">
                            @error('password_confirmation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Role & Permissions -->
                        <div class="col-12 mt-4">
                            <h6 class="fw-semibold text-primary mb-3">Role & Permissions</h6>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">User Role *</label>
                            <select wire:model="role" class="form-select @error('role') is-invalid @enderror" 
                                    style="border-radius: 8px;">
                                <option value="customer">Customer</option>
                                <option value="employee">Employee</option>
                                <option value="admin">Admin</option>
                            </select>
                            @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Skill Level</label>
                            <select wire:model="skill_level" class="form-select @error('skill_level') is-invalid @enderror" 
                                    style="border-radius: 8px;">
                                <option value="beginner">Beginner</option>
                                <option value="intermediate">Intermediate</option>
                                <option value="advanced">Advanced</option>
                                <option value="expert">Expert</option>
                                <option value="master">Master</option>
                            </select>
                            @error('skill_level') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Skill Points</label>
                            <input type="number" wire:model="skill_points" class="form-control @error('skill_points') is-invalid @enderror" 
                                   min="0" placeholder="0" style="border-radius: 8px;">
                            @error('skill_points') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Additional Settings -->
                        <div class="col-12 mt-4">
                            <h6 class="fw-semibold text-primary mb-3">Additional Settings</h6>
                        </div>

                        <div class="col-12">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" wire:model="whatsapp_notifications" id="whatsapp_notifications">
                                        <label class="form-check-label fw-semibold" for="whatsapp_notifications">
                                            WhatsApp Notifications
                                        </label>
                                        <small class="d-block text-muted">Allow WhatsApp notifications for this user</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" wire:model="hidden_from_leaderboard" id="hidden_from_leaderboard">
                                        <label class="form-check-label fw-semibold" for="hidden_from_leaderboard">
                                            Hide from Leaderboard
                                        </label>
                                        <small class="d-block text-muted">User won't appear on public leaderboards</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Admin Notes</label>
                            <textarea wire:model="admin_notes" class="form-control @error('admin_notes') is-invalid @enderror" 
                                      rows="3" placeholder="Internal notes about this user (not visible to user)" 
                                      style="border-radius: 8px;"></textarea>
                            @error('admin_notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="text-muted">These notes are only visible to administrators</small>
                        </div>

                        @if($password)
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Generated Password:</strong> <code>{{ $password }}</code>
                                    <br><small>Make sure to share this password securely with the new user.</small>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer border-0 p-4">
                    <button type="button" class="btn btn-secondary" wire:click="$dispatch('closeModals')">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="background: #c02425; border-color: #c02425;">
                        <i class="fas fa-plus me-2"></i>Create User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('user-created', () => {
            window.dispatchEvent(new CustomEvent('closeModals'));
        });
    });

    window.addEventListener('closeModals', () => {
        @this.dispatch('closeModals');
    });
</script>
@endpush