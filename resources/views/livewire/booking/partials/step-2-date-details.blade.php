<div id="step-2" class="mb-5">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center text-center text-sm-start mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-2">Date & Time Selection</h2>
            <p class="text-muted fs-5 mb-0">Choose your preferred date and time slot</p>
        </div>
        <button type="button" class="btn btn-outline-secondary" wire:click="previousStep"
                style="border-radius: 50px; padding: 0.5rem 1.5rem;">
            <i class="fas fa-arrow-left me-2"></i>Back
        </button>
    </div>

    <!-- Selected Service Summary -->
    @if($selectedService)
        @php
            $service = \App\Models\Service::find($selectedService);
        @endphp
        <div class="text-center mb-5">
            <div class="d-inline-flex align-items-center bg-primary bg-opacity-10 px-4 py-2 rounded-pill">
                <i class="fas fa-check-circle text-primary me-2"></i>
                <span class="fw-semibold text-dark">{{ $service->name }}</span>
                <span class="mx-2 text-muted">•</span>
                <span class="text-muted">{{ $playerCount }} player{{ $playerCount > 1 ? 's' : '' }}</span>
                <span class="mx-2 text-muted">•</span>
                <span class="fw-bold text-primary">CHF {{ number_format($service->getTotalPriceForPlayers($playerCount), 2) }}</span>
            </div>
        </div>
    @endif

    <div class="row g-4">
        <!-- Date & Time Selection -->
        <div class="col-lg-6">
            <div class="mb-4">
                <h4 class="fw-semibold text-dark mb-4 text-center text-lg-start">
                    <i class="fas fa-calendar-alt me-2 text-primary"></i>Select Date & Time
                </h4>
                    
                <!-- Date Selection -->
                <div class="mb-4">
                    <label class="form-label fw-semibold mb-3 text-dark">Preferred Date</label>
                    <div class="position-relative">
                        <input type="text" class="form-control form-control-lg" wire:model="selectedDate" 
                               id="selectedDate" placeholder="Click to select date" readonly
                               style="cursor: pointer; padding-left: 3rem; border-radius: 0.75rem; border: 2px solid #e9ecef;">
                        <i class="fas fa-calendar-alt position-absolute text-primary" 
                           style="left: 1rem; top: 50%; transform: translateY(-50%);"></i>
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
                                        @php
                                            $usedCapacity = 55 - $availableCapacity;
                                            $capacityPercentage = ($usedCapacity / 55) * 100;
                                            $isNearFull = $availableCapacity <= 10;
                                            $isFull = $availableCapacity <= 0;
                                        @endphp
                                        <div class="col-6 col-sm-4">
                                            <button type="button" 
                                                    class="btn w-100 position-relative {{ $selectedTime === $slot ? 'btn-primary' : 'btn-outline-secondary' }} {{ $isFull ? 'disabled' : '' }}"
                                                    wire:click="$set('selectedTime', '{{ $slot }}')"
                                                    {{ $isFull ? 'disabled' : '' }}
                                                    style="border-radius: 0.75rem; font-weight: 600; min-height: 80px; overflow: hidden; {{ $selectedTime === $slot ? 'background: linear-gradient(135deg, #c02425 0%, #d63031 100%); border-color: #c02425;' : '' }}">
                                                
                                                <!-- Capacity Bar Background -->
                                                <div class="position-absolute bottom-0 start-0 w-100" 
                                                     style="height: {{ $capacityPercentage }}%; background: rgba(192, 36, 37, {{ $selectedTime === $slot ? '0.3' : '0.15' }}); transition: all 0.3s ease;"></div>
                                                
                                                <!-- Content -->
                                                <div class="d-flex flex-column align-items-center justify-content-center position-relative" style="z-index: 1;">
                                                    <div class="fw-bold mb-1" style="font-size: 1rem;">{{ $slot }}</div>
                                                    @if($selectedService)
                                                        @if($isFull)
                                                            <small class="text-muted fw-semibold" style="font-size: 0.75rem;">
                                                                <i class="fas fa-times-circle me-1"></i>Full
                                                            </small>
                                                        @elseif($isNearFull)
                                                            <small class="text-warning fw-semibold" style="font-size: 0.75rem;">
                                                                <i class="fas fa-exclamation-triangle me-1"></i>{{ $availableCapacity }} left
                                                            </small>
                                                        @else
                                                            <small class="text-muted" style="font-size: 0.75rem;">
                                                                {{ $availableCapacity }} available
                                                            </small>
                                                        @endif
                                                    @else
                                                        <small class="text-muted" style="font-size: 0.75rem;">
                                                            Available
                                                        </small>
                                                    @endif
                                                </div>
                                                
                                                <!-- Status Icon -->
                                                @if($isNearFull && !$isFull)
                                                    <span class="position-absolute top-0 end-0 m-2">
                                                        <i class="fas fa-fire text-warning" style="font-size: 0.8rem;"></i>
                                                    </span>
                                                @endif
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <!-- Capacity Legend -->
                                <div class="mt-4">
                                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                                        <small class="text-muted mb-2">
                                            <i class="fas fa-chart-bar me-1"></i>
                                            Visual capacity indicator (55 max)
                                        </small>
                                        <div class="d-flex align-items-center gap-3 mb-2">
                                            <small class="text-muted">
                                                <i class="fas fa-square text-success me-1"></i>Available
                                            </small>
                                            <small class="text-muted">
                                                <i class="fas fa-fire text-warning me-1"></i>Nearly Full
                                            </small>
                                            <small class="text-muted">
                                                <i class="fas fa-times-circle text-danger me-1"></i>Full
                                            </small>
                                        </div>
                                    </div>
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
            <div class="mb-4">
                <h4 class="fw-semibold text-dark mb-4 text-center text-lg-start">
                    <i class="fas fa-star me-2 text-primary"></i>Event Details
                </h4>
                    
                <!-- Event Type Selection -->
                <div class="mb-4">
                    <label class="form-label fw-semibold mb-3 text-dark">What's the occasion?</label>
                    <div class="row g-2">
                        @foreach($eventTypes as $type)
                            <div class="col-6">
                                <button type="button" 
                                        class="btn w-100 p-3 {{ $eventType === $type->slug ? 'btn-primary' : 'btn-outline-light' }}"
                                        wire:click="$set('eventType', '{{ $type->slug }}')"
                                        style="border-radius: 0.75rem; border: 2px solid {{ $eventType === $type->slug ? '#c02425' : '#e9ecef' }}; {{ $eventType === $type->slug ? 'background: linear-gradient(135deg, #c02425 0%, #d63031 100%);' : 'background: white;' }}">
                                    <i class="{{ $type->icon }} mb-1" style="color: {{ $eventType === $type->slug ? 'white' : $type->color }};"></i>
                                    <div class="fw-semibold small {{ $eventType === $type->slug ? 'text-white' : 'text-dark' }}">{{ $type->name }}</div>
                                </button>
                            </div>
                        @endforeach
                    </div>
                    @error('eventType') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                </div>

                <!-- Custom Event Type (if "Other" is selected) -->
                @if($eventType === 'other')
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-dark">Please specify your event type</label>
                        <input type="text" class="form-control form-control-lg" wire:model.defer="customEventType" 
                               placeholder="Tell us about your special event"
                               style="border-radius: 0.75rem; border: 2px solid #e9ecef;">
                        @error('customEventType') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                    </div>
                @endif

                <!-- Comments -->
                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Special Requests</label>
                    <textarea class="form-control" wire:model.defer="comments" rows="3" 
                              placeholder="Any special requests or additional information..."
                              style="border-radius: 0.75rem; resize: none; border: 2px solid #e9ecef;"></textarea>
                </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Guest Information (if guest checkout) -->
    @if($isGuest)
        <div class="mt-5">
            <div class="text-center mb-4">
                <h4 class="fw-semibold text-dark">
                    <i class="fas fa-user me-2 text-primary"></i>Your Information
                </h4>
                <p class="text-muted">We need a few details to confirm your booking</p>
            </div>
            
            <div class="row g-3 justify-content-center">
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-dark">Full Name *</label>
                    <input type="text" class="form-control form-control-lg" wire:model.defer="guestName" 
                           placeholder="Your full name" style="border-radius: 0.75rem; border: 2px solid #e9ecef;">
                    @error('guestName') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-dark">Email Address *</label>
                    <input type="email" class="form-control form-control-lg" wire:model.defer="guestEmail" 
                           placeholder="your@email.com" style="border-radius: 0.75rem; border: 2px solid #e9ecef;">
                    @error('guestEmail') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-dark">Phone Number *</label>
                    <input type="tel" class="form-control form-control-lg" wire:model.defer="guestPhone" 
                           placeholder="+41 12 345 67 89" style="border-radius: 0.75rem; border: 2px solid #e9ecef;">
                    @error('guestPhone') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>
            </div>
            
            <div class="text-center mt-4">
                <div class="alert alert-info border-0 d-inline-flex align-items-center" style="border-radius: 50px; background: rgba(13, 202, 240, 0.1);">
                    <i class="fas fa-info-circle me-2 text-info"></i>
                    <span class="text-info">
                        <a href="#" wire:click.prevent="login" class="text-info fw-semibold text-decoration-none">Login or sign up</a> to earn rewards
                    </span>
                </div>
            </div>
        </div>
    @endif

    <!-- Continue Button -->
    <div class="text-center mt-5">
        <button type="button" class="btn btn-primary btn-lg px-5" wire:click="nextStep"
                style="background: linear-gradient(135deg, #c02425 0%, #d63031 100%); border: none; border-radius: 50px; padding: 1rem 2.5rem; font-weight: 600;">
            Continue to Checkout
            <i class="fas fa-arrow-right ms-2"></i>
        </button>
        <div class="mt-3">
            <small class="text-muted">Step 2 of 3 • Next: Review your booking and complete payment</small>
        </div>
    </div>
</div>