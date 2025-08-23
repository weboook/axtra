<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ClaudeBypass
{
    /**
     * Claude-specific bypass token for secure testing
     */
    private const CLAUDE_TOKEN = 'claude_test_2024_secure_bypass_axtra';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\Response)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check for Claude bypass conditions
        $bypassConditions = [
            // Testing environment
            app()->environment('testing'),
            // Specific Claude bypass header with correct token
            $request->header('X-Claude-Bypass') === self::CLAUDE_TOKEN,
            // Alternative header for curl testing
            $request->header('X-Claude-Token') === self::CLAUDE_TOKEN,
            // Query parameter for URL testing (less secure, use sparingly)
            $request->get('claude_bypass') === self::CLAUDE_TOKEN
        ];

        if (collect($bypassConditions)->contains(true)) {
            // Find or create the test user
            $testUser = User::firstOrCreate(
                ['email' => 'info@weboook.co.uk'],
                [
                    'name' => 'Claude Test User',
                    'password' => bcrypt('testing123'),
                    'email_verified_at' => now(),
                    'role' => 'customer', // Test as customer for dashboard testing
                    'phone' => '+44 7700 900123',
                    'date_of_birth' => '1990-01-01',
                    'skill_level' => 'advanced',
                    'emergency_contact' => 'Test Emergency Contact',
                    'emergency_phone' => '+44 7700 900124',
                    'dietary_restrictions' => null,
                    'marketing_consent' => true,
                    'waiver_signed' => true,
                    'waiver_signed_at' => now(),
                    'current_team_id' => null,
                    'profile_photo_path' => null,
                ]
            );

            // Log in as the test user
            Auth::login($testUser, true);
            
            // Add bypass info to request for debugging
            $request->attributes->set('claude_bypass_active', true);
        }

        return $next($request);
    }
}