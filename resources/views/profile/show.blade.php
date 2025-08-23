<x-app-layout>
    <div>
        <!-- Profile Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0" style="background: linear-gradient(135deg, #c02425 0%, #d63031 100%); color: white; border-radius: 1.5rem; box-shadow: 0 20px 60px rgba(192, 36, 37, 0.3);">
                    <div class="card-body py-4 px-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h2 class="mb-2 fw-bold">Profile Settings</h2>
                                <p class="mb-3 opacity-90" style="font-size: 1.1rem;">Manage your account information and security settings</p>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user-cog me-2"></i>
                                    <span>Keep your account secure and up to date</span>
                                </div>
                            </div>
                            <div class="d-none d-md-block">
                                <i class="fas fa-user-shield" style="font-size: 4rem; opacity: 0.3;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Content -->
        <div class="row">
            <div class="col-12">
                @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                    <div class="mb-4">
                        @livewire('profile.update-profile-information-form')
                    </div>
                @endif

                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                    <div class="mb-4">
                        @livewire('profile.update-password-form')
                    </div>
                @endif

                @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                    <div class="mb-4">
                        @livewire('profile.two-factor-authentication-form')
                    </div>
                @endif

                <div class="mb-4">
                    @livewire('profile.logout-other-browser-sessions-form')
                </div>

                @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                    <div class="mb-4">
                        @livewire('profile.delete-user-form')
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
