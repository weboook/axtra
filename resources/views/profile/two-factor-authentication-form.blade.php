<div class="card border-0" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
    <div class="card-header" style="background: transparent; border-bottom: 1px solid rgba(0, 0, 0, 0.05); padding: 1.5rem 1.5rem 0; border-radius: 1.25rem 1.25rem 0 0;">
        <h5 class="mb-0 fw-bold d-flex align-items-center" style="color: #1b1b1b;">
            <i class="fas fa-shield-alt me-2" style="color: #c02425;"></i>
            Two Factor Authentication
        </h5>
        <p class="text-muted mb-0 mt-1" style="font-size: 0.9rem;">Add additional security to your account using two factor authentication.</p>
    </div>
    <div class="card-body p-4">
        <!-- Status -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="p-3 rounded-3" style="border: 1px solid {{ $this->enabled ? '#28a745' : '#6c757d' }}; background: {{ $this->enabled ? 'rgba(40, 167, 69, 0.05)' : 'rgba(108, 117, 125, 0.05)' }};">
                    <div class="d-flex align-items-center">
                        <i class="fas {{ $this->enabled ? 'fa-check-circle text-success' : 'fa-times-circle text-muted' }} me-3" style="font-size: 1.5rem;"></i>
                        <div>
                            <h6 class="mb-1 fw-semibold" style="color: #1b1b1b;">
                                @if ($this->enabled)
                                    @if ($showingConfirmation)
                                        Finish enabling two factor authentication
                                    @else
                                        Two factor authentication is enabled
                                    @endif
                                @else
                                    Two factor authentication is disabled
                                @endif
                            </h6>
                            <p class="mb-0 text-muted" style="font-size: 0.85rem;">
                                When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone's Google Authenticator application.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($this->enabled)
            @if ($showingQrCode)
                <!-- QR Code Section -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="alert alert-info d-flex align-items-start" style="border-radius: 1rem; border: none;">
                            <i class="fas fa-info-circle me-3 mt-1"></i>
                            <div>
                                <h6 class="fw-semibold mb-1">
                                    @if ($showingConfirmation)
                                        Setup Instructions
                                    @else
                                        QR Code Available
                                    @endif
                                </h6>
                                <p class="mb-0" style="font-size: 0.9rem;">
                                    @if ($showingConfirmation)
                                        To finish enabling two factor authentication, scan the following QR code using your phone's authenticator application or enter the setup key and provide the generated OTP code.
                                    @else
                                        Two factor authentication is now enabled. Scan the following QR code using your phone's authenticator application or enter the setup key.
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="text-center">
                            <h6 class="fw-semibold mb-3" style="color: #1b1b1b;">QR Code</h6>
                            <div class="p-3 d-inline-block bg-white rounded-3" style="border: 1px solid #e0e6ed;">
                                {!! $this->user->twoFactorQrCodeSvg() !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-semibold mb-3" style="color: #1b1b1b;">Setup Key</h6>
                        <div class="p-3 bg-light rounded-3" style="border: 1px solid #e0e6ed;">
                            <code style="font-size: 0.9rem; color: #1b1b1b;">{{ decrypt($this->user->two_factor_secret) }}</code>
                        </div>
                    </div>
                </div>

                @if ($showingConfirmation)
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="code" class="form-label fw-semibold" style="color: #1b1b1b;">Verification Code</label>
                            <input id="code" type="text" 
                                   class="form-control @error('code') is-invalid @enderror" 
                                   style="border-radius: 1rem; padding: 0.75rem 1rem; border: 1px solid #e0e6ed; font-size: 0.95rem;"
                                   wire:model="code" inputmode="numeric" autofocus autocomplete="one-time-code"
                                   wire:keydown.enter="confirmTwoFactorAuthentication"
                                   placeholder="Enter 6-digit code">
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                @endif
            @endif

            @if ($showingRecoveryCodes)
                <!-- Recovery Codes Section -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="alert alert-warning d-flex align-items-start" style="border-radius: 1rem; border: none;">
                            <i class="fas fa-exclamation-triangle me-3 mt-1"></i>
                            <div>
                                <h6 class="fw-semibold mb-1">Important: Save Your Recovery Codes</h6>
                                <p class="mb-0" style="font-size: 0.9rem;">
                                    Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two factor authentication device is lost.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-8">
                        <div class="p-3 bg-light rounded-3" style="border: 1px solid #e0e6ed;">
                            <div class="row g-2">
                                @foreach (json_decode(decrypt($this->user->two_factor_recovery_codes), true) as $code)
                                    <div class="col-md-6">
                                        <code class="d-block p-2 bg-white rounded text-center" style="font-size: 0.9rem; color: #1b1b1b; border: 1px solid #e0e6ed;">{{ $code }}</code>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif

        <!-- Actions -->
        <div class="d-flex flex-wrap gap-2 pt-3" style="border-top: 1px solid rgba(0, 0, 0, 0.05);">
            @if (! $this->enabled)
                <x-confirms-password wire:then="enableTwoFactorAuthentication">
                    <button type="button" class="btn px-4 py-2" 
                            style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; border-radius: 1rem; border: none;"
                            wire:loading.attr="disabled">
                        <span wire:loading.remove>
                            <i class="fas fa-shield-alt me-2"></i>Enable 2FA
                        </span>
                        <span wire:loading>
                            <i class="fas fa-spinner fa-spin me-2"></i>Enabling...
                        </span>
                    </button>
                </x-confirms-password>
            @else
                @if ($showingRecoveryCodes)
                    <x-confirms-password wire:then="regenerateRecoveryCodes">
                        <button type="button" class="btn btn-outline-primary px-4 py-2" 
                                style="border-radius: 1rem;">
                            <i class="fas fa-sync me-2"></i>Regenerate Recovery Codes
                        </button>
                    </x-confirms-password>
                @elseif ($showingConfirmation)
                    <x-confirms-password wire:then="confirmTwoFactorAuthentication">
                        <button type="button" class="btn px-4 py-2 me-2" 
                                style="background: linear-gradient(135deg, #c02425 0%, #d63031 100%); color: white; border-radius: 1rem; border: none;"
                                wire:loading.attr="disabled">
                            <span wire:loading.remove>
                                <i class="fas fa-check me-2"></i>Confirm
                            </span>
                            <span wire:loading>
                                <i class="fas fa-spinner fa-spin me-2"></i>Confirming...
                            </span>
                        </button>
                    </x-confirms-password>
                @else
                    <x-confirms-password wire:then="showRecoveryCodes">
                        <button type="button" class="btn btn-outline-info px-4 py-2" 
                                style="border-radius: 1rem;">
                            <i class="fas fa-key me-2"></i>Show Recovery Codes
                        </button>
                    </x-confirms-password>
                @endif

                @if ($showingConfirmation)
                    <x-confirms-password wire:then="disableTwoFactorAuthentication">
                        <button type="button" class="btn btn-outline-secondary px-4 py-2" 
                                style="border-radius: 1rem;" wire:loading.attr="disabled">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>
                    </x-confirms-password>
                @else
                    <x-confirms-password wire:then="disableTwoFactorAuthentication">
                        <button type="button" class="btn btn-outline-danger px-4 py-2" 
                                style="border-radius: 1rem;" wire:loading.attr="disabled">
                            <i class="fas fa-shield-alt me-2"></i>Disable 2FA
                        </button>
                    </x-confirms-password>
                @endif
            @endif
        </div>
    </div>
</div>
