<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Str;

class AppleController extends Controller
{
    /**
     * Redirect to Apple OAuth
     */
    public function redirect()
    {
        return Socialite::driver('apple')->redirect();
    }

    /**
     * Handle Apple OAuth callback
     */
    public function callback()
    {
        try {
            $appleUser = Socialite::driver('apple')->user();
            
            // Check if user already exists with this email
            $existingUser = User::where('email', $appleUser->getEmail())->first();
            
            if ($existingUser) {
                // User exists - update Apple ID if not set
                if (!$existingUser->apple_id) {
                    $existingUser->update([
                        'apple_id' => $appleUser->getId(),
                    ]);
                }
                
                Auth::login($existingUser, true);
                
                return redirect()->intended(route('dashboard'))->with('message', 'Welcome back! You have been signed in with Apple.');
            }
            
            // For Apple, name might not be available on subsequent logins
            $name = $appleUser->getName() ?: $appleUser->getNickname() ?: explode('@', $appleUser->getEmail())[0];
            
            // Create new user
            $user = User::create([
                'name' => $name,
                'email' => $appleUser->getEmail(),
                'apple_id' => $appleUser->getId(),
                'email_verified_at' => now(), // Apple emails are pre-verified
                'password' => Hash::make(Str::random(24)), // Random password
                'role' => 'customer', // Default role
            ]);
            
            // Create a personal team if Jetstream teams are enabled
            if (Jetstream::hasTeamFeatures()) {
                $user->ownedTeams()->save(Team::forceCreate([
                    'user_id' => $user->id,
                    'name' => explode(' ', $user->name, 2)[0]."'s Team",
                    'personal_team' => true,
                ]));
            }
            
            Auth::login($user, true);
            
            return redirect()->route('dashboard')->with('message', 'Welcome to Axtra! Your account has been created with Apple.');
            
        } catch (\Exception $e) {
            \Log::error('Apple OAuth Error: ' . $e->getMessage());
            
            return redirect()->route('login')
                ->withErrors(['apple' => 'Unable to sign in with Apple. Please try again or use email/password.']);
        }
    }
}