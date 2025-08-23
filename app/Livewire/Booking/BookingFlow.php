<?php

namespace App\Livewire\Booking;

use App\Models\Service;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\Booking;
use App\Models\Lane;
use App\Models\EventType;
use Livewire\Component;
use Illuminate\Support\Facades\Session;

class BookingFlow extends Component
{
    public $step = 1; // 1: Service Selection, 2: Date/Time & Details, 3: Checkout
    
    // Service Selection
    public $selectedCategory = '';
    public $playerCount = 2;
    public $availableServices = [];
    public $selectedService = null;
    
    // Event Details
    public $eventType = '';
    public $customEventType = '';
    public $comments = '';
    public $selectedDate = '';
    public $selectedTime = '';
    public $availableSlots = [];
    
    // Checkout
    public $selectedUpsells = [];
    public $couponCode = '';
    public $appliedCoupon = null;
    public $subtotal = 0;
    public $discount = 0;
    public $total = 0;
    
    // Track changes for upsell recalculation
    public $listeners = ['updateUpsell' => 'updateUpsellQuantity'];
    
    public function updateUpsellQuantity($upsellId, $quantity)
    {
        $this->selectedUpsells[$upsellId] = max(0, (int) $quantity);
        $this->calculateTotals();
    }
    
    // Guest booking
    public $isGuest = false;
    public $guestName = '';
    public $guestEmail = '';
    public $guestPhone = '';
    
    // Pre-selected parameters from URL
    public $preSelectedPlayers = null;
    public $preSelectedType = null;

    protected $queryString = [
        'players' => ['except' => ''],
        'type' => ['except' => ''],
        'step' => ['except' => 1],
    ];

    protected $rules = [
        'playerCount' => 'required|integer|min:1|max:55',
        'selectedService' => 'required|integer|exists:services,id',
        'selectedDate' => 'required|date|after_or_equal:today',
        'selectedTime' => 'required',
        'eventType' => 'required|string',
        'customEventType' => 'required_if:eventType,other',
        'guestName' => 'required_if:isGuest,true|string|max:255',
        'guestEmail' => 'required_if:isGuest,true|email|max:255',
        'guestPhone' => 'required_if:isGuest,true|string|max:20',
    ];

    public function mount()
    {
        // Handle pre-selected parameters
        if (request('players')) {
            $this->preSelectedPlayers = (int) request('players');
            $this->playerCount = $this->preSelectedPlayers;
        }
        
        if (request('type')) {
            $this->preSelectedType = request('type');
            $this->selectedCategory = $this->mapTypeToCategory($this->preSelectedType);
        }
        
        // Check if user is authenticated
        $this->isGuest = !auth()->check();
        
        // Restore booking state after authentication
        if (session('restore_booking') && session('booking_state')) {
            $this->restoreBookingState();
            session()->forget(['booking_state', 'restore_booking']);
        }
        
        // Load initial services if category is pre-selected
        if ($this->selectedCategory) {
            $this->updateAvailableServices();
        }
        
        // Auto-advance if we have all step 1 info
        if ($this->selectedCategory && $this->playerCount && $this->availableServices) {
            // Auto-select service if only one matches
            if (count($this->availableServices) === 1) {
                $this->selectedService = $this->availableServices[0]->id;
                $this->calculateTotals();
                $this->nextStep();
            }
        }
        
        // Load time slots if we're on step 2 and have a date
        if ($this->step >= 2) {
            $this->loadAvailableSlots();
        }
    }

    public function updatePlayerCount()
    {
        $this->updateAvailableServices();
        $this->selectedService = null; // Reset service selection
        $this->calculateTotals();
    }

    public function selectCategory($category)
    {
        $this->selectedCategory = $category;
        $this->updateAvailableServices();
        $this->selectedService = null;
        $this->dispatch('category-selected');
    }

