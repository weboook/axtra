<?php

namespace App\Livewire\Employee\CheckIns;

use App\Models\Booking;
use Livewire\Component;
use Carbon\Carbon;

class CheckInsIndex extends Component
{
    public $searchTerm = '';
    public $bookingCode = '';
    public $selectedBooking = null;
    
    public function searchBooking()
    {
        if (empty($this->bookingCode)) {
            session()->flash('error', 'Please enter a booking code');
            return;
        }
        
        // Get booking by ID from the reference code
        $bookingId = str_replace('AXT-', '', $this->bookingCode);
        $bookingId = ltrim($bookingId, '0'); // Remove leading zeros
        
        $booking = Booking::where('id', $bookingId)
            ->whereDate('booking_date', Carbon::today())
            ->with(['user', 'product', 'service', 'lane'])
            ->first();
            
        if ($booking) {
            $this->selectedBooking = $booking;
            $this->bookingCode = '';
        } else {
            session()->flash('error', 'Booking not found or not scheduled for today');
            $this->selectedBooking = null;
        }
    }
    
    public function checkIn($bookingId)
    {
        $booking = Booking::find($bookingId);
        if ($booking) {
            $booking->update([
                'status' => 'in_progress'
            ]);
            
            session()->flash('success', 'Customer checked in successfully!');
            $this->selectedBooking = null;
        }
    }
    
    public function clearSearch()
    {
        $this->selectedBooking = null;
        $this->bookingCode = '';
        $this->searchTerm = '';
    }
    
    private function getTodayCheckIns()
    {
        $query = Booking::whereDate('booking_date', Carbon::today())
            ->whereIn('status', ['in_progress', 'completed'])
            ->with(['user', 'product', 'service', 'lane']);
        
        if ($this->searchTerm) {
            $query->whereHas('user', function($q) {
                $q->where('name', 'like', '%' . $this->searchTerm . '%');
            });
        }
        
        return $query->orderBy('updated_at', 'desc')->get();
    }
    
    private function getUpcomingBookings()
    {
        return Booking::whereDate('booking_date', Carbon::today())
            ->whereIn('status', ['pending', 'confirmed'])
            ->whereTime('start_time', '>', Carbon::now()->format('H:i:s'))
            ->with(['user', 'product', 'service', 'lane'])
            ->orderBy('start_time')
            ->limit(5)
            ->get();
    }

    public function render()
    {
        $checkIns = $this->getTodayCheckIns();
        $upcomingBookings = $this->getUpcomingBookings();
        
        $stats = [
            'total_today' => Booking::whereDate('booking_date', Carbon::today())->count(),
            'checked_in' => $checkIns->where('status', 'in_progress')->count(),
            'completed' => $checkIns->where('status', 'completed')->count(),
            'pending' => Booking::whereDate('booking_date', Carbon::today())->whereIn('status', ['pending', 'confirmed'])->count(),
        ];
        
        return view('livewire.employee.check-ins.check-ins-index', compact('checkIns', 'upcomingBookings', 'stats'));
    }
}