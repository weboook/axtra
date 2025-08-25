<div id="step-3" class="mb-5">
    <!-- Header with Back Button, Service Summary, and Complete Payment Button -->
    @if($selectedService)
        @php
            $service = \App\Models\Service::find($selectedService);
        @endphp
        <!-- Mobile Layout -->
        <div class="d-block d-lg-none mb-4">
            <!-- Back Button (Full Width on Mobile) -->
            <div class="mb-3">
                <button type="button" class="btn btn-outline-secondary w-100" wire:click="previousStep"
                        style="border-radius: 0.75rem; padding: 0.75rem; border-color: #c02425; color: #c02425; font-weight: 600;">
                    <i class="fas fa-arrow-left me-2"></i>Back to Date & Details
                </button>
            </div>
            
            <!-- Selected Service Summary (Stacked on Mobile) -->
            <div class="card mb-3" style="border: 1px solid rgba(192, 36, 37, 0.2); background: rgba(192, 36, 37, 0.05);">
                <div class="card-body p-3 text-center">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <i class="fas fa-check-circle me-2" style="color: #c02425;"></i>
                        <span class="fw-bold text-dark">{{ $service->name }}</span>
                    </div>
                    <div class="d-flex justify-content-center align-items-center text-muted small">
                        <span>{{ $playerCount }} player{{ $playerCount > 1 ? 's' : '' }}</span>
                        <span class="mx-2">•</span>
                        <span class="fw-bold" style="color: #c02425;">CHF {{ number_format($total, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Complete Payment Button (Full Width on Mobile) -->
            <button type="button" class="btn btn-lg w-100 py-3" wire:click="proceedToPayment"
                    style="background: #c02425; border: none; color: white; border-radius: 0.75rem; font-weight: 600;">
                Complete Payment <i class="fas fa-credit-card ms-2"></i>
            </button>
        </div>

        <!-- Desktop Layout -->
        <div class="d-none d-lg-flex justify-content-between align-items-center mb-4">
            <!-- Back Button -->
            <button type="button" class="btn btn-outline-secondary" wire:click="previousStep"
                    style="border-radius: 0.5rem; padding: 0.5rem 1.5rem; border-color: #c02425; color: #c02425;">
                <i class="fas fa-arrow-left me-2"></i>Back
            </button>

            <!-- Selected Service Summary -->
            <div class="d-inline-flex align-items-center px-4 py-2 rounded-pill" style="background: rgba(192, 36, 37, 0.1); border: 1px solid rgba(192, 36, 37, 0.2);">
                <i class="fas fa-check-circle me-2" style="color: #c02425;"></i>
                <span class="fw-semibold text-dark">{{ $service->name }}</span>
                <span class="mx-2 text-muted">•</span>
                <span class="text-muted">{{ $playerCount }} player{{ $playerCount > 1 ? 's' : '' }}</span>
                <span class="mx-2 text-muted">•</span>
                <span class="fw-bold" style="color: #c02425;">CHF {{ number_format($total, 2) }}</span>
            </div>

            <!-- Complete Payment Button -->
            <button type="button" class="btn btn-lg px-4" wire:click="proceedToPayment"
                    style="background: #c02425; border: none; color: white; border-radius: 0.5rem; padding: 0.5rem 1.5rem;">
                Complete Payment <i class="fas fa-credit-card ms-2"></i>
            </button>
        </div>
    @endif

    <!-- Main Content Row -->
    <div class="row g-4">
        <!-- Booking Summary - 2/3 width -->
        <div class="col-lg-8">
            @if($selectedService)
                @php
                    $service = \App\Models\Service::find($selectedService);
                    $eventTypeModel = \App\Models\EventType::where('slug', $eventType)->first();
                @endphp
                
                @if(!$service)
                    <div class="alert alert-warning border-0" style="border-radius: 0.5rem;">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Service information not found. Please go back to step 1.
                        <div class="mt-2">
                            <button type="button" class="btn btn-sm" wire:click="$set('step', 1)"
                                    style="background: #c02425; border: none; color: white; border-radius: 0.5rem;">
                                Go to Step 1
                            </button>
                        </div>
                    </div>
                @endif

                <!-- Your Experience -->
                <div class="card border-0 mb-4" style="background: #f8f9fa; border-radius: 1rem;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold text-dark mb-3">Your Experience</h5>
                        <!-- Service Details -->
                        <div class="mb-3">
                            <h6 class="fw-bold text-dark mb-2">{{ $service->name }}</h6>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-users me-2" style="color: #c02425;"></i>
                                        <span class="small text-muted">{{ $playerCount }} player{{ $playerCount > 1 ? 's' : '' }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-clock me-2" style="color: #c02425;"></i>
                                        <span class="small text-muted">{{ $service->duration_hours }}h duration</span>
                                    </div>
                                </div>
                                @if($selectedDate && $selectedTime)
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-calendar me-2" style="color: #c02425;"></i>
                                        <span class="small text-muted">{{ date('M j, Y', strtotime($selectedDate)) }} at {{ $selectedTime }}</span>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        @if($eventType && $eventTypeModel)
                            <div class="mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="{{ $eventTypeModel->icon }} me-2" style="color: #c02425;"></i>
                                    <span class="small text-muted">{{ $eventTypeModel->name }}</span>
                                    @if($eventType === 'other' && $customEventType)
                                        <span class="small text-muted">: {{ $customEventType }}</span>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Add-ons -->
                @if(count($upsells) > 0)
                    <div class="card border-0 mb-4" style="background: white; border-radius: 1rem; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-dark mb-3">Add-ons</h5>
                            <div class="row g-4">
                                @foreach($upsells as $upsell)
                                    <div class="col-md-6">
                                        <div class="card border-0" style="border: 1px solid #dee2e6; border-radius: 0.75rem;">
                                            <div class="card-body p-3">
                                                <div class="mb-2">
                                                    <h6 class="fw-bold mb-1 text-dark">{{ $upsell->name }}</h6>
                                                    <p class="text-muted small mb-0">{{ Str::limit($upsell->description, 50) }}</p>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="fw-bold" style="color: #c02425;">CHF {{ number_format($upsell->price, 2) }}</div>
                                                    <div class="d-flex align-items-center">
                                                        <button type="button" class="btn btn-sm me-1"
                                                                wire:click="updateUpsellQuantity({{ $upsell->id }}, {{ max(0, ($selectedUpsells[$upsell->id] ?? 0) - 1) }})"
                                                                style="width: 28px; height: 28px; border-radius: 0.375rem; border: 1px solid #c02425; color: #c02425; background: white;">
                                                            <i class="fas fa-minus" style="font-size: 0.7rem;"></i>
                                                        </button>
                                                        <span class="fw-bold text-dark mx-2 small">{{ $selectedUpsells[$upsell->id] ?? 0 }}</span>
                                                        <button type="button" class="btn btn-sm ms-1"
                                                                wire:click="updateUpsellQuantity({{ $upsell->id }}, {{ ($selectedUpsells[$upsell->id] ?? 0) + 1 }})"
                                                                style="width: 28px; height: 28px; border-radius: 0.375rem; border: none; background: #c02425; color: white;">
                                                            <i class="fas fa-plus" style="font-size: 0.7rem;"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                @if(($selectedUpsells[$upsell->id] ?? 0) > 0)
                                                    <div class="text-end mt-1">
                                                        <small class="fw-bold" style="color: #c02425;">
                                                            Total: CHF {{ number_format($upsell->price * ($selectedUpsells[$upsell->id] ?? 0), 2) }}
                                                        </small>
                                                    </div>
                                                @endif
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

        <!-- Order Summary - 1/3 width -->
        <div class="col-lg-4">
            <div class="card border-0" style="background: white; border-radius: 1rem; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark mb-3">Order Summary</h5>
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
                    <div class="d-flex justify-content-between align-items-center mb-4 p-3 rounded" style="background: rgba(192, 36, 37, 0.1);">
                        <span class="fw-bold text-dark">Total</span>
                        <span class="fw-bold" style="color: #c02425;">CHF {{ number_format($total, 2) }}</span>
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