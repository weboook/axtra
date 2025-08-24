<div id="step-3" class="mb-5">
    <!-- Modern Header -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card border-0 shadow-lg" style="border-radius: 1.5rem; background: linear-gradient(135deg, rgba(192, 36, 37, 0.05) 0%, rgba(255, 255, 255, 1) 100%);">
                <div class="card-body p-5">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-gradient p-3 rounded-circle me-4" style="background: linear-gradient(135deg, #c02425 0%, #d63031 100%);">
                                    <i class="fas fa-credit-card text-white" style="font-size: 1.5rem;"></i>
                                </div>
                                <div>
                                    <h2 class="fw-bold mb-1" style="color: #1b1b1b; font-size: 2rem;">Review & Checkout</h2>
                                    <p class="text-muted mb-0 fs-5">You're almost there! Review your booking details and complete your payment.</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center text-muted">
                                <i class="fas fa-shield-alt me-2 text-success"></i>
                                <small>Secure SSL encrypted payment powered by PayRexx</small>
                            </div>
                        </div>
                        <div class="col-lg-4 text-lg-end">
                            <button type="button" class="btn btn-outline-dark btn-lg" wire:click="previousStep"
                                    style="border-radius: 1rem; padding: 0.75rem 2rem; border-width: 2px;">
                                <i class="fas fa-arrow-left me-2"></i>Back to Details
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Booking Summary -->
        <div class="col-lg-8">
            @if($selectedService)
                    @php
                        $service = \App\Models\Service::find($selectedService);
                        $eventTypeModel = \App\Models\EventType::where('slug', $eventType)->first();
                    @endphp
                    
                    @if(!$service)
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Service information not found. Please go back to step 1 to reselect your service.
                            <div class="mt-2">
                                <button type="button" class="btn btn-primary btn-sm" wire:click="$set('step', 1)">
                                    Go to Step 1
                                </button>
                            </div>
                        </div>
                    @endif

                <!-- Main Service -->
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 1.5rem; background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(248, 249, 250, 1) 100%);">
                    <div class="card-header border-0 bg-transparent pb-2">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary p-2 rounded-circle me-3" style="background: linear-gradient(135deg, #c02425 0%, #d63031 100%) !important;">
                                <i class="fas fa-bullseye text-white"></i>
                            </div>
                            <h5 class="mb-0 fw-bold text-dark">Your Experience</h5>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h4 class="fw-bold mb-3 text-dark">{{ $service->name }}</h4>
                                
                                <!-- Experience Details -->
                                <div class="row g-3 mb-3">
                                    <div class="col-sm-6">
                                        <div class="d-flex align-items-center p-3 rounded-3" style="background: rgba(192, 36, 37, 0.1);">
                                            <i class="fas fa-users me-3" style="color: #c02425; font-size: 1.2rem;"></i>
                                            <div>
                                                <div class="fw-bold text-dark">{{ $playerCount }} {{ $playerCount > 1 ? 'Players' : 'Player' }}</div>
                                                <small class="text-muted">Participants</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="d-flex align-items-center p-3 rounded-3" style="background: rgba(192, 36, 37, 0.1);">
                                            <i class="fas fa-clock me-3" style="color: #c02425; font-size: 1.2rem;"></i>
                                            <div>
                                                <div class="fw-bold text-dark">{{ $service->duration_hours }}h</div>
                                                <small class="text-muted">Duration</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                @if($selectedDate && $selectedTime)
                                    <div class="p-3 rounded-3 mb-3" style="background: rgba(33, 37, 41, 0.1);">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="fas fa-calendar me-2 text-primary"></i>
                                                    <strong>{{ date('l, F j, Y', strtotime($selectedDate)) }}</strong>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="fas fa-clock me-2 text-primary"></i>
                                                    <strong>{{ $selectedTime }}</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                
                                @if($eventTypeModel)
                                    <div class="mb-3">
                                        <span class="badge px-3 py-2" style="background: {{ $eventTypeModel->color }}20; color: {{ $eventTypeModel->color }}; border-radius: 1rem; font-size: 0.9rem;">
                                            <i class="{{ $eventTypeModel->icon }} me-2"></i>
                                            {{ $eventTypeModel->name }}
                                            @if($eventType === 'other' && $customEventType)
                                                - {{ $customEventType }}
                                            @endif
                                        </span>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="col-md-4 text-end">
                                <div class="p-4 rounded-3" style="background: rgba(192, 36, 37, 0.1);">
                                    <div class="fs-2 fw-bold text-primary mb-1">CHF {{ number_format($service->getTotalPriceForPlayers($playerCount), 2) }}</div>
                                    <small class="text-muted">{{ $playerCount }} × CHF {{ number_format($service->price, 2) }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upsells Section -->
                @if(count($upsells) > 0)
                    <div class="card border-0 shadow-sm mb-4" style="border-radius: 1.5rem;">
                        <div class="card-header border-0 bg-transparent pb-2">
                            <div class="d-flex align-items-center">
                                <div class="bg-success p-2 rounded-circle me-3">
                                    <i class="fas fa-plus text-white"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1 fw-bold text-dark">Enhance Your Experience</h5>
                                    <small class="text-muted">Add extras to make your visit even more memorable</small>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="row g-4">
                                @foreach($upsells as $upsell)
                                    <div class="col-md-6">
                                        <div class="card border-0 h-100" style="background: linear-gradient(135deg, rgba(248, 249, 250, 1) 0%, rgba(233, 236, 239, 1) 100%); border-radius: 1rem;">
                                            <div class="card-body p-4">
                                                <div class="d-flex justify-content-between align-items-start mb-3">
                                                    <div class="flex-grow-1">
                                                        <h6 class="fw-bold mb-2 text-dark">{{ $upsell->name }}</h6>
                                                        <p class="text-muted mb-3" style="font-size: 0.9rem;">{{ $upsell->description }}</p>
                                                        <div class="fs-5 fw-bold text-success">CHF {{ number_format($upsell->price, 2) }}</div>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <button type="button" class="btn btn-outline-danger btn-sm rounded-circle me-2"
                                                                wire:click="updateUpsellQuantity({{ $upsell->id }}, {{ max(0, ($selectedUpsells[$upsell->id] ?? 0) - 1) }})"
                                                                style="width: 40px; height: 40px;">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                        <span class="fs-5 fw-bold text-dark mx-3">{{ $selectedUpsells[$upsell->id] ?? 0 }}</span>
                                                        <button type="button" class="btn btn-danger btn-sm rounded-circle ms-2"
                                                                wire:click="updateUpsellQuantity({{ $upsell->id }}, {{ ($selectedUpsells[$upsell->id] ?? 0) + 1 }})"
                                                                style="width: 40px; height: 40px;">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </div>
                                                    @if(($selectedUpsells[$upsell->id] ?? 0) > 0)
                                                        <div class="text-end">
                                                            <div class="fw-bold text-success">
                                                                CHF {{ number_format($upsell->price * ($selectedUpsells[$upsell->id] ?? 0), 2) }}
                                                            </div>
                                                        </div>
                                                    @endif
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
                    <div class="card border-0 shadow-sm mb-4" style="border-radius: 1.5rem;">
                        <div class="card-header border-0 bg-transparent pb-2">
                            <div class="d-flex align-items-center">
                                <div class="bg-info p-2 rounded-circle me-3">
                                    <i class="fas fa-comment-dots text-white"></i>
                                </div>
                                <h5 class="mb-0 fw-bold text-dark">Special Requests</h5>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="p-3 rounded-3" style="background: rgba(13, 202, 240, 0.1);">
                                <p class="mb-0 text-dark">{{ $comments }}</p>
                            </div>
                        </div>
                    </div>
                @endif
                @else
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        No service selected. Please complete the booking process from the beginning.
                        <div class="mt-2">
                            <button type="button" class="btn btn-primary btn-sm" wire:click="$set('step', 1)">
                                Start Over
                            </button>
                        </div>
                    </div>
                @endif
            </div>

        <!-- Order Summary -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-lg sticky-top" style="top: 20px; border-radius: 1.5rem;">
                <div class="card-header border-0 text-center py-4" style="background: linear-gradient(135deg, #c02425 0%, #d63031 100%); border-radius: 1.5rem 1.5rem 0 0;">
                    <div class="d-flex align-items-center justify-content-center text-white">
                        <i class="fas fa-receipt me-2" style="font-size: 1.2rem;"></i>
                        <h4 class="mb-0 fw-bold">Order Summary</h4>
                    </div>
                </div>
                <div class="card-body p-4">
                    <!-- Service Total -->
                    @if($selectedService)
                        @php
                            $service = \App\Models\Service::find($selectedService);
                            $serviceTotal = $service->getTotalPriceForPlayers($playerCount);
                        @endphp
                        <div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded-3" style="background: rgba(248, 249, 250, 0.8);">
                            <span class="fw-semibold text-dark">{{ $service->name }}</span>
                            <span class="fw-bold text-primary">CHF {{ number_format($serviceTotal, 2) }}</span>
                        </div>
                    @endif

                    <!-- Upsells -->
                    @foreach($selectedUpsells as $upsellId => $quantity)
                        @if($quantity > 0)
                            @php
                                $upsell = \App\Models\Product::find($upsellId);
                                $upsellTotal = $upsell->price * $quantity;
                            @endphp
                            <div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded-3" style="background: rgba(25, 135, 84, 0.1);">
                                <span class="fw-semibold text-dark">{{ $upsell->name }} ({{ $quantity }}x)</span>
                                <span class="fw-bold text-success">CHF {{ number_format($upsellTotal, 2) }}</span>
                            </div>
                        @endif
                    @endforeach

                    <hr class="my-4">

                    <!-- Coupon Application -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold mb-3">
                            <i class="fas fa-tag me-2 text-warning"></i>Coupon Code
                        </label>
                        <div class="input-group">
                            <input type="text" class="form-control" wire:model.defer="couponCode" 
                                   placeholder="Enter coupon code" style="border-radius: 0.75rem 0 0 0.75rem; border-right: none;">
                            <button type="button" class="btn btn-warning fw-semibold" wire:click="applyCoupon"
                                    style="border-radius: 0 0.75rem 0.75rem 0;">
                                <i class="fas fa-check me-1"></i>Apply
                            </button>
                        </div>
                        @error('couponCode') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <!-- Applied Coupon -->
                    @if($appliedCoupon)
                        <div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded-3 text-success" style="background: rgba(25, 135, 84, 0.1);">
                            <span class="fw-semibold">
                                <i class="fas fa-check-circle me-2"></i>{{ $appliedCoupon->name }}
                                <button type="button" class="btn btn-sm btn-link text-danger p-0 ms-2" wire:click="removeCoupon">
                                    <i class="fas fa-times"></i>
                                </button>
                            </span>
                            <span class="fw-bold">-CHF {{ number_format($discount, 2) }}</span>
                        </div>
                        <hr class="my-4">
                    @endif

                    <!-- Subtotal -->
                    <div class="d-flex justify-content-between align-items-center mb-3 p-2">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-semibold">CHF {{ number_format($subtotal, 2) }}</span>
                    </div>

                    @if($discount > 0)
                        <div class="d-flex justify-content-between align-items-center mb-3 p-2 text-success">
                            <span>Discount Applied</span>
                            <span class="fw-semibold">-CHF {{ number_format($discount, 2) }}</span>
                        </div>
                    @endif

                    <hr class="my-4" style="border-width: 2px;">

                    <!-- Total -->
                    <div class="d-flex justify-content-between align-items-center mb-4 p-3 rounded-3" style="background: rgba(192, 36, 37, 0.1);">
                        <span class="h5 fw-bold text-dark">Total</span>
                        <span class="h4 fw-bold text-primary">CHF {{ number_format($total, 2) }}</span>
                    </div>

                    <!-- Guest Info Summary -->
                    @if($isGuest && $guestName)
                        <div class="p-3 rounded-3 mb-4" style="background: rgba(13, 202, 240, 0.1);">
                            <h6 class="fw-bold mb-2 text-info">
                                <i class="fas fa-user me-2"></i>Booking Contact
                            </h6>
                            <div class="text-muted small">
                                <div class="mb-1"><strong>{{ $guestName }}</strong></div>
                                <div class="mb-1">{{ $guestEmail }}</div>
                                <div>{{ $guestPhone }}</div>
                            </div>
                        </div>
                    @endif

                    <!-- Payment Button -->
                    <button type="button" class="btn btn-lg w-100 mb-3 shadow" 
                            style="background: linear-gradient(135deg, #c02425 0%, #d63031 100%); color: white; border: none; padding: 1rem; border-radius: 1rem; font-size: 1.1rem;"
                            wire:click="proceedToPayment">
                        <i class="fas fa-credit-card me-2"></i>Complete Payment
                        <div class="small mt-1">CHF {{ number_format($total, 2) }}</div>
                    </button>
                    
                    <div class="text-center">
                        <div class="d-flex align-items-center justify-content-center text-muted">
                            <i class="fas fa-shield-alt me-2 text-success"></i>
                            <small>256-bit SSL secured by PayRexx</small>
                        </div>
                        <div class="mt-2">
                            <i class="fab fa-cc-visa me-1 text-muted"></i>
                            <i class="fab fa-cc-mastercard me-1 text-muted"></i>
                            <i class="fab fa-cc-amex me-1 text-muted"></i>
                            <i class="fab fa-cc-paypal me-1 text-muted"></i>
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