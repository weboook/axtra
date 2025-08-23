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

class GoogleController extends Controller
{
    /**
     * Redirect to Google OAuth
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Check if user already exists with this email
            $existingUser = User::where('email', $googleUser->getEmail())->first();
            
            if ($existingUser) {
                // User exists - update Google ID if not set
                if (!$existingUser->google_id) {
                    $existingUser->update([
                        'google_id' => $googleUser->getId(),
                        'avatar' => $googleUser->getAvatar(),
                    ]);
                }
                
                Auth::login($existingUser, true);
                
                return redirect()->intended(route('dashboard'))->with('message', 'Welcome back! You have been signed in with Google.');
            }
            
            // Create new user
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'email_verified_at' => now(), // Google emails are pre-verified
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
            
            return redirect()->route('dashboard')->with('message', 'Welcome to Axtra! Your account has been created with Google.');
            
        } catch (\Exception $e) {
            \Log::error('Google OAuth Error: ' . $e->getMessage());
            
            return redirect()->route('login')
                ->withErrors(['google' => 'Unable to sign in with Google. Please try again or use email/password.']);
        }
    }
}