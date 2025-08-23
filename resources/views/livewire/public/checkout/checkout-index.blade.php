<div class="container-fluid py-4">
    <!-- Progress Steps -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="steps-indicator">
                        <div class="row">
                            <div class="col-md-2 col-6">
                                <div class="step {{ $step >= 1 ? 'active' : '' }}">
                                    <div class="step-icon">
                                        <i class="material-icons">shopping_cart</i>
                                    </div>
                                    <span class="step-title">Select Package</span>
                                </div>
                            </div>
                            <div class="col-md-2 col-6">
                                <div class="step {{ $step >= 2 ? 'active' : '' }}">
                                    <div class="step-icon">
                                        <i class="material-icons">schedule</i>
                                    </div>
                                    <span class="step-title">Date & Time</span>
                                </div>
                            </div>
                            <div class="col-md-2 col-6">
                                <div class="step {{ $step >= 3 ? 'active' : '' }}">
                                    <div class="step-icon">
                                        <i class="material-icons">sports</i>
                                    </div>
                                    <span class="step-title">Select Lane</span>
                                </div>
                            </div>
                            <div class="col-md-2 col-6">
                                <div class="step {{ $step >= 4 ? 'active' : '' }}">
                                    <div class="step-icon">
                                        <i class="material-icons">people</i>
                                    </div>
                                    <span class="step-title">Participants</span>
                                </div>
                            </div>
                            <div class="col-md-2 col-6">
                                <div class="step {{ $step >= 5 ? 'active' : '' }}">
                                    <div class="step-icon">
                                        <i class="material-icons">payment</i>
                                    </div>
                                    <span class="step-title">Payment</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($step == 1)
        <!-- Step 1: Select Package -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Choose Your Axe Throwing Package</h4>
                        <p class="text-muted mb-0">Select the perfect package for your experience</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($products as $product)
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <div class="card product-card h-100" style="cursor: pointer;" wire:click="selectProduct({{ $product->id }})">
                                        <div class="card-body text-center">
                                            <div class="product-icon mb-3">
                                                <i class="material-icons text-primary" style="font-size: 3rem;">sports</i>
                                            </div>
                                            <h5 class="card-title">{{ $product->name }}</h5>
                                            <p class="card-text text-muted">{{ $product->description }}</p>
                                            <div class="price-info">
                                                <span class="price h4 text-primary">CHF {{ number_format($product->price, 2) }}</span>
                                                <span class="duration text-muted d-block">{{ $product->duration }} minutes</span>
                                            </div>
                                            @if($product->skill_points)
                                                <div class="skill-points mt-2">
                                                    <small class="text-success">
                                                        <i class="material-icons" style="font-size: 14px;">military_tech</i>
                                                        +{{ $product->skill_points }} skill points
                                                    </small>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="card-footer text-center">
                                            <button class="btn btn-primary">Select Package</button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if ($step == 2)
        <!-- Step 2: Date & Time Selection -->
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Select Date & Time</h4>
                        <p class="text-muted mb-0">Choose when you'd like to throw some axes</p>
                    </div>
                    <div class="card-body">
                        <!-- Date Picker -->
                        <div class="mb-4">
                            <label class="form-label">Select Date</label>
                            <input type="date" class="form-control" wire:model="selectedDate" min="{{ date('Y-m-d') }}">
                        </div>

                        <!-- Time Slots -->
                        @if($selectedDate)
                            <div class="mb-4">
                                <label class="form-label">Available Time Slots</label>
                                <div class="row">
                                    @php
                                        $timeSlots = [
                                            '09:00-10:30', '10:45-12:15', '13:00-14:30', 
                                            '14:45-16:15', '16:30-18:00', '18:15-19:45', '20:00-21:30'
                                        ];
                                    @endphp
                                    @foreach($timeSlots as $slot)
                                        <div class="col-md-4 col-6 mb-2">
                                            <button type="button" 
                                                    class="btn btn-outline-primary w-100 time-slot {{ $selectedTimeSlot == $slot ? 'active' : '' }}"
                                                    wire:click="selectDateTime('{{ $selectedDate }}', '{{ $slot }}')">
                                                {{ $slot }}
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Booking Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="booking-detail">
                            <strong>Package:</strong> {{ $selectedProduct->name }}<br>
                            <strong>Duration:</strong> {{ $selectedProduct->duration }} minutes<br>
                            <strong>Price:</strong> CHF {{ number_format($selectedProduct->price, 2) }}
                        </div>
                        @if($selectedDate)
                            <hr>
                            <div class="booking-detail">
                                <strong>Date:</strong> {{ \Carbon\Carbon::parse($selectedDate)->format('M d, Y') }}<br>
                                @if($selectedTimeSlot)
                                    <strong>Time:</strong> {{ $selectedTimeSlot }}
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if ($step == 3)
        <!-- Step 3: Lane Selection -->
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Select Your Lane</h4>
                        <p class="text-muted mb-0">Choose an available lane for your session</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @forelse($availableLanes as $lane)
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <div class="card lane-card h-100" style="cursor: pointer;" wire:click="selectLane({{ $lane->id }})">
                                        <div class="card-body text-center">
                                            <div class="lane-icon mb-3">
                                                <i class="material-icons text-success" style="font-size: 3rem;">sports</i>
                                            </div>
                                            <h5 class="card-title">{{ $lane->name }}</h5>
                                            <p class="card-text text-muted">{{ $lane->description }}</p>
                                            <span class="badge bg-success">Available</span>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="alert alert-warning">
                                        <i class="material-icons me-2">info</i>
                                        No lanes available for the selected date and time. Please choose a different time slot.
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Booking Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="booking-detail">
                            <strong>Package:</strong> {{ $selectedProduct->name }}<br>
                            <strong>Date:</strong> {{ \Carbon\Carbon::parse($selectedDate)->format('M d, Y') }}<br>
                            <strong>Time:</strong> {{ $selectedTimeSlot }}<br>
                            @if($selectedLane)
                                <strong>Lane:</strong> {{ $selectedLane->name }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if ($step == 4)
        <!-- Step 4: Participants Information -->
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Participant Information</h4>
                        <p class="text-muted mb-0">Tell us who's coming to throw axes</p>
                    </div>
                    <div class="card-body">
                        <!-- Participant Count -->
                        <div class="mb-4">
                            <label class="form-label">Number of Participants</label>
                            <div class="input-group" style="max-width: 200px;">
                                <button class="btn btn-outline-secondary" type="button" wire:click="$set('participants', {{ max(1, $participants - 1) }}); updateParticipants()">-</button>
                                <input type="number" class="form-control text-center" wire:model="participants" min="1" max="8">
                                <button class="btn btn-outline-secondary" type="button" wire:click="$set('participants', {{ $participants + 1 }}); updateParticipants()">+</button>
                            </div>
                        </div>

                        <!-- Primary Participant (Current User) -->
                        <div class="mb-4">
                            <h5>Primary Participant</h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group input-group-outline mb-3">
                                        <label class="form-label">Full Name</label>
                                        <input type="text" class="form-control" wire:model="customerInfo.name">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-outline mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" wire:model="customerInfo.email">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-outline mb-3">
                                        <label class="form-label">Phone</label>
                                        <input type="tel" class="form-control" wire:model="customerInfo.phone">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Guest Participants -->
                        @if(count($guestParticipants) > 0)
                            <div class="mb-4">
                                <h5>Guest Participants</h5>
                                @foreach($guestParticipants as $index => $guest)
                                    <div class="guest-participant mb-3 p-3 border rounded">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="mb-0">Guest {{ $index + 1 }}</h6>
                                            <button type="button" class="btn btn-sm btn-outline-danger" wire:click="removeGuestParticipant({{ $index }})">
                                                <i class="material-icons" style="font-size: 16px;">delete</i>
                                            </button>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="input-group input-group-outline mb-3">
                                                    <label class="form-label">Full Name</label>
                                                    <input type="text" class="form-control" wire:model="guestParticipants.{{ $index }}.name">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-group input-group-outline mb-3">
                                                    <label class="form-label">Email</label>
                                                    <input type="email" class="form-control" wire:model="guestParticipants.{{ $index }}.email">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-group input-group-outline mb-3">
                                                    <label class="form-label">Phone (Optional)</label>
                                                    <input type="tel" class="form-control" wire:model="guestParticipants.{{ $index }}.phone">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <div class="text-center">
                            <button type="button" class="btn btn-primary" wire:click="proceedToPayment">
                                Continue to Payment
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Booking Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="booking-detail">
                            <strong>Package:</strong> {{ $selectedProduct->name }}<br>
                            <strong>Date:</strong> {{ \Carbon\Carbon::parse($selectedDate)->format('M d, Y') }}<br>
                            <strong>Time:</strong> {{ $selectedTimeSlot }}<br>
                            <strong>Lane:</strong> {{ $selectedLane->name }}<br>
                            <strong>Participants:</strong> {{ $participants }}
                        </div>
                        <hr>
                        <div class="price-breakdown">
                            <div class="d-flex justify-content-between">
                                <span>{{ $selectedProduct->name }} x {{ $participants }}</span>
                                <span>CHF {{ number_format($totalPrice, 2) }}</span>
                            </div>
                            @if($discountAmount > 0)
                                <div class="d-flex justify-content-between text-success">
                                    <span>Discount</span>
                                    <span>-CHF {{ number_format($discountAmount, 2) }}</span>
                                </div>
                            @endif
                            <hr>
                            <div class="d-flex justify-content-between">
                                <strong>Total</strong>
                                <strong>CHF {{ number_format($finalPrice, 2) }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if ($step == 5)
        <!-- Step 5: Payment -->
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Payment & Confirmation</h4>
                        <p class="text-muted mb-0">Complete your booking</p>
                    </div>
                    <div class="card-body">
                        <!-- Coupon Code -->
                        <div class="mb-4">
                            <label class="form-label">Coupon Code (Optional)</label>
                            <div class="input-group">
                                <input type="text" class="form-control" wire:model="couponCode" placeholder="Enter coupon code">
                                <button class="btn btn-outline-primary" type="button" wire:click="applyCoupon">Apply</button>
                            </div>
                            @if($appliedCoupon)
                                <div class="mt-2">
                                    <span class="badge bg-success">
                                        Coupon "{{ $appliedCoupon->code }}" applied! 
                                        <button type="button" class="btn-close btn-close-white ms-1" wire:click="removeCoupon"></button>
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Payment Method -->
                        <div class="mb-4">
                            <label class="form-label">Payment Method</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" wire:model="paymentMethod" value="card" id="paymentCard">
                                <label class="form-check-label" for="paymentCard">
                                    <i class="material-icons me-1">credit_card</i> Credit/Debit Card
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" wire:model="paymentMethod" value="cash" id="paymentCash">
                                <label class="form-check-label" for="paymentCash">
                                    <i class="material-icons me-1">payments</i> Pay at Location
                                </label>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="button" class="btn btn-primary btn-lg" wire:click="processPayment">
                                @if($paymentMethod === 'card')
                                    <i class="material-icons me-1">lock</i> Pay Securely - CHF {{ number_format($finalPrice, 2) }}
                                @else
                                    <i class="material-icons me-1">event</i> Confirm Booking
                                @endif
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Final Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="booking-detail mb-3">
                            <strong>Package:</strong> {{ $selectedProduct->name }}<br>
                            <strong>Date:</strong> {{ \Carbon\Carbon::parse($selectedDate)->format('M d, Y') }}<br>
                            <strong>Time:</strong> {{ $selectedTimeSlot }}<br>
                            <strong>Lane:</strong> {{ $selectedLane->name }}<br>
                            <strong>Participants:</strong> {{ $participants }}
                        </div>
                        
                        <div class="participants-list mb-3">
                            <h6>Participants:</h6>
                            <small>1. {{ $customerInfo['name'] }} (Primary)</small><br>
                            @foreach($guestParticipants as $index => $guest)
                                <small>{{ $index + 2 }}. {{ $guest['name'] }}</small><br>
                            @endforeach
                        </div>
                        
                        <hr>
                        <div class="price-breakdown">
                            <div class="d-flex justify-content-between">
                                <span>Subtotal</span>
                                <span>CHF {{ number_format($totalPrice, 2) }}</span>
                            </div>
                            @if($discountAmount > 0)
                                <div class="d-flex justify-content-between text-success">
                                    <span>Discount ({{ $appliedCoupon->code }})</span>
                                    <span>-CHF {{ number_format($discountAmount, 2) }}</span>
                                </div>
                            @endif
                            <hr>
                            <div class="d-flex justify-content-between">
                                <strong>Total</strong>
                                <strong>CHF {{ number_format($finalPrice, 2) }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Navigation Buttons -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="d-flex justify-content-between">
                @if($step > 1)
                    <button type="button" class="btn btn-outline-secondary" wire:click="goBack">
                        <i class="material-icons me-1">arrow_back</i> Back
                    </button>
                @else
                    <div></div>
                @endif
                
                <button type="button" class="btn btn-outline-danger" wire:click="restart">
                    <i class="material-icons me-1">refresh</i> Start Over
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.steps-indicator .step {
    text-align: center;
    position: relative;
}

.steps-indicator .step-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content-center;
    margin: 0 auto 10px;
    border: 2px solid #dee2e6;
}

.steps-indicator .step.active .step-icon {
    background: var(--gradient-red);
    border-color: var(--axtra-red);
    color: white;
    box-shadow: var(--axtra-shadow);
}

.steps-indicator .step-title {
    font-size: 12px;
    color: var(--axtra-gray);
    transition: all 0.3s ease;
}

.steps-indicator .step.active .step-title {
    color: var(--axtra-red);
    font-weight: 700;
}

.product-card, .lane-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: 2px solid transparent;
}

.product-card:hover, .lane-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--axtra-shadow);
    border-color: var(--axtra-red);
}

