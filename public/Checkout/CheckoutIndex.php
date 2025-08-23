<?php

namespace Public\Checkout;

use App\Models\Product;
use App\Models\Lane;
use App\Models\Booking;
use App\Models\User;
use App\Models\Level;
use App\Services\PayRexxService;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class CheckoutIndex extends Component
{
    public $step = 1;
    public $selectedProduct;
    public $selectedDate;
    public $selectedTimeSlot;
    public $selectedLane;
    public $participants = 1;
    public $guestParticipants = [];
    public $customerInfo = [];
    public $paymentMethod = 'card';
    public $couponCode;
    public $appliedCoupon;
    public $totalPrice = 0;
    public $discountAmount = 0;
    public $finalPrice = 0;
    
    // Checkout data
    public $products = [];
    public $availableSlots = [];
    public $availableLanes = [];
    
    public function mount()
    {
        $this->products = Product::where('is_active', true)->get();
        $this->initializeCustomerInfo();
    }
    
    public function initializeCustomerInfo()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $this->customerInfo = [
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone ?? '',
            ];
        }
    }
    
    public function selectProduct($productId)
    {
        $this->selectedProduct = Product::find($productId);
        $this->calculatePrice();
        $this->step = 2;
    }
    
    public function selectDateTime($date, $timeSlot)
    {
        $this->selectedDate = $date;
        $this->selectedTimeSlot = $timeSlot;
        $this->loadAvailableLanes();
        $this->step = 3;
    }
    
    public function loadAvailableLanes()
    {
        // Get available lanes for the selected date and time
        $bookedLanes = Booking::where('booking_date', $this->selectedDate)
            ->where('time_slot', $this->selectedTimeSlot)
            ->where('status', '!=', 'cancelled')
            ->pluck('lane_id')
            ->toArray();
            
        $this->availableLanes = Lane::where('is_active', true)
            ->whereNotIn('id', $bookedLanes)
            ->get();
    }
    
    public function selectLane($laneId)
    {
        $this->selectedLane = Lane::find($laneId);
        $this->step = 4;
    }
    
    public function updateParticipants()
    {
        // Ensure guest participants array matches the count
        $guestCount = max(0, $this->participants - 1);
        $this->guestParticipants = array_slice($this->guestParticipants, 0, $guestCount);
        
        // Fill missing guest slots
        while (count($this->guestParticipants) < $guestCount) {
            $this->guestParticipants[] = [
                'name' => '',
                'email' => '',
                'phone' => ''
            ];
        }
        
        $this->calculatePrice();
    }
    
    public function addGuestParticipant()
    {
        $this->participants++;
        $this->guestParticipants[] = [
            'name' => '',
            'email' => '',
            'phone' => ''
        ];
        $this->calculatePrice();
    }
    
    public function removeGuestParticipant($index)
    {
        if ($this->participants > 1) {
            $this->participants--;
            unset($this->guestParticipants[$index]);
            $this->guestParticipants = array_values($this->guestParticipants);
            $this->calculatePrice();
        }
    }
    
    public function proceedToPayment()
    {
        // Validate participant information
        $this->validate([
            'customerInfo.name' => 'required|string|max:255',
            'customerInfo.email' => 'required|email|max:255',
            'customerInfo.phone' => 'required|string|max:20',
        ]);
        
        // Validate guest participants
        foreach ($this->guestParticipants as $index => $guest) {
            $this->validate([
                "guestParticipants.{$index}.name" => 'required|string|max:255',
                "guestParticipants.{$index}.email" => 'required|email|max:255',
            ]);
        }
        
        $this->step = 5;
    }
    
    public function applyCoupon()
    {
        if (!$this->couponCode) {
            return;
        }
        
        $coupon = \App\Models\Coupon::where('code', $this->couponCode)
            ->where('is_active', true)
            ->where('expires_at', '>', now())
            ->where(function($query) {
                $query->whereNull('usage_limit')
                    ->orWhere('used_count', '<', \DB::raw('usage_limit'));
            })
            ->first();
            
        if ($coupon) {
            $this->appliedCoupon = $coupon;
            $this->calculatePrice();
            session()->flash('message', 'Coupon applied successfully!');
        } else {
            session()->flash('error', 'Invalid or expired coupon code.');
        }
    }
    
    public function removeCoupon()
    {
        $this->appliedCoupon = null;
        $this->couponCode = '';
        $this->calculatePrice();
    }
    
    public function calculatePrice()
    {
        if (!$this->selectedProduct) {
            return;
        }
        
        $this->totalPrice = $this->selectedProduct->price * $this->participants;
        
        // Apply coupon discount
        $this->discountAmount = 0;
        if ($this->appliedCoupon) {
            if ($this->appliedCoupon->discount_type === 'percentage') {
                $this->discountAmount = ($this->totalPrice * $this->appliedCoupon->discount_value) / 100;
            } else {
                $this->discountAmount = $this->appliedCoupon->discount_value;
            }
            
            // Ensure discount doesn't exceed total
            $this->discountAmount = min($this->discountAmount, $this->totalPrice);
        }
        
        $this->finalPrice = $this->totalPrice - $this->discountAmount;
    }
    
    public function processPayment()
    {
        try {
            // Create booking record
            $booking = $this->createBooking();
            
            if ($this->paymentMethod === 'card') {
                // Redirect to PayRexx payment
                $paymentUrl = $this->initializePayRexxPayment($booking);
                return redirect($paymentUrl);
            } else {
                // Handle other payment methods (cash, etc.)
                $this->completeBooking($booking);
                return redirect()->route('user.bookings')->with('message', 'Booking created successfully!');
            }
            
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while processing your booking. Please try again.');
            \Log::error('Checkout error: ' . $e->getMessage());
        }
    }
    
    protected function createBooking()
    {
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'product_id' => $this->selectedProduct->id,
            'lane_id' => $this->selectedLane->id,
            'booking_date' => $this->selectedDate,
            'time_slot' => $this->selectedTimeSlot,
            'participants_count' => $this->participants,
            'participant_details' => json_encode([
                'primary' => $this->customerInfo,
                'guests' => $this->guestParticipants
            ]),
            'total_amount' => $this->finalPrice,
            'original_amount' => $this->totalPrice,
            'discount_amount' => $this->discountAmount,
            'coupon_id' => $this->appliedCoupon?->id,
            'status' => 'pending',
            'payment_status' => 'pending',
        ]);
        
        // Store booking ID in session for payment processing
        Session::put('checkout_booking_id', $booking->id);
        
        return $booking;
    }
    
    protected function initializePayRexxPayment($booking)
    {
        $payRexxService = new PayRexxService();
        
        $paymentData = [
            'amount' => $this->finalPrice * 100, // Amount in cents
            'currency' => 'CHF',
            'purpose' => "Axe Throwing Booking #{$booking->id}",
            'successRedirectUrl' => route('checkout.success', $booking->id),
            'failedRedirectUrl' => route('checkout.failed', $booking->id),
            'cancelRedirectUrl' => route('checkout.cancel', $booking->id),
            'subscriptionState' => false,
            'referenceId' => $booking->id,
        ];
        
        return $payRexxService->createPayment($paymentData);
    }
    
    protected function completeBooking($booking)
    {
        $booking->update([
            'status' => 'confirmed',
            'payment_status' => 'completed',
            'confirmed_at' => now(),
        ]);
        
        // Award skill points to user if authenticated
        if (Auth::check()) {
            $this->awardSkillPoints($booking);
        }
        
        // Update coupon usage if applied
        if ($this->appliedCoupon) {
            $this->appliedCoupon->increment('used_count');
        }
        
        // Send confirmation notifications
        $this->sendConfirmationNotifications($booking);
    }
    
    protected function awardSkillPoints($booking)
    {
        $user = Auth::user();
        $pointsAwarded = $this->selectedProduct->skill_points ?? 10;
        
        $user->increment('skill_points', $pointsAwarded);
        $user->checkLevelProgression();
    }
    
    protected function sendConfirmationNotifications($booking)
    {
        // TODO: Implement email and SMS notifications
        // This would integrate with your notification system
    }
    
    public function goBack()
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }
    
    public function restart()
    {
        $this->step = 1;
        $this->reset([
            'selectedProduct', 'selectedDate', 'selectedTimeSlot', 
            'selectedLane', 'participants', 'guestParticipants',
            'couponCode', 'appliedCoupon'
        ]);
        $this->initializeCustomerInfo();
    }
    
    public function render()
    {
        return view('livewire.public.checkout.checkout-index');
    }
}