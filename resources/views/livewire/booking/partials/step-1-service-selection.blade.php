<div id="step-1" class="mb-5">
    <!-- Header with Service Summary and Continue Button -->
    @if($selectedService)
        @php $service = $availableServices->find($selectedService) @endphp
        @if($service)
            <div class="d-flex justify-content-between align-items-center mb-4">
                <!-- Empty space for alignment -->
                <div></div>

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
    @endif

    <!-- Main Content Row -->
    <div class="row g-4">
        <!-- Select Your Experience - 1/4 width -->
        <div class="col-md-3">
            <div class="card border-0 h-100" style="background: #f8f9fa; border-radius: 1rem;">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark mb-3">Select Your Experience</h5>
                    
                    @if($isGuest)
                        <div class="mb-3">
                            <button type="button" class="btn btn-sm btn-outline-primary w-100" wire:click="login" style="border-radius: 0.5rem;">
                                <i class="fas fa-sign-in-alt me-2"></i>Login for Rewards
                            </button>
                        </div>
                    @endif
                    
                    <!-- Player Count -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark mb-2">
                            <i class="fas fa-users me-2" style="color: #c02425;"></i>Players
                        </label>
                        <input type="number" class="form-control text-center" 
                               wire:model.live="playerCount" min="1" max="55" 
                               placeholder="2" style="border-radius: 0.5rem; border: 1px solid #dee2e6;">
                        @error('playerCount') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        <small class="text-muted">Max 55 players</small>
                    </div>

                    <!-- Service Summary -->
                    @if($selectedService)
                        @php $service = $availableServices->find($selectedService) @endphp
                        @if($service)
                            <div class="mt-3 p-3 bg-white rounded" style="border: 1px solid #e9ecef;">
                                <div class="fw-bold text-dark small mb-1">Selected:</div>
                                <div class="fw-bold small" style="color: #c02425;">{{ $service->name }}</div>
                                <div class="fw-bold mt-1" style="color: #c02425;">CHF {{ number_format($service->getTotalPriceForPlayers($playerCount), 2) }}</div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        <!-- Choose Activity Type - 3/4 width -->
        <div class="col-md-9">
            <div class="card border-0 h-100" style="background: white; border-radius: 1rem; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark mb-4">Choose Activity Type</h5>
                    
                    <!-- Category Selection -->
                    @if(!$selectedCategory || !$preSelectedType)
                        <div class="row g-3 mb-4">
                            @php
                                $categories = [
                                    ['id' => 'axe_throwing', 'icon' => 'fas fa-bullseye', 'title' => 'Axe Throwing', 'desc' => 'Pure throwing fun'],
                                    ['id' => 'axe_throwing_making', 'icon' => 'fas fa-hammer', 'title' => 'Throw & Make', 'desc' => 'Craft + throwing'],
                                    ['id' => 'axe_making', 'icon' => 'fas fa-tools', 'title' => 'Axe Making', 'desc' => 'Craft your axe'],
                                    ['id' => 'private_events', 'icon' => 'fas fa-crown', 'title' => 'Private Events', 'desc' => 'Exclusive experience']
                                ]
                            @endphp
                            
                            @foreach($categories as $category)
                                <div class="col-6 col-lg-3">
                                    <button type="button" 
                                            class="btn w-100 p-3 h-100"
                                            wire:click="selectCategory('{{ $category['id'] }}')"
                                            style="border-radius: 0.75rem; 
                                                   border: 1px solid {{ $selectedCategory === $category['id'] ? '#c02425' : '#dee2e6' }}; 
                                                   background: {{ $selectedCategory === $category['id'] ? 'rgba(192, 36, 37, 0.15)' : 'white' }}; 
                                                   color: {{ $selectedCategory === $category['id'] ? '#c02425' : '#333' }}; 
                                                   transition: all 0.2s;"
                                            onmouseover="if (!this.classList.contains('selected')) this.style.background='rgba(192, 36, 37, 0.05)';"
                                            onmouseout="if (!this.classList.contains('selected')) this.style.background='white';"
                                            class="{{ $selectedCategory === $category['id'] ? 'selected' : '' }}">
                                        <i class="{{ $category['icon'] }} mb-2" style="font-size: 1.5rem; color: {{ $selectedCategory === $category['id'] ? '#c02425' : '#6c757d' }};"></i>
                                        <div class="fw-bold small">{{ $category['title'] }}</div>
                                        <small class="d-block" style="opacity: 0.75;">{{ $category['desc'] }}</small>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Available Services -->
                    @if($selectedCategory && count($availableServices) > 0)
                        <div class="border-top pt-4">
                            <h6 class="fw-semibold text-dark mb-3">Services for {{ $playerCount }} Player{{ $playerCount > 1 ? 's' : '' }}</h6>
                            <div class="row g-3">
                                @foreach($availableServices as $service)
                                    @php 
                                        $isAvailable = $this->isServiceAvailableForPlayerCount($service);
                                        $isSelected = $selectedService == $service->id;
                                    @endphp
                                    <div class="col-lg-6">
                                        <div class="card border h-100 {{ !$isAvailable ? 'opacity-50' : '' }}" 
                                             style="cursor: {{ $isAvailable ? 'pointer' : 'not-allowed' }}; 
                                                    transition: all 0.2s ease; 
                                                    border-radius: 0.75rem;
                                                    border-color: {{ $isSelected ? '#c02425' : ($isAvailable ? '#dee2e6' : '#dee2e6') }} !important;
                                                    background: {{ $isSelected ? 'rgba(192, 36, 37, 0.1)' : 'white' }};"
                                             {{ $isAvailable ? 'wire:click=selectService(' . $service->id . ')' : '' }}>
                                            <div class="card-body p-3">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <h6 class="fw-bold mb-0" style="color: {{ $isAvailable ? '#1b1b1b' : '#6c757d' }};">{{ $service->name }}</h6>
                                                    @if($isSelected)
                                                        <i class="fas fa-check-circle" style="color: #c02425;"></i>
                                                    @elseif(!$isAvailable)
                                                        <i class="fas fa-ban" style="color: #6c757d;"></i>
                                                    @endif
                                                </div>
                                                
                                                <p class="small mb-2" style="color: {{ $isAvailable ? '#6c757d' : '#adb5bd' }};">{{ Str::limit($service->description, 60) }}</p>
                                                
                                                <div class="d-flex justify-content-between align-items-center small mb-2" style="color: {{ $isAvailable ? '#6c757d' : '#adb5bd' }};">
                                                    <span><i class="fas fa-clock me-1"></i>{{ $service->duration_hours }}h</span>
                                                    <span><i class="fas fa-users me-1"></i>{{ $service->min_players }}-{{ $service->max_players }}</span>
                                                </div>
                                                
                                                @if(!$isAvailable)
                                                    <div class="text-center py-2">
                                                        <small class="text-muted">
                                                            <i class="fas fa-info-circle me-1"></i>
                                                            Not available for {{ $playerCount }} player{{ $playerCount > 1 ? 's' : '' }}
                                                        </small>
                                                    </div>
                                                @else
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="fw-bold" style="color: #c02425;">
                                                            CHF {{ number_format($service->getTotalPriceForPlayers($playerCount), 2) }}
                                                        </div>
                                                        <small class="text-muted">CHF {{ number_format($service->price, 2) }} per person</small>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @elseif($selectedCategory && count($availableServices) === 0)
                        <div class="border-top pt-4">
                            <div class="alert alert-warning border-0" style="border-radius: 0.5rem;">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                No services found in this category
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>