    public function updateAvailableServices()
    {
        if (!$this->selectedCategory || !$this->playerCount) {
            $this->availableServices = [];
            return;
        }

        $this->availableServices = Service::active()
            ->byCategory($this->selectedCategory)
            ->forPlayerCount($this->playerCount)
            ->orderBy('sort_order')
            ->get();
    }

    public function selectService($serviceId)
    {
        $this->selectedService = $serviceId;
        $this->calculateTotals();
        
        // Auto-advance to next step after a short delay
        $this->dispatch('service-selected');
    }

    public function nextStep()
    {
        $this->validate($this->getRulesForStep($this->step));
        $this->step++;
        
        if ($this->step === 2) {
            $this->loadAvailableSlots();
            $this->dispatch('step-changed', ['step' => 2]);
        } elseif ($this->step === 3) {
            $this->calculateTotals();
            $this->dispatch('step-changed', ['step' => 3]);
        }
    }

    public function previousStep()
    {
        $this->step--;
    }

    public function loadAvailableSlots()
    {
        if (!$this->selectedDate) {
            $this->availableSlots = [];
            return;
        }
        
        // For now, generate some sample time slots
        // In production, this would query actual availability based on:
        // - selected date
        // - selected service duration
        // - existing bookings
        // - business hours
        $this->availableSlots = [
            '09:00', '10:00', '11:00', '12:00', '13:00', 
            '14:00', '15:00', '16:00', '17:00', '18:00'
        ];
    }
    
    public function updatedSelectedDate()
    {
        // Called automatically when selectedDate property changes
        $this->selectedTime = ''; // Reset selected time
        $this->loadAvailableSlots();
    }
    
    public function setSelectedDate($date)
    {
        $this->selectedDate = $date;
        $this->selectedTime = ''; // Reset selected time
        $this->loadAvailableSlots();
    }

    public function applyCoupon()
    {
        if (!$this->couponCode) {
            return;
        }

        $coupon = Coupon::where('code', $this->couponCode)
                       ->active()
                       ->first();

        if (!$coupon || !$coupon->isValid()) {
            $this->addError('couponCode', 'Invalid or expired coupon code.');
            return;
        }

        if ($coupon->minimum_amount && $this->subtotal < $coupon->minimum_amount) {
            $this->addError('couponCode', 'Minimum order amount not met for this coupon.');
            return;
        }

        $this->appliedCoupon = $coupon;
        $this->calculateTotals();
        
        session()->flash('success', 'Coupon applied successfully!');
    }

    public function removeCoupon()
    {
        $this->appliedCoupon = null;
        $this->couponCode = '';
        $this->calculateTotals();
    }

    public function calculateTotals()
    {
        if (!$this->selectedService) {
            return;
        }

        $service = Service::find($this->selectedService);
        $this->subtotal = $service->getTotalPriceForPlayers($this->playerCount);
        
        // Add upsells
        foreach ($this->selectedUpsells as $upsellId => $quantity) {
            $upsell = Product::find($upsellId);
            if ($upsell && $quantity > 0) {
                $this->subtotal += ($upsell->price * $quantity);
            }
        }

        // Calculate discount
        $this->discount = 0;
        if ($this->appliedCoupon) {
            if ($this->appliedCoupon->type === 'percentage') {
                $this->discount = ($this->subtotal * $this->appliedCoupon->value) / 100;
            } else {
                $this->discount = min($this->appliedCoupon->value, $this->subtotal);
            }
        }

        $this->total = $this->subtotal - $this->discount;
    }

