<div id="step-2" class="mb-5">
    <!-- Header with Back Button, Service Summary, and Continue Button -->
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
                    <i class="fas fa-arrow-left me-2"></i>Back to Service Selection
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
                        <span class="fw-bold" style="color: #c02425;">CHF {{ number_format($service->getTotalPriceForPlayers($playerCount), 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Continue Button (Full Width on Mobile) -->
            <button type="button" class="btn btn-lg w-100 py-3" wire:click="nextStep"
                    style="background: #c02425; border: none; color: white; border-radius: 0.75rem; font-weight: 600;">
                Continue to Checkout <i class="fas fa-arrow-right ms-2"></i>
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
                <span class="fw-bold" style="color: #c02425;">CHF {{ number_format($service->getTotalPriceForPlayers($playerCount), 2) }}</span>
            </div>

            <!-- Continue Button -->
            <button type="button" class="btn btn-lg px-4" wire:click="nextStep"
                    style="background: #c02425; border: none; color: white; border-radius: 0.5rem; padding: 0.5rem 1.5rem;">
                Continue <i class="fas fa-arrow-right ms-2"></i>
            </button>
        </div>
    @endif

    <!-- Main Content Row -->
    <div class="row g-4">
        <!-- Date & Time Selection - 2/3 width -->
        <div class="col-12 col-lg-8 order-1 order-lg-1">
            <div class="card border-0 h-100" style="background: #f8f9fa; border-radius: 1rem;">
                <div class="card-body p-3 p-lg-4">
                    <h5 class="fw-bold text-dark mb-3">Date & Time Selection</h5>
                    
                    <!-- Date Selection -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-dark mb-2">
                            <i class="fas fa-calendar-alt me-2" style="color: #c02425;"></i>Preferred Date
                        </label>
                        <div class="position-relative">
                            <input type="text" class="form-control" wire:model="selectedDate" 
                                   id="selectedDate" placeholder="Click to select date" readonly
                                   style="cursor: pointer; padding-left: 3rem; border-radius: 0.5rem; border: 1px solid #dee2e6;">
                            <i class="fas fa-calendar-alt position-absolute" 
                               style="left: 1rem; top: 50%; transform: translateY(-50%); color: #c02425; 
                                      pointer-events: none; z-index: 1;"></i>
                        </div>
                        @error('selectedDate') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <!-- Time Selection -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark mb-2">
                            <i class="fas fa-clock me-2" style="color: #c02425;"></i>Preferred Time
                        </label>
                        
                        @if($selectedDate)
                            @if(count($availableSlots) > 0)
                                <div class="row g-2">
                                    @foreach($availableSlots as $slot)
                                        @php
                                            $capacityInfo = null;
                                            $availableCapacity = 55;
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
                                        <div class="col-6 col-lg-4">
                                            <button type="button" 
                                                    class="btn w-100 position-relative {{ $isFull ? 'disabled' : '' }}"
                                                    wire:click="$set('selectedTime', '{{ $slot }}')"
                                                    {{ $isFull ? 'disabled' : '' }}
                                                    style="border-radius: 0.5rem; font-weight: 600; min-height: 38px; overflow: hidden; 
                                                           border: 1px solid {{ $selectedTime === $slot ? '#c02425' : '#dee2e6' }}; 
                                                           background: {{ $selectedTime === $slot ? 'rgba(192, 36, 37, 0.15)' : 'white' }}; 
                                                           color: {{ $selectedTime === $slot ? '#c02425' : '#333' }};"
                                                    onmouseover="if (!this.classList.contains('disabled')) this.style.background='rgba(192, 36, 37, 0.05)';"
                                                    onmouseout="if (!this.classList.contains('disabled')) this.style.background='{{ $selectedTime === $slot ? 'rgba(192, 36, 37, 0.15)' : 'white' }}';">
                                                
                                                <!-- Capacity Bar Background -->
                                                <div class="position-absolute bottom-0 start-0 w-100" 
                                                     style="height: {{ $capacityPercentage }}%; background: rgba(192, 36, 37, {{ $selectedTime === $slot ? '0.3' : '0.1' }}); transition: all 0.3s ease;"></div>
                                                
                                                <!-- Content -->
                                                <div class="d-flex flex-column justify-content-center align-items-center position-relative" style="z-index: 1;">
                                                    <div class="fw-bold" style="font-size: 0.85rem;">{{ $slot }}</div>
                                                    @if($selectedTime === $slot)
                                                        <i class="fas fa-check-circle mt-1" style="color: #c02425; font-size: 0.7rem;"></i>
                                                    @elseif($isFull)
                                                        <small class="text-muted fw-semibold mt-1" style="font-size: 0.6rem;">
                                                            <i class="fas fa-times-circle"></i>
                                                        </small>
                                                    @elseif($isNearFull)
                                                        <small class="text-warning fw-semibold mt-1" style="font-size: 0.6rem;">
                                                            <i class="fas fa-exclamation-triangle"></i>
                                                        </small>
                                                    @endif
                                                </div>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-warning border-0" style="border-radius: 0.5rem;">
                                    <i class="fas fa-calendar-times me-2"></i>
                                    <strong>Fully Booked</strong><br>
                                    <small>All slots are booked for this date.</small>
                                </div>
                            @endif
                        @else
                            <div class="alert alert-info border-0" style="background: rgba(192, 36, 37, 0.1); border-radius: 0.5rem;">
                                <i class="fas fa-info-circle me-2" style="color: #c02425;"></i>
                                <span style="color: #c02425;">Select a date first</span>
                            </div>
                        @endif
                        @error('selectedTime') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Event Type - 1/3 width -->
        <div class="col-12 col-lg-4 order-2 order-lg-2">
            <div class="card border-0 h-100" style="background: white; border-radius: 1rem; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);">
                <div class="card-body p-3 p-lg-4">
                    <h5 class="fw-bold text-dark mb-3">Event Type</h5>
                    
                    <!-- Event Type Selection -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark mb-2">
                            <i class="fas fa-star me-2" style="color: #c02425;"></i>What's the occasion?
                        </label>
                        <div class="row g-2">
                            @foreach($eventTypes as $type)
                                <div class="col-12">
                                    <button type="button" 
                                            class="btn w-100 p-2"
                                            wire:click="$set('eventType', '{{ $type->slug }}')"
                                            style="border-radius: 0.75rem; 
                                                   border: 1px solid {{ $eventType === $type->slug ? '#c02425' : '#dee2e6' }}; 
                                                   background: {{ $eventType === $type->slug ? 'rgba(192, 36, 37, 0.15)' : 'white' }}; 
                                                   color: {{ $eventType === $type->slug ? '#c02425' : '#333' }}; 
                                                   transition: all 0.2s;"
                                            onmouseover="if (!this.classList.contains('selected')) this.style.background='rgba(192, 36, 37, 0.05)';"
                                            onmouseout="if (!this.classList.contains('selected')) this.style.background='white';"
                                            class="{{ $eventType === $type->slug ? 'selected' : '' }}">
                                        <div class="d-flex align-items-center">
                                            <i class="{{ $type->icon }} me-2" style="color: {{ $eventType === $type->slug ? '#c02425' : $type->color }};"></i>
                                            <div class="fw-semibold small">{{ $type->name }}</div>
                                            @if($eventType === $type->slug)
                                                <i class="fas fa-check-circle ms-auto" style="color: #c02425;"></i>
                                            @endif
                                        </div>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                        @error('eventType') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <!-- Custom Event Type (if "Other" is selected) -->
                    @if($eventType === 'other')
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark">Please specify</label>
                            <input type="text" class="form-control" wire:model.defer="customEventType" 
                                   placeholder="Your special event"
                                   style="border-radius: 0.5rem; border: 1px solid #dee2e6;">
                            @error('customEventType') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    @endif

                    <!-- Comments -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">Special Requests</label>
                        <textarea class="form-control" wire:model.defer="comments" rows="3" 
                                  placeholder="Any special requests..."
                                  style="border-radius: 0.5rem; resize: none; border: 1px solid #dee2e6;"></textarea>
                    </div>
                    
                    <!-- Booking Policy -->
                    <div class="alert alert-info border-0 mt-4" style="background: rgba(13, 202, 240, 0.1); border-radius: 0.75rem;">
                        <div class="d-flex">
                            <i class="fas fa-info-circle me-2 text-info mt-1"></i>
                            <div>
                                <h6 class="text-info fw-bold mb-1">Booking Policy</h6>
                                <small class="text-info">
                                    Changes to your booking can be made up to <strong>48 hours before</strong> your scheduled event. 
                                    After this deadline, no changes will be accepted. Please plan accordingly.
                                </small>
                            </div>
                        </div>
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

</div>