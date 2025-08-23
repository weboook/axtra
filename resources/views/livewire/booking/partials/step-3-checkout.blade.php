<div id="step-3" class="card border-0 shadow mb-4" style="border-radius: 1.25rem;">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="h4 fw-bold mb-1">Review & Checkout</h3>
                <p class="text-muted mb-0">Review your booking and complete payment</p>
            </div>
            <button type="button" class="btn btn-outline-secondary" wire:click="previousStep">
                <i class="fas fa-arrow-left me-2"></i>Back
            </button>
        </div>

        <div class="row">
            <!-- Booking Summary -->
            <div class="col-lg-8 mb-4">
                @if($selectedService)
                    @php
                        $service = \App\Models\Service::find($selectedService);
                        $eventTypeModel = \App\Models\EventType::where('slug', $eventType)->first();
                    @endphp

                    <!-- Main Service -->
                    <div class="card border mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0 fw-bold">Your Experience</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="fw-bold mb-2">{{ $service->name }}</h6>
                                    <div class="text-muted small mb-2">
                                        <i class="fas fa-users me-2"></i>{{ $playerCount }} players
                                        <span class="mx-2">•</span>
                                        <i class="fas fa-clock me-2"></i>{{ $service->duration_hours }}h
                                    </div>
                                    @if($selectedDate && $selectedTime)
                                        <div class="text-muted small">
                                            <i class="fas fa-calendar me-2"></i>{{ date('D, M j, Y', strtotime($selectedDate)) }}
                                            <span class="mx-2">•</span>
                                            <i class="fas fa-clock me-2"></i>{{ $selectedTime }}
                                        </div>
                                    @endif
                                    @if($eventTypeModel)
                                        <div class="mt-2">
                                            <span class="badge" style="background: {{ $eventTypeModel->color }}20; color: {{ $eventTypeModel->color }};">
                                                <i class="{{ $eventTypeModel->icon }} me-1"></i>
                                                {{ $eventTypeModel->name }}
                                                @if($eventType === 'other' && $customEventType)
                                                    - {{ $customEventType }}
                                                @endif
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold">CHF {{ number_format($service->getTotalPriceForPlayers($playerCount), 2) }}</div>
                                    <small class="text-muted">{{ $playerCount }} × CHF {{ number_format($service->price, 2) }}</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upsells Section -->
                    @if(count($upsells) > 0)
                        <div class="card border mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0 fw-bold">Enhance Your Experience</h6>
                                <small class="text-muted">Add extras to make your visit even more memorable</small>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    @foreach($upsells as $upsell)
                                        <div class="col-md-6">
                                            <div class="card h-100">
                                                <div class="card-body p-3">
                                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                                        <div>
                                                            <h6 class="fw-semibold mb-1">{{ $upsell->name }}</h6>
                                                            <p class="text-muted small mb-2">{{ $upsell->description }}</p>
                                                            <div class="fw-bold text-danger">CHF {{ number_format($upsell->price, 2) }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <button type="button" class="btn btn-sm btn-outline-danger me-2"
                                                                wire:click="updateUpsellQuantity({{ $upsell->id }}, {{ max(0, ($selectedUpsells[$upsell->id] ?? 0) - 1) }})">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                        <span class="fw-bold mx-2">{{ $selectedUpsells[$upsell->id] ?? 0 }}</span>
                                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                                                wire:click="updateUpsellQuantity({{ $upsell->id }}, {{ ($selectedUpsells[$upsell->id] ?? 0) + 1 }})">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Comments -->
                    @if($comments)
                        <div class="card border mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0 fw-bold">Special Requests</h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">{{ $comments }}</p>
                            </div>
                        </div>
                    @endif
                @endif
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card border sticky-top" style="top: 20px;">
                    <div class="card-header" style="background: linear-gradient(135deg, #c02425 0%, #d63031 100%); color: white;">
                        <h6 class="mb-0 fw-bold text-white">Order Summary</h6>
                    </div>
                    <div class="card-body">
                        <!-- Service Total -->
                        @if($selectedService)
                            @php
                                $service = \App\Models\Service::find($selectedService);
                                $serviceTotal = $service->getTotalPriceForPlayers($playerCount);
                            @endphp
                            <div class="d-flex justify-content-between mb-2">
                                <span>{{ $service->name }}</span>
                                <span>CHF {{ number_format($serviceTotal, 2) }}</span>
                            </div>
                        @endif

                        <!-- Upsells -->
                        @foreach($selectedUpsells as $upsellId => $quantity)
                            @if($quantity > 0)
                                @php
                                    $upsell = \App\Models\Product::find($upsellId);
                                    $upsellTotal = $upsell->price * $quantity;
                                @endphp
                                <div class="d-flex justify-content-between mb-2">
                                    <span>{{ $upsell->name }} ({{ $quantity }}x)</span>
                                    <span>CHF {{ number_format($upsellTotal, 2) }}</span>
                                </div>
                            @endif
                        @endforeach

                        <hr>

                        <!-- Coupon Application -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Coupon Code</label>
                            <div class="input-group">
                                <input type="text" class="form-control" wire:model.defer="couponCode" 
                                       placeholder="Enter coupon code">
                                <button type="button" class="btn btn-outline-danger" wire:click="applyCoupon">
                                    Apply
                                </button>
                            </div>
                            @error('couponCode') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <!-- Applied Coupon -->
                        @if($appliedCoupon)
                            <div class="d-flex justify-content-between mb-2 text-success">
                                <span>
                                    {{ $appliedCoupon->name }}
                                    <button type="button" class="btn btn-sm btn-link text-danger p-0 ms-1" wire:click="removeCoupon">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </span>
                                <span>-CHF {{ number_format($discount, 2) }}</span>
                            </div>
                            <hr>
                        @endif

                        <!-- Subtotal -->
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <span>CHF {{ number_format($subtotal, 2) }}</span>
                        </div>

                        @if($discount > 0)
                            <div class="d-flex justify-content-between mb-2 text-success">
                                <span>Discount</span>
                                <span>-CHF {{ number_format($discount, 2) }}</span>
                            </div>
                        @endif

                        <hr class="my-3">

                        <!-- Total -->
                        <div class="d-flex justify-content-between mb-3">
                            <span class="h6 fw-bold">Total</span>
                            <span class="h6 fw-bold text-danger">CHF {{ number_format($total, 2) }}</span>
                        </div>

                        <!-- Guest Info Summary -->
                        @if($isGuest && $guestName)
                            <div class="border-top pt-3 mb-3">
                                <h6 class="fw-bold mb-2">Booking Contact</h6>
                                <div class="text-muted small">
                                    <div>{{ $guestName }}</div>
                                    <div>{{ $guestEmail }}</div>
                                    <div>{{ $guestPhone }}</div>
                                </div>
                            </div>
                        @endif

                        <!-- Payment Button -->
                        <button type="button" class="btn btn-lg w-100" 
                                style="background: linear-gradient(135deg, #c02425 0%, #d63031 100%); color: white; border: none; padding: 15px;"
                                wire:click="proceedToPayment">
                            <i class="fas fa-lock me-2"></i>Proceed to Payment
                        </button>
                        
                        <div class="text-center mt-3">
                            <small class="text-muted">
                                <i class="fas fa-shield-alt me-1"></i>
                                Secure payment powered by PayRexx
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Auto-calculate totals when upsells change
    document.addEventListener('livewire:init', () => {
        Livewire.on('upsellChanged', () => {
            @this.calculateTotals();
        });
    });
    
    // Trigger calculation whenever upsells are updated
    document.addEventListener('livewire:navigated', () => {
        @this.calculateTotals();
    });
    
    // Initial calculation
    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {
            @this.calculateTotals();
        }, 100);
    });
</script>