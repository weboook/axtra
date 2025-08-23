<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckBookingOwnership
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $bookingId = $request->route('booking') ?? $request->route('id');
        
        if ($bookingId) {
            $booking = \App\Models\Booking::find($bookingId);
            
            if (!$booking || ($booking->user_id !== auth()->id() && !auth()->user()->isEmployee())) {
                abort(403, 'You do not have permission to access this booking');
            }
        }

        return $next($request);
    }
}
