<div class="card border-0" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
    <div class="card-header" style="background: transparent; border-bottom: 1px solid rgba(0, 0, 0, 0.05); padding: 1.5rem 1.5rem 0; border-radius: 1.25rem 1.25rem 0 0;">
        <h5 class="mb-0 fw-bold d-flex align-items-center" style="color: #1b1b1b;">
            <i class="fas fa-user-edit me-2" style="color: #c02425;"></i>
            Profile Information
        </h5>
        <p class="text-muted mb-0 mt-1" style="font-size: 0.9rem;">Update your account's profile information and email address.</p>
    </div>
    <div class="card-body p-4">
        <form wire:submit="updateProfileInformation">
            <div class="row g-4">
                <!-- Profile Photo -->
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="col-12" x-data="{photoName: null, photoPreview: null}">
                        <label class="form-label fw-semibold" style="color: #1b1b1b;">Profile Photo</label>
                        
                        <!-- Profile Photo File Input -->
                        <input type="file" id="photo" class="d-none"
                                    wire:model.live="photo"
                                    x-ref="photo"
                                    x-on:change="
                                            photoName = $refs.photo.files[0].name;
                                            const reader = new FileReader();
                                            reader.onload = (e) => {
                                                photoPreview = e.target.result;
                                            };
                                            reader.readAsDataURL($refs.photo.files[0]);
                                    " />

                        <div class="d-flex align-items-center gap-3">
                            <!-- Current Profile Photo -->
                            <div x-show="! photoPreview">
                                <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" 
                                     class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover; border: 3px solid #f8f9fa;">
                            </div>

                            <!-- New Profile Photo Preview -->
                            <div x-show="photoPreview" style="display: none;">
                                <div class="rounded-circle" style="width: 80px; height: 80px; border: 3px solid #f8f9fa;"
                                      x-bind:style="'background-image: url(' + photoPreview + '); background-size: cover; background-position: center;'">
                                </div>
                            </div>

                            <div>
                                <button type="button" class="btn btn-outline-primary me-2" x-on:click.prevent="$refs.photo.click()" style="border-radius: 1rem;">
                                    <i class="fas fa-camera me-2"></i>Select New Photo
                                </button>

                                @if ($this->user->profile_photo_path)
                                    <button type="button" class="btn btn-outline-danger" wire:click="deleteProfilePhoto" style="border-radius: 1rem;">
                                        <i class="fas fa-trash me-2"></i>Remove
                                    </button>
                                @endif
                            </div>
                        </div>

                        @error('photo')
                            <div class="text-danger mt-2" style="font-size: 0.875rem;">{{ $message }}</div>
                        @enderror
                    </div>
                @endif

                <!-- Name -->
                <div class="col-md-6">
                    <label for="name" class="form-label fw-semibold" style="color: #1b1b1b;">Full Name</label>
                    <input id="name" type="text" 
                           class="form-control @error('name') is-invalid @enderror" 
                           style="border-radius: 1rem; padding: 0.75rem 1rem; border: 1px solid #e0e6ed; font-size: 0.95rem;"
                           wire:model="state.name" required autocomplete="name" 
                           placeholder="Enter your full name">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="col-md-6">
                    <label for="email" class="form-label fw-semibold" style="color: #1b1b1b;">Email Address</label>
                    <input id="email" type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           style="border-radius: 1rem; padding: 0.75rem 1rem; border: 1px solid #e0e6ed; font-size: 0.95rem;"
                           wire:model="state.email" required autocomplete="username" 
                           placeholder="Enter your email address">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
                        <div class="alert alert-warning mt-3 d-flex align-items-center" style="border-radius: 1rem; border: none;">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <div>
                                <strong>Email Not Verified</strong>
                                <p class="mb-1">Your email address is unverified.</p>
                                <button type="button" class="btn btn-sm btn-outline-warning" wire:click.prevent="sendEmailVerification" style="border-radius: 0.75rem;">
                                    <i class="fas fa-envelope me-1"></i>Resend Verification Email
                                </button>
                            </div>
                        </div>

                        @if ($this->verificationLinkSent)
                            <div class="alert alert-success mt-2 d-flex align-items-center" style="border-radius: 1rem; border: none;">
                                <i class="fas fa-check-circle me-2"></i>
                                A new verification link has been sent to your email address.
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4 pt-3" style="border-top: 1px solid rgba(0, 0, 0, 0.05);">
                @if (session()->has('saved'))
                    <div class="text-success d-flex align-items-center" style="font-size: 0.9rem;">
                        <i class="fas fa-check-circle me-2"></i>
                        Profile updated successfully!
                    </div>
                @else
                    <div></div>
                @endif

                <button type="submit" class="btn px-4 py-2" 
                        style="background: linear-gradient(135deg, #c02425 0%, #d63031 100%); color: white; border-radius: 1rem; border: none;"
                        wire:loading.attr="disabled" wire:target="photo">
                    <span wire:loading.remove wire:target="photo">
                        <i class="fas fa-save me-2"></i>Save Changes
                    </span>
                    <span wire:loading wire:target="photo">
                        <i class="fas fa-spinner fa-spin me-2"></i>Saving...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
