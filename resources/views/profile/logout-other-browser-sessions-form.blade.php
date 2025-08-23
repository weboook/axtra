<div>
    <div class="card border-0" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
        <div class="card-header" style="background: transparent; border-bottom: 1px solid rgba(0, 0, 0, 0.05); padding: 1.5rem 1.5rem 0; border-radius: 1.25rem 1.25rem 0 0;">
            <h5 class="mb-0 fw-bold d-flex align-items-center" style="color: #1b1b1b;">
                <i class="fas fa-desktop me-2" style="color: #c02425;"></i>
                Browser Sessions
            </h5>
            <p class="text-muted mb-0 mt-1" style="font-size: 0.9rem;">Manage and log out your active sessions on other browsers and devices.</p>
        </div>
        <div class="card-body p-4">
            <!-- Description -->
            <div class="alert alert-info d-flex align-items-start mb-4" style="border-radius: 1rem; border: none;">
                <i class="fas fa-info-circle me-3 mt-1"></i>
                <div>
                    <h6 class="fw-semibold mb-1">Session Management</h6>
                    <p class="mb-0" style="font-size: 0.9rem;">
                        If necessary, you may log out of all of your other browser sessions across all of your devices. Some of your recent sessions are listed below; however, this list may not be exhaustive. If you feel your account has been compromised, you should also update your password.
                    </p>
                </div>
            </div>

            @if (count($this->sessions) > 0)
                <!-- Active Sessions -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="fw-semibold mb-3" style="color: #1b1b1b;">Active Sessions</h6>
                        <div class="row g-3">
                            @foreach ($this->sessions as $session)
                                <div class="col-md-6">
                                    <div class="p-3 border rounded-3" style="border-color: #e0e6ed !important; background: #f8f9fa;">
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                @if ($session->agent->isDesktop())
                                                    <i class="fas fa-desktop" style="font-size: 1.5rem; color: #6c757d;"></i>
                                                @else
                                                    <i class="fas fa-mobile-alt" style="font-size: 1.5rem; color: #6c757d;"></i>
                                                @endif
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 fw-semibold" style="font-size: 0.9rem; color: #1b1b1b;">
                                                    {{ $session->agent->platform() ? $session->agent->platform() : 'Unknown' }} - {{ $session->agent->browser() ? $session->agent->browser() : 'Unknown' }}
                                                </h6>
                                                <div class="d-flex align-items-center gap-2" style="font-size: 0.8rem;">
                                                    <span class="text-muted">{{ $session->ip_address }}</span>
                                                    @if ($session->is_current_device)
                                                        <span class="badge bg-success rounded-pill">This device</span>
                                                    @else
                                                        <span class="text-muted">Last active {{ $session->last_active }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Actions -->
            <div class="d-flex justify-content-between align-items-center pt-3" style="border-top: 1px solid rgba(0, 0, 0, 0.05);">
                @if (session()->has('loggedOut'))
                    <div class="text-success d-flex align-items-center" style="font-size: 0.9rem;">
                        <i class="fas fa-check-circle me-2"></i>
                        Sessions logged out successfully!
                    </div>
                @else
                    <div></div>
                @endif

                <button type="button" class="btn btn-outline-danger px-4 py-2" 
                        style="border-radius: 1rem;" 
                        wire:click="confirmLogout" wire:loading.attr="disabled">
                    <span wire:loading.remove>
                        <i class="fas fa-sign-out-alt me-2"></i>Log Out Other Sessions
                    </span>
                    <span wire:loading>
                        <i class="fas fa-spinner fa-spin me-2"></i>Loading...
                    </span>
                </button>
            </div>
        </div>
    </div>

    <!-- Log Out Other Devices Confirmation Modal -->
    <div class="modal fade" id="confirmLogoutModal" tabindex="-1" aria-labelledby="confirmLogoutModalLabel" aria-hidden="true" 
         wire:ignore.self 
         x-data="{ show: @entangle('confirmingLogout') }" 
         x-show="show" 
         x-on:keydown.escape.window="show = false"
         style="display: none;"
         x-transition>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0" style="border-radius: 1.25rem; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);">
                <div class="modal-header" style="background: transparent; border-bottom: 1px solid rgba(0, 0, 0, 0.05); padding: 1.5rem 1.5rem 0; border-radius: 1.25rem 1.25rem 0 0;">
                    <h5 class="modal-title fw-bold d-flex align-items-center" id="confirmLogoutModalLabel" style="color: #1b1b1b;">
                        <i class="fas fa-exclamation-triangle me-2" style="color: #dc3545;"></i>
                        Log Out Other Browser Sessions
                    </h5>
                    <button type="button" class="btn-close" x-on:click="show = false" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="mb-3" style="color: #6c757d;">
                        Please enter your password to confirm you would like to log out of your other browser sessions across all of your devices.
                    </p>
                    
                    <div x-data="{}" x-on:confirming-logout-other-browser-sessions.window="setTimeout(() => $refs.password.focus(), 250)">
                        <label for="confirmPassword" class="form-label fw-semibold" style="color: #1b1b1b;">Password</label>
                        <input type="password" id="confirmPassword"
                               class="form-control @error('password') is-invalid @enderror" 
                               style="border-radius: 1rem; padding: 0.75rem 1rem; border: 1px solid #e0e6ed; font-size: 0.95rem;"
                               autocomplete="current-password"
                               placeholder="Enter your password"
                               x-ref="password"
                               wire:model="password"
                               wire:keydown.enter="logoutOtherBrowserSessions">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer" style="background: transparent; border-top: 1px solid rgba(0, 0, 0, 0.05); padding: 0 1.5rem 1.5rem; border-radius: 0 0 1.25rem 1.25rem;">
                    <button type="button" class="btn btn-outline-secondary px-4 py-2 me-2" 
                            style="border-radius: 1rem;" 
                            x-on:click="show = false" wire:loading.attr="disabled">
                        Cancel
                    </button>
                    <button type="button" class="btn px-4 py-2" 
                            style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border-radius: 1rem; border: none;"
                            wire:click="logoutOtherBrowserSessions" wire:loading.attr="disabled">
                        <span wire:loading.remove>
                            <i class="fas fa-sign-out-alt me-2"></i>Log Out Other Sessions
                        </span>
                        <span wire:loading>
                            <i class="fas fa-spinner fa-spin me-2"></i>Logging out...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('confirming-logout-other-browser-sessions', () => {
            document.querySelector('[x-data]').__x.$data.show = true;
        });
    });
    </script>
</div>
