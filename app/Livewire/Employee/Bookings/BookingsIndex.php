<?php

namespace App\Livewire\Employee\Bookings;

use App\Models\Booking;
use Livewire\Component;
use Carbon\Carbon;

class BookingsIndex extends Component
{
    public $selectedDate;
    public $searchTerm = '';
    public $statusFilter = 'all';
    
    public function mount()
    {
        $this->selectedDate = Carbon::today()->format('Y-m-d');
    }
    
    public function setDate($date)
    {
        $this->selectedDate = $date;
    }
    
    public function goToToday()
    {
        $this->selectedDate = Carbon::today()->format('Y-m-d');
    }
    
    public function markAsCheckedIn($bookingId)
    {
        $booking = Booking::find($bookingId);
        if ($booking) {
            $booking->update(['status' => 'in_progress']);
            session()->flash('success', 'Customer checked in successfully');
        }
    }
    
    public function markAsCompleted($bookingId)
    {
        $booking = Booking::find($bookingId);
        if ($booking) {
            $booking->update(['status' => 'completed']);
            session()->flash('success', 'Booking marked as completed');
        }
    }
    
    public function markAsNoShow($bookingId)
    {
        $booking = Booking::find($bookingId);
        if ($booking) {
            $booking->update(['status' => 'cancelled']);
            session()->flash('success', 'Booking marked as no-show');
        }
    }
    
    private function getFilteredBookings()
    {
        $query = Booking::whereDate('booking_date', $this->selectedDate)
            ->with(['user', 'product', 'service', 'lane']);
        
        if ($this->searchTerm) {
            $query->whereHas('user', function($q) {
                $q->where('name', 'like', '%' . $this->searchTerm . '%');
            });
        }
        
        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }
        
        return $query->orderBy('start_time')->get();
    }
    
    public function render()
    {
        $bookings = $this->getFilteredBookings();
        $selectedDateFormatted = Carbon::parse($this->selectedDate)->format('l, F j, Y');
        
        $stats = [
            'total' => $bookings->count(),
            'pending' => $bookings->whereIn('status', ['pending', 'confirmed'])->count(),
            'checked_in' => $bookings->where('status', 'in_progress')->count(),
            'completed' => $bookings->where('status', 'completed')->count(),
            'no_show' => $bookings->where('status', 'cancelled')->count(),
        ];
        
        return view('livewire.employee.bookings.bookings-index', compact('bookings', 'selectedDateFormatted', 'stats'));
    }
}