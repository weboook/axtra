<?php

namespace App\Livewire\Shared\Search;

use App\Models\User;
use App\Models\Booking;
use App\Models\Product;
use Livewire\Component;

class SearchIndex extends Component
{
    public $query = '';
    public $results = [];
    public $showResults = false;
    
    public function updatedQuery()
    {
        if (strlen($this->query) < 2) {
            $this->results = [];
            $this->showResults = false;
            return;
        }

        $this->search();
        $this->showResults = true;
    }

    public function search()
    {
        $this->results = [];

        if (auth()->user()->isAdmin() || auth()->user()->isEmployee()) {
            // Admin/Employee can search users, bookings, and products
            $users = User::where('name', 'like', '%' . $this->query . '%')
                        ->orWhere('email', 'like', '%' . $this->query . '%')
                        ->take(5)
                        ->get()
                        ->map(function ($user) {
                            return [
                                'type' => 'user',
                                'title' => $user->name,
                                'subtitle' => $user->email,
                                'icon' => 'fas fa-user',
                                'color' => '#6f42c1',
                                'url' => auth()->user()->isAdmin() ? route('admin.users.detail', $user) : '#'
                            ];
                        });

            $bookings = Booking::where('id', 'like', '%' . $this->query . '%')
                              ->orWhere('notes', 'like', '%' . $this->query . '%')
                              ->orWhereHas('user', function($q) {
                                  $q->where('name', 'like', '%' . $this->query . '%')
                                    ->orWhere('email', 'like', '%' . $this->query . '%');
                              })
                              ->with('user', 'product')
                              ->take(5)
                              ->get()
                              ->map(function ($booking) {
                                  return [
                                      'type' => 'booking',
                                      'title' => 'Booking #' . $booking->id,
                                      'subtitle' => ($booking->user ? $booking->user->name : 'Guest') . ' - ' . $booking->booking_date->format('M j, Y'),
                                      'icon' => 'fas fa-calendar',
                                      'color' => '#17a2b8',
                                      'url' => '#'
                                  ];
                              });

            $products = Product::where('name', 'like', '%' . $this->query . '%')
                              ->where('is_active', true)
                              ->take(3)
                              ->get()
                              ->map(function ($product) {
                                  return [
                                      'type' => 'product',
                                      'title' => $product->name,
                                      'subtitle' => 'CHF ' . number_format($product->price, 2),
                                      'icon' => 'fas fa-tag',
                                      'color' => '#28a745',
                                      'url' => '#'
                                  ];
                              });

            $this->results = $users->concat($bookings)->concat($products)->toArray();
        } else {
            // Regular users can only search their own bookings
            $bookings = auth()->user()->bookings()
                                   ->where(function($q) {
                                       $q->where('id', 'like', '%' . $this->query . '%')
                                         ->orWhere('notes', 'like', '%' . $this->query . '%');
                                   })
                                   ->with('product')
                                   ->take(5)
                                   ->get()
                                   ->map(function ($booking) {
                                       return [
                                           'type' => 'booking',
                                           'title' => 'Booking #' . $booking->id,
                                           'subtitle' => $booking->booking_date->format('M j, Y') . ' at ' . $booking->start_time->format('g:i A'),
                                           'icon' => 'fas fa-calendar-check',
                                           'color' => '#c02425',
                                           'url' => route('user.bookings')
                                       ];
                                   });

            $this->results = $bookings->toArray();
        }
    }

    public function hideResults()
    {
        $this->showResults = false;
    }

    public function render()
    {
        return view('livewire.shared.search.search-index');
    }
}