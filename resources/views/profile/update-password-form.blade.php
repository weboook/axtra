<div class="card border-0" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
    <div class="card-header" style="background: transparent; border-bottom: 1px solid rgba(0, 0, 0, 0.05); padding: 1.5rem 1.5rem 0; border-radius: 1.25rem 1.25rem 0 0;">
        <h5 class="mb-0 fw-bold d-flex align-items-center" style="color: #1b1b1b;">
            <i class="fas fa-lock me-2" style="color: #c02425;"></i>
            Update Password
        </h5>
        <p class="text-muted mb-0 mt-1" style="font-size: 0.9rem;">Ensure your account is using a long, random password to stay secure.</p>
    </div>
    <div class="card-body p-4">
        <form wire:submit="updatePassword">
            <div class="row g-4">
                <!-- Current Password -->
                <div class="col-12">
                    <label for="current_password" class="form-label fw-semibold" style="color: #1b1b1b;">Current Password</label>
                    <input id="current_password" type="password" 
                           class="form-control @error('current_password') is-invalid @enderror" 
                           style="border-radius: 1rem; padding: 0.75rem 1rem; border: 1px solid #e0e6ed; font-size: 0.95rem;"
                           wire:model="state.current_password" autocomplete="current-password" 
                           placeholder="Enter your current password">
                    @error('current_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- New Password -->
                <div class="col-md-6">
                    <label for="password" class="form-label fw-semibold" style="color: #1b1b1b;">New Password</label>
                    <input id="password" type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           style="border-radius: 1rem; padding: 0.75rem 1rem; border: 1px solid #e0e6ed; font-size: 0.95rem;"
                           wire:model="state.password" autocomplete="new-password" 
                           placeholder="Enter new password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="col-md-6">
                    <label for="password_confirmation" class="form-label fw-semibold" style="color: #1b1b1b;">Confirm Password</label>
                    <input id="password_confirmation" type="password" 
                           class="form-control @error('password_confirmation') is-invalid @enderror" 
                           style="border-radius: 1rem; padding: 0.75rem 1rem; border: 1px solid #e0e6ed; font-size: 0.95rem;"
                           wire:model="state.password_confirmation" autocomplete="new-password" 
                           placeholder="Confirm new password">
                    @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4 pt-3" style="border-top: 1px solid rgba(0, 0, 0, 0.05);">
                @if (session()->has('saved'))
                    <div class="text-success d-flex align-items-center" style="font-size: 0.9rem;">
                        <i class="fas fa-check-circle me-2"></i>
                        Password updated successfully!
                    </div>
                @else
                    <div></div>
                @endif

                <button type="submit" class="btn px-4 py-2" 
                        style="background: linear-gradient(135deg, #c02425 0%, #d63031 100%); color: white; border-radius: 1rem; border: none;"
                        wire:loading.attr="disabled">
                    <span wire:loading.remove>
                        <i class="fas fa-save me-2"></i>Update Password
                    </span>
                    <span wire:loading>
                        <i class="fas fa-spinner fa-spin me-2"></i>Updating...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
