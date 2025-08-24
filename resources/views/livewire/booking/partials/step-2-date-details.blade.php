<div id="step-2">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="fw-bold mb-2" style="color: #1b1b1b;">Date & Time Selection</h3>
                            <p class="text-muted mb-0">Choose your preferred date and time slot</p>
                        </div>
                        <button type="button" class="btn btn-outline-secondary" wire:click="previousStep"
                                style="border-radius: 0.75rem; padding: 0.5rem 1.5rem;">
                            <i class="fas fa-arrow-left me-2"></i>Back
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Selected Service Summary -->
    @if($selectedService)
        @php
            $service = \App\Models\Service::find($selectedService);
        @endphp
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0" style="background: linear-gradient(135deg, rgba(192, 36, 37, 0.1) 0%, rgba(214, 48, 49, 0.05) 100%); border-radius: 1.25rem; border: 1px solid rgba(192, 36, 37, 0.2);">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fw-bold mb-1" style="color: #c02425;">Selected Experience</h6>
                                <div class="d-flex align-items-center">
                                    <strong style="color: #1b1b1b;">{{ $service->name }}</strong>
                                    <span class="mx-2" style="color: #c02425;">•</span>
                                    <span class="text-muted">{{ $playerCount }} player{{ $playerCount > 1 ? 's' : '' }}</span>
                                    <span class="mx-2" style="color: #c02425;">•</span>
                                    <span class="text-muted">{{ $service->duration_hours }}h duration</span>
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold" style="font-size: 1.25rem; color: #c02425;">
                                    CHF {{ number_format($service->getTotalPriceForPlayers($playerCount), 2) }}
                                </div>
                                <small class="text-muted">Total price</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row g-4">
        <!-- Date & Time Selection -->
        <div class="col-lg-6">
            <div class="card border-0 h-100" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4" style="color: #1b1b1b;">
                        <i class="fas fa-calendar-alt me-2" style="color: #c02425;"></i>
                        Select Date & Time
                    </h5>
                    
                    <!-- Date Selection -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold mb-3">Preferred Date</label>
                        <div class="position-relative">
                            <input type="text" class="form-control" wire:model="selectedDate" 
                                   id="selectedDate" placeholder="Click to select date" readonly
                                   style="cursor: pointer; padding-left: 3rem;">
                            <i class="fas fa-calendar-alt position-absolute" 
                               style="left: 1rem; top: 50%; transform: translateY(-50%); color: #c02425;"></i>
                        </div>
                        @error('selectedDate') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                    </div>

                    <!-- Time Selection -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold mb-3">
                            <i class="fas fa-clock me-2" style="color: #c02425;"></i>
                            Preferred Time
                        </label>
                        @if($selectedDate)
                            @if(count($availableSlots) > 0)
                                <div class="row g-2">
                                    @foreach($availableSlots as $slot)
                                        @php
                                            $capacityInfo = null;
                                            $availableCapacity = 55; // Default if no capacity info
                                            $isLowCapacity = false;
                                            
                                            if ($selectedService) {
                                                try {
                                                    $capacityInfo = $this->getSlotCapacityInfo($slot);
                                                    $availableCapacity = $capacityInfo['available_capacity'] ?? 55;
                                                    $isLowCapacity = $availableCapacity <= 10;
                                                } catch (\Exception $e) {
                                                    // Ignore capacity info errors for now
                                                }
                                            }
                                        @endphp
                                        <div class="col-6 col-sm-4">
                                            <button type="button" 
                                                    class="btn w-100 position-relative {{ $selectedTime === $slot ? 'btn-primary' : 'btn-outline-secondary' }}"
                                                    wire:click="$set('selectedTime', '{{ $slot }}')"
                                                    style="border-radius: 0.5rem; font-weight: 600; min-height: 60px; {{ $selectedTime === $slot ? 'background: linear-gradient(135deg, #c02425 0%, #d63031 100%); border-color: #c02425;' : '' }}">
                                                <div class="d-flex flex-column align-items-center">
                                                    <div class="fw-bold">{{ $slot }}</div>
                                                    @if($selectedService)
                                                        <small class="text-muted" style="font-size: 0.75rem;">
                                                            {{ $availableCapacity }}/55 available
                                                        </small>
                                                    @else
                                                        <small class="text-muted" style="font-size: 0.75rem;">
                                                            Available
                                                        </small>
                                                    @endif
                                                </div>
                                                @if($isLowCapacity && $availableCapacity > 0)
                                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark" style="font-size: 0.6rem;">
                                                        Low
                                                    </span>
                                                @endif
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <!-- Capacity Legend -->
                                <div class="mt-3 text-center">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Maximum capacity: 55 participants at any time
                                    </small>
                                </div>
                            @else
                                <div class="alert alert-warning" style="background: rgba(255, 193, 7, 0.1); border: 1px solid rgba(255, 193, 7, 0.3); color: #856404;">
                                    <i class="fas fa-calendar-times me-2"></i>
                                    <strong>Fully Booked</strong><br>
                                    <small>All time slots are fully booked for this date. Please try a different date.</small>
                                </div>
                            @endif
                        @else
                            <div class="alert alert-info" style="background: rgba(192, 36, 37, 0.1); border: 1px solid rgba(192, 36, 37, 0.2); color: #c02425;">
                                <i class="fas fa-info-circle me-2"></i>
                                Please select a date first to see available times
                            </div>
                        @endif
                        @error('selectedTime') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Event Details -->
        <div class="col-lg-6">
            <div class="card border-0 h-100" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4" style="color: #1b1b1b;">
                        <i class="fas fa-star me-2" style="color: #c02425;"></i>
                        Event Details
                    </h5>
                    
                    <!-- Event Type Selection -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold mb-3">What's the occasion?</label>
                        <div class="row g-2">
                            @foreach($eventTypes as $type)
                                <div class="col-6">
                                    <button type="button" 
                                            class="btn w-100 text-start {{ $eventType === $type->slug ? 'btn-primary' : 'btn-outline-secondary' }}"
                                            wire:click="$set('eventType', '{{ $type->slug }}')"
                                            style="min-height: 60px; border-radius: 0.75rem; {{ $eventType === $type->slug ? 'background: linear-gradient(135deg, #c02425 0%, #d63031 100%); border-color: #c02425;' : '' }}">
                                        <div class="d-flex align-items-center">
                                            <i class="{{ $type->icon }} me-2" style="color: {{ $eventType === $type->slug ? 'white' : $type->color }};"></i>
                                            <div>
                                                <div class="fw-semibold small">{{ $type->name }}</div>
                                            </div>
                                        </div>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                        @error('eventType') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                    </div>

                    <!-- Custom Event Type (if "Other" is selected) -->
                    @if($eventType === 'other')
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Please specify your event type</label>
                            <input type="text" class="form-control" wire:model.defer="customEventType" 
                                   placeholder="Tell us about your special event"
                                   style="border-radius: 0.75rem;">
                            @error('customEventType') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                        </div>
                    @endif

                    <!-- Comments -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Special Requests or Comments</label>
                        <textarea class="form-control" wire:model.defer="comments" rows="3" 
                                  placeholder="Any special requests, dietary restrictions, or additional information..."
                                  style="border-radius: 0.75rem; resize: none;"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Guest Information (if guest checkout) -->
    @if($isGuest)
        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-0" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4" style="color: #1b1b1b;">
                            <i class="fas fa-user me-2" style="color: #c02425;"></i>
                            Your Information
                        </h5>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Full Name *</label>
                                <input type="text" class="form-control" wire:model.defer="guestName" 
                                       placeholder="Your full name" style="border-radius: 0.75rem;">
                                @error('guestName') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Email Address *</label>
                                <input type="email" class="form-control" wire:model.defer="guestEmail" 
                                       placeholder="your@email.com" style="border-radius: 0.75rem;">
                                @error('guestEmail') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Phone Number *</label>
                                <input type="tel" class="form-control" wire:model.defer="guestPhone" 
                                       placeholder="+41 12 345 67 89" style="border-radius: 0.75rem;">
                                @error('guestPhone') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        
                        <div class="alert alert-info mt-4" style="background: rgba(33, 136, 255, 0.1); border: 1px solid rgba(33, 136, 255, 0.2); color: #0066cc; border-radius: 1rem;">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-info-circle me-3" style="font-size: 1.2rem;"></i>
                                <div>
                                    <strong>Booking as Guest:</strong> You'll receive a confirmation email with your booking details.<br>
                                    <a href="#" wire:click.prevent="login" class="alert-link fw-semibold">Login or sign up</a> to manage your booking and earn rewards.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Continue Button -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                <div class="card-body p-4 text-center">
                    <button type="button" class="btn btn-lg btn-primary px-5" wire:click="nextStep"
                            style="background: linear-gradient(135deg, #c02425 0%, #d63031 100%); border: none; border-radius: 1rem; padding: 1rem 3rem; font-weight: 600; font-size: 1.1rem;">
                        Continue to Checkout
                        <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                    <div class="mt-3 text-muted">
                        <small>Step 2 of 3 • Next: Review your booking and complete payment</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>