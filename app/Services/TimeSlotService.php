<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Service;
use App\Models\Lane;
use Carbon\Carbon;

class TimeSlotService
{
    const MAX_CAPACITY = 55;
    const SLOT_DURATION_MINUTES = 30;
    
    // Business hours configuration
    const BUSINESS_HOURS = [
        'monday' => ['09:00', '21:00'],
        'tuesday' => ['09:00', '21:00'],
        'wednesday' => ['09:00', '21:00'],
        'thursday' => ['09:00', '21:00'],
        'friday' => ['09:00', '22:00'],
        'saturday' => ['09:00', '22:00'],
        'sunday' => ['10:00', '20:00'],
    ];

    /**
     * Generate available time slots for a given date and service
     */
    public function getAvailableSlots($date, $serviceId, $playerCount)
    {
        $service = Service::find($serviceId);
        if (!$service) {
            return [];
        }

        $date = Carbon::parse($date);
        $dayOfWeek = strtolower($date->format('l'));
        
        // Get business hours for this day
        $businessHours = self::BUSINESS_HOURS[$dayOfWeek] ?? ['09:00', '21:00'];
        $openTime = Carbon::parse($date->format('Y-m-d') . ' ' . $businessHours[0]);
        $closeTime = Carbon::parse($date->format('Y-m-d') . ' ' . $businessHours[1]);
        
        // Don't allow bookings in the past
        if ($date->isToday()) {
            $now = now()->addMinutes(30); // 30 minute buffer
            if ($openTime->lt($now)) {
                $openTime = $now->copy()->roundUp(self::SLOT_DURATION_MINUTES . ' minutes');
            }
        }

        $availableSlots = [];
        $serviceDurationHours = $service->duration_hours;
        $serviceDurationMinutes = $serviceDurationHours * 60;
        
        // Generate all possible slots
        $currentSlot = $openTime->copy();
        while ($currentSlot->copy()->addMinutes($serviceDurationMinutes)->lte($closeTime)) {
            $slotEndTime = $currentSlot->copy()->addMinutes($serviceDurationMinutes);
            
            if ($this->isSlotAvailable($currentSlot, $slotEndTime, $playerCount, $date)) {
                $availableSlots[] = $currentSlot->format('H:i');
            }
            
            $currentSlot->addMinutes(self::SLOT_DURATION_MINUTES);
        }

        return $availableSlots;
    }

    /**
     * Check if a specific time slot is available
     */
    private function isSlotAvailable($startTime, $endTime, $requestedPlayerCount, $date)
    {
        // Check total capacity during this time period
        $overlappingBookings = $this->getOverlappingBookings($startTime, $endTime, $date);
        
        $totalOccupiedCapacity = $overlappingBookings->sum('participants');
        $availableCapacity = self::MAX_CAPACITY - $totalOccupiedCapacity;
        
        return $availableCapacity >= $requestedPlayerCount;
    }

    /**
     * Get all bookings that overlap with the requested time slot
     */
    private function getOverlappingBookings($startTime, $endTime, $date)
    {
        return Booking::where('booking_date', $date->format('Y-m-d'))
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($startTime, $endTime) {
                // Booking starts before our slot ends AND ends after our slot starts
                $query->where(function ($q) use ($startTime, $endTime) {
                    $q->whereTime('start_time', '<', $endTime->format('H:i:s'))
                      ->whereTime('end_time', '>', $startTime->format('H:i:s'));
                });
            })
            ->get();
    }

    /**
     * Get capacity information for a specific time slot
     */
    public function getSlotCapacityInfo($date, $startTime, $duration)
    {
        $startTime = Carbon::parse($date . ' ' . $startTime);
        $endTime = $startTime->copy()->addHours($duration);
        
        $overlappingBookings = $this->getOverlappingBookings($startTime, $endTime, Carbon::parse($date));
        
        $occupiedCapacity = $overlappingBookings->sum('participants');
        $availableCapacity = self::MAX_CAPACITY - $occupiedCapacity;
        
        return [
            'total_capacity' => self::MAX_CAPACITY,
            'occupied_capacity' => $occupiedCapacity,
            'available_capacity' => $availableCapacity,
            'overlapping_bookings' => $overlappingBookings->count(),
        ];
    }

    /**
     * Check if a booking can be made at a specific time
     */
    public function canBookSlot($date, $startTime, $duration, $playerCount)
    {
        $startTime = Carbon::parse($date . ' ' . $startTime);
        $endTime = $startTime->copy()->addHours($duration);
        
        $capacityInfo = $this->getSlotCapacityInfo($date, $startTime->format('H:i'), $duration);
        
        return $capacityInfo['available_capacity'] >= $playerCount;
    }

    /**
     * Get business hours for a specific date
     */
    public function getBusinessHours($date)
    {
        $dayOfWeek = strtolower(Carbon::parse($date)->format('l'));
        return self::BUSINESS_HOURS[$dayOfWeek] ?? ['09:00', '21:00'];
    }

    /**
     * Calculate end time for a booking
     */
    public function calculateEndTime($startTime, $serviceId)
    {
        $service = Service::find($serviceId);
        if (!$service) {
            return null;
        }

        return Carbon::parse($startTime)->addHours($service->duration_hours);
    }

    /**
     * Get popular time slots (for display purposes)
     */
    public function getPopularSlots()
    {
        return [
            '10:00' => 'Morning Session',
            '14:00' => 'Afternoon Session', 
            '18:00' => 'Evening Session',
            '20:00' => 'Night Session'
        ];
    }
}