<div id="step-1" class="mb-5">
    <!-- Header Section -->
    <div class="text-center mb-4">
        <h2 class="fw-bold text-dark mb-2">Select Your Experience</h2>
        <p class="text-muted fs-5 mb-0">Choose from our exciting axe throwing activities</p>
        
        @if($isGuest)
            <div class="mt-3">
                <button type="button" class="btn btn-sm btn-outline-primary" wire:click="login" style="border-radius: 50px;">
                    <i class="fas fa-sign-in-alt me-1"></i>Login for Rewards
                </button>
            </div>
        @endif
    </div>

    <!-- Player Count Section -->
    <div class="row justify-content-center mb-5">
        <div class="col-md-6 col-lg-4">
            <div class="text-center">
                <label class="form-label fw-semibold mb-3 text-dark">
                    <i class="fas fa-users me-2 text-primary"></i>How many players?
                </label>
                <div class="position-relative">
                    <input type="number" class="form-control form-control-lg text-center" 
                           wire:model.live="playerCount" min="1" max="55" 
                           placeholder="2" style="border-radius: 50px; border: 2px solid #e9ecef; font-weight: 600;">
                </div>
                @error('playerCount') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                <small class="text-muted mt-2 d-block">Maximum 55 players</small>
            </div>
        </div>
    </div>

    <!-- Category Selection -->
    @if(!$selectedCategory || !$preSelectedType)
        <div class="text-center mb-5">
            <h4 class="fw-semibold text-dark mb-4">Choose Activity Type</h4>
            <div class="row justify-content-center g-3">
                @php
                    $categories = [
                        ['id' => 'axe_throwing', 'icon' => 'fas fa-bullseye', 'title' => 'Axe Throwing', 'desc' => 'Pure throwing fun'],
                        ['id' => 'axe_throwing_making', 'icon' => 'fas fa-hammer', 'title' => 'Throw & Make', 'desc' => 'Craft + throwing'],
                        ['id' => 'axe_making', 'icon' => 'fas fa-tools', 'title' => 'Axe Making', 'desc' => 'Craft your axe'],
                        ['id' => 'private_events', 'icon' => 'fas fa-crown', 'title' => 'Private Events', 'desc' => 'Exclusive experience']
                    ]
                @endphp
                
                @foreach($categories as $category)
                    <div class="col-6 col-md-3">
                        <button type="button" 
                                class="btn w-100 p-3 {{ $selectedCategory === $category['id'] ? 'btn-primary' : 'btn-outline-light' }}"
                                wire:click="selectCategory('{{ $category['id'] }}')"
                                style="border-radius: 1rem; border: 2px solid {{ $selectedCategory === $category['id'] ? '#c02425' : '#e9ecef' }}; {{ $selectedCategory === $category['id'] ? 'background: linear-gradient(135deg, #c02425 0%, #d63031 100%);' : 'background: white;' }}">
                            <i class="{{ $category['icon'] }} mb-2" style="color: {{ $selectedCategory === $category['id'] ? 'white' : '#c02425' }}; font-size: 1.5rem;"></i>
                            <div class="fw-bold small {{ $selectedCategory === $category['id'] ? 'text-white' : 'text-dark' }}">{{ $category['title'] }}</div>
                            <small class="d-block {{ $selectedCategory === $category['id'] ? 'text-white-50' : 'text-muted' }}">{{ $category['desc'] }}</small>
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Available Services -->
    @if($selectedCategory && count($availableServices) > 0)
        <div class="text-center mb-5">
            <h4 class="fw-semibold text-dark mb-4">Available for {{ $playerCount }} Player{{ $playerCount > 1 ? 's' : '' }}</h4>
            <div class="row justify-content-center g-3">
                @foreach($availableServices as $service)
                    <div class="col-md-6 col-lg-4">
                        <div class="card border-0 h-100 {{ $selectedService == $service->id ? 'border-primary' : '' }}" 
                             style="cursor: pointer; transition: all 0.2s ease; border-radius: 1rem; {{ $selectedService == $service->id ? 'border: 2px solid #c02425; box-shadow: 0 4px 15px rgba(192, 36, 37, 0.2);' : 'border: 1px solid #e9ecef; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);' }}"
                             wire:click="selectService({{ $service->id }})">
                            <div class="card-body p-4 text-center">
                                @if($selectedService == $service->id)
                                    <div class="position-absolute top-0 end-0 m-2">
                                        <i class="fas fa-check-circle text-primary" style="color: #c02425 !important;"></i>
                                    </div>
                                @endif
                                
                                <h6 class="fw-bold mb-2 text-dark">{{ $service->name }}</h6>
                                <p class="text-muted small mb-3">{{ Str::limit($service->description, 80) }}</p>
                                
                                <div class="d-flex justify-content-center align-items-center text-muted small mb-3 gap-3">
                                    <span><i class="fas fa-clock me-1 text-primary"></i>{{ $service->duration_hours }}h</span>
                                    <span><i class="fas fa-users me-1 text-primary"></i>{{ $service->min_players }}-{{ $service->max_players }}</span>
                                </div>
                                
                                <div class="border-top pt-3">
                                    <div class="text-primary fw-bold mb-1" style="font-size: 1.25rem;">
                                        CHF {{ number_format($service->getTotalPriceForPlayers($playerCount), 2) }}
                                    </div>
                                    <small class="text-muted">CHF {{ number_format($service->price, 2) }} per person</small>
                                </div>
                                
                                @if($service->features && count($service->features) > 0)
                                    <div class="mt-3">
                                        @foreach(array_slice($service->features, 0, 2) as $feature)
                                            <span class="badge bg-light text-dark me-1 small">{{ $feature }}</span>
                                        @endforeach
                                        @if(count($service->features) > 2)
                                            <small class="text-muted">+{{ count($service->features) - 2 }} more</small>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @elseif($selectedCategory && count($availableServices) === 0)
        <div class="text-center mb-5">
            <div class="alert alert-warning border-0 d-inline-flex align-items-center" style="border-radius: 50px; background: rgba(255, 193, 7, 0.1);">
                <i class="fas fa-exclamation-triangle me-2 text-warning"></i>
                <span class="text-warning fw-semibold">No services for {{ $playerCount }} players in this category</span>
            </div>
        </div>
    @endif

    <!-- Continue Button -->
    @if($selectedService)
        <div class="text-center">
            <button type="button" class="btn btn-primary btn-lg px-5" wire:click="nextStep"
                    style="background: linear-gradient(135deg, #c02425 0%, #d63031 100%); border: none; border-radius: 50px; padding: 1rem 2.5rem; font-weight: 600;">
                Continue to Date & Time
                <i class="fas fa-arrow-right ms-2"></i>
            </button>
            <div class="mt-3">
                <small class="text-muted">Step 1 of 3 • Next: Select your preferred date and time</small>
            </div>
        </div>
    @endif
</div>