    public function proceedToPayment()
    {
        $this->validate($this->getRulesForStep($this->step));
        
        // Create booking record
        $bookingData = [
            'service_id' => $this->selectedService,
            'participants' => $this->playerCount,
            'booking_date' => $this->selectedDate,
            'start_time' => $this->selectedTime,
            'total_price' => $this->total,
            'discount_amount' => $this->discount,
            'status' => 'pending',
            'notes' => $this->comments,
            'participant_details' => [
                'event_type' => $this->eventType,
                'custom_event_type' => $this->customEventType,
            ],
        ];

        if ($this->isGuest) {
            $bookingData['participant_details'] = array_merge($bookingData['participant_details'], [
                'guest_info' => [
                    'name' => $this->guestName,
                    'email' => $this->guestEmail,
                    'phone' => $this->guestPhone,
                ],
                'is_guest_booking' => true,
            ]);
        } else {
            $bookingData['user_id'] = auth()->id();
        }

        if ($this->appliedCoupon) {
            $bookingData['coupon_id'] = $this->appliedCoupon->id;
        }

        $booking = Booking::create($bookingData);
        
        // Store booking ID in session for payment processing
        Session::put('pending_booking_id', $booking->id);
        
        // Redirect to payment processing
        return redirect()->route('booking.payment', $booking->id);
    }

    public function login()
    {
        // Store current booking state in session
        Session::put('booking_state', [
            'step' => $this->step,
            'selectedCategory' => $this->selectedCategory,
            'playerCount' => $this->playerCount,
            'selectedService' => $this->selectedService,
            'eventType' => $this->eventType,
            'customEventType' => $this->customEventType,
            'comments' => $this->comments,
            'selectedDate' => $this->selectedDate,
            'selectedTime' => $this->selectedTime,
            'selectedUpsells' => $this->selectedUpsells,
            'couponCode' => $this->couponCode,
        ]);
        
        Session::put('intended_url', request()->fullUrl());
        
        return redirect()->route('login');
    }

    private function mapTypeToCategory($type)
    {
        return match($type) {
            'axe_throwing' => 'axe_throwing',
            'axe_throwing_making' => 'axe_throwing_making',
            'axe_making' => 'axe_making',
            'private_events' => 'private_events',
            default => '',
        };
    }

    private function restoreBookingState()
    {
        $state = session('booking_state');
        
        if ($state) {
            $this->step = $state['step'] ?? 1;
            $this->selectedCategory = $state['selectedCategory'] ?? '';
            $this->playerCount = $state['playerCount'] ?? 2;
            $this->selectedService = $state['selectedService'] ?? null;
            $this->eventType = $state['eventType'] ?? '';
            $this->customEventType = $state['customEventType'] ?? '';
            $this->comments = $state['comments'] ?? '';
            $this->selectedDate = $state['selectedDate'] ?? '';
            $this->selectedTime = $state['selectedTime'] ?? '';
            $this->selectedUpsells = $state['selectedUpsells'] ?? [];
            $this->couponCode = $state['couponCode'] ?? '';
            
            // Update user authentication status
            $this->isGuest = false;
            
            // Refresh available services
            if ($this->selectedCategory) {
                $this->updateAvailableServices();
            }
            
            // Load time slots if on step 2+
            if ($this->step >= 2) {
                $this->loadAvailableSlots();
            }
            
            // Calculate totals if on step 3
            if ($this->step >= 3) {
                $this->calculateTotals();
            }
        }
    }

    private function getRulesForStep($step)
    {
        return match($step) {
            1 => [
                'playerCount' => 'required|integer|min:1|max:55',
                'selectedService' => 'required|integer|exists:services,id',
            ],
            2 => [
                'selectedDate' => 'required|date|after_or_equal:today',
                'selectedTime' => 'required',
                'eventType' => 'required|string',
                'customEventType' => 'required_if:eventType,other',
                'guestName' => 'required_if:isGuest,true|string|max:255',
                'guestEmail' => 'required_if:isGuest,true|email|max:255',
                'guestPhone' => 'required_if:isGuest,true|string|max:20',
            ],
            default => [],
        };
    }

    public function render()
    {
        $upsells = Product::active()->upsells()->get();
        $eventTypes = EventType::active()->ordered()->get();

        // Use different layouts for guest vs authenticated users
        if ($this->isGuest) {
            return view('livewire.booking.booking-flow', compact('upsells', 'eventTypes'))
                ->layout('layouts.guest');
        }

        return view('livewire.booking.booking-flow', compact('upsells', 'eventTypes'))
            ->layout('layouts.app');
    }
}
