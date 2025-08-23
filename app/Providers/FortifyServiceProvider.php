<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\RegisterResponse;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Custom login response to handle booking redirect
        $this->app->instance(LoginResponse::class, new class implements LoginResponse {
            public function toResponse($request)
            {
                // Check if there's an intended URL in session (from booking flow)
                $intendedUrl = session()->pull('intended_url');
                
                if ($intendedUrl) {
                    return redirect($intendedUrl);
                }
                
                // Check if there's a booking state to restore
                if (session()->has('booking_state')) {
                    return redirect()->route('booking.public')->with('restore_booking', true);
                }
                
                // Default role-based redirect
                return redirect()->intended($this->getDefaultRedirectUrl($request->user()));
            }
            
            private function getDefaultRedirectUrl($user)
            {
                return match($user->role) {
                    'admin' => route('admin.dashboard'),
                    'employee' => route('employee.dashboard'),
                    default => route('dashboard'),
                };
            }
        });
        
        // Custom register response to handle booking redirect
        $this->app->instance(RegisterResponse::class, new class implements RegisterResponse {
            public function toResponse($request)
            {
                // Check if there's an intended URL in session (from booking flow)
                $intendedUrl = session()->pull('intended_url');
                
                if ($intendedUrl) {
                    return redirect($intendedUrl);
                }
                
                // Check if there's a booking state to restore
                if (session()->has('booking_state')) {
                    return redirect()->route('booking.public')->with('restore_booking', true);
                }
                
                // Default redirect for new users
                return redirect()->route('dashboard');
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::redirectUserForTwoFactorAuthenticationUsing(RedirectIfTwoFactorAuthenticatable::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
