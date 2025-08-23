<?php

namespace App\Livewire\User\Booking;

use App\Models\Booking;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class BookingIndex extends Component
{
    use WithPagination;
    
    public $filter = 'all'; // all, upcoming, past, cancelled
    public $search = '';
    public $showBookingId = null;
    
    protected $queryString = [
        'filter' => ['except' => 'all'],
        'search' => ['except' => ''],
    ];
    
    public function mount()
    {
        // Set default filter based on URL
        if (request()->route()->getName() === 'user.book') {
            $this->filter = 'all';
        }
    }
    
    public function updatedSearch()
    {
        $this->resetPage();
    }
    
    public function updatedFilter()
    {
        $this->resetPage();
    }
    
    public function showBookingDetails($bookingId)
    {
        $this->showBookingId = $bookingId;
    }
    
    public function hideBookingDetails()
    {
        $this->showBookingId = null;
    }
    
    public function cancelBooking($bookingId)
    {
        $booking = Booking::where('id', $bookingId)
            ->where('user_id', auth()->id())
            ->first();
            
        if ($booking && $booking->status !== 'cancelled' && $booking->status !== 'completed') {
            $booking->update(['status' => 'cancelled']);
            
            $this->dispatch('booking-cancelled', [
                'title' => 'Booking Cancelled',
                'text' => 'Your booking has been successfully cancelled.'
            ]);
        }
    }
    
    public function render()
    {
        $user = auth()->user();
        
        // Base query
        $query = $user->bookings()->with(['product']);
        
        // Apply search filter
        if ($this->search) {
            $query->where(function($q) {
                $q->where('booking_reference', 'like', '%' . $this->search . '%')
                  ->orWhereHas('product', function($productQuery) {
                      $productQuery->where('name', 'like', '%' . $this->search . '%');
                  });
            });
        }
        
        // Apply status filter
        switch ($this->filter) {
            case 'upcoming':
                $query->where(function($q) {
                    $q->where('booking_date', '>', now()->toDateString())
                      ->orWhere(function($subQuery) {
                          $subQuery->where('booking_date', '=', now()->toDateString())
                                   ->where('start_time', '>', now()->toTimeString());
                      });
                })->whereIn('status', ['pending', 'confirmed']);
                break;
                
            case 'past':
                $query->where(function($q) {
                    $q->where('booking_date', '<', now()->toDateString())
                      ->orWhere(function($subQuery) {
                          $subQuery->where('booking_date', '=', now()->toDateString())
                                   ->where('end_time', '<', now()->toTimeString());
                      });
                })->whereIn('status', ['confirmed', 'completed']);
                break;
                
            case 'cancelled':
                $query->where('status', 'cancelled');
                break;
        }
        
        $bookings = $query->orderBy('booking_date', 'desc')
                         ->orderBy('start_time', 'desc')
                         ->paginate(10);
        
        // Statistics
        $stats = [
            'total' => $user->bookings()->count(),
            'upcoming' => $user->bookings()
                ->where(function($q) {
                    $q->where('booking_date', '>', now()->toDateString())
                      ->orWhere(function($subQuery) {
                          $subQuery->where('booking_date', '=', now()->toDateString())
                                   ->where('start_time', '>', now()->toTimeString());
                      });
                })
                ->whereIn('status', ['pending', 'confirmed'])
                ->count(),
            'completed' => $user->bookings()->where('status', 'completed')->count(),
            'cancelled' => $user->bookings()->where('status', 'cancelled')->count(),
        ];
        
        return view('livewire.user.booking.booking-index', [
            'bookings' => $bookings,
            'stats' => $stats,
        ])->layout('layouts.app');
    }
}