.time-slot {
    transition: all 0.3s ease;
    border: 2px solid #dee2e6;
}

.time-slot:hover {
    border-color: var(--axtra-red);
    color: var(--axtra-red);
}

.time-slot.active {
    background: var(--gradient-red);
    border-color: var(--axtra-red);
    color: white;
    box-shadow: var(--axtra-shadow);
}

.guest-participant {
    background: rgba(192, 36, 37, 0.05);
    border: 1px solid rgba(192, 36, 37, 0.1);
}

.product-icon i,
.lane-icon i {
    color: var(--axtra-red);
}

.skill-points {
    color: var(--axtra-red) !important;
}

.btn-outline-secondary {
    border-color: var(--axtra-red);
    color: var(--axtra-red);
}

.btn-outline-secondary:hover {
    background: var(--axtra-red);
    color: white;
}

.badge.bg-success {
    background: var(--axtra-red) !important;
}

.text-success {
    color: var(--axtra-red) !important;
}

.text-primary {
    color: var(--axtra-red) !important;
}

.price {
    color: var(--axtra-red) !important;
}

.alert-warning {
    background: rgba(192, 36, 37, 0.1);
    color: var(--axtra-dark);
    border: 1px solid rgba(192, 36, 37, 0.2);
}

.price-breakdown {
    font-size: 14px;
}

.booking-detail {
    font-size: 14px;
    line-height: 1.6;
}

.participants-list {
    font-size: 13px;
}
</style>