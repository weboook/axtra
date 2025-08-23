<div id="step-1">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="fw-bold mb-2" style="color: #1b1b1b;">Select Your Experience</h3>
                            <p class="text-muted mb-0">Choose from our exciting axe throwing activities</p>
                        </div>
                        @if($isGuest)
                            <div class="text-end">
                                <button type="button" class="btn btn-outline-primary" wire:click="login">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login to Continue
                                </button>
                                <small class="d-block text-muted mt-2">Get rewards & manage bookings</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Player Count Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3" style="color: #1b1b1b;">
                        <i class="fas fa-users me-2" style="color: #c02425;"></i>
                        How Many Players?
                    </h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text" style="background: linear-gradient(135deg, #c02425 0%, #d63031 100%); color: white; border: none;">
                                    <i class="fas fa-users"></i>
                                </span>
                                <input type="number" class="form-control" wire:model.live="playerCount" 
                                       min="1" max="55" placeholder="Enter number of players"
                                       style="border-left: none; padding-left: 0;">
                            </div>
                            @error('playerCount') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="alert alert-info mb-0" style="background: rgba(192, 36, 37, 0.1); border: 1px solid rgba(192, 36, 37, 0.2); color: #c02425;">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Tip:</strong> Group size affects available experiences and pricing
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Selection -->
    @if(!$selectedCategory || !$preSelectedType)
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4" style="color: #1b1b1b;">
                            <i class="fas fa-list me-2" style="color: #c02425;"></i>
                            Choose Activity Type
                        </h5>
                        <div class="row g-4">
                            @php
                                $categories = [
                                    ['id' => 'axe_throwing', 'icon' => 'fas fa-bullseye', 'color' => '#c02425', 'title' => 'Axe Throwing', 'desc' => 'Pure throwing experience with professional instruction'],
                                    ['id' => 'axe_throwing_making', 'icon' => 'fas fa-hammer', 'color' => '#ffc107', 'title' => 'Axe Throwing & Making', 'desc' => 'Craft your own axe and learn to throw it'],
                                    ['id' => 'axe_making', 'icon' => 'fas fa-tools', 'color' => '#28a745', 'title' => 'Axe Making', 'desc' => 'Forge and craft your own custom axe'],
                                    ['id' => 'private_events', 'icon' => 'fas fa-crown', 'color' => '#6f42c1', 'title' => 'Private Events', 'desc' => 'Exclusive private experiences and offsites']
                                ]
                            @endphp
                            
                            @foreach($categories as $category)
                                <div class="col-md-6">
                                    <div class="card h-100 border-0 category-card" 
                                         style="cursor: pointer; transition: all 0.3s ease; {{ $selectedCategory === $category['id'] ? 'box-shadow: 0 20px 40px rgba(192, 36, 37, 0.2); transform: translateY(-5px);' : 'box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);' }}"
                                         wire:click="selectCategory('{{ $category['id'] }}')"
                                         onmouseover="if (!this.classList.contains('selected')) { this.style.transform='translateY(-3px)'; this.style.boxShadow='0 15px 35px rgba(0, 0, 0, 0.12)'; }"
                                         onmouseout="if (!this.classList.contains('selected')) { this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(0, 0, 0, 0.08)'; }">
                                        <div class="card-body text-center p-4">
                                            <div class="mb-3" style="background: {{ $selectedCategory === $category['id'] ? 'linear-gradient(135deg, #c02425 0%, #d63031 100%)' : $category['color'] }}20; width: 70px; height: 70px; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                                <i class="{{ $category['icon'] }}" style="font-size: 2rem; color: {{ $selectedCategory === $category['id'] ? '#c02425' : $category['color'] }};"></i>
                                            </div>
                                            <h6 class="fw-bold mb-2" style="color: #1b1b1b;">{{ $category['title'] }}</h6>
                                            <p class="text-muted small mb-0">{{ $category['desc'] }}</p>
                                            @if($selectedCategory === $category['id'])
                                                <div class="mt-3">
                                                    <i class="fas fa-check-circle" style="color: #c02425; font-size: 1.2rem;"></i>
                                                </div>
                                            @endif
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

    <!-- Available Services -->
    @if($selectedCategory && count($availableServices) > 0)
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4" style="color: #1b1b1b;">
                            <i class="fas fa-star me-2" style="color: #c02425;"></i>
                            Available Options for {{ $playerCount }} Player{{ $playerCount > 1 ? 's' : '' }}
                        </h5>
                        <div class="row g-4">
                            @foreach($availableServices as $service)
                                <div class="col-lg-6">
                                    <div class="card h-100 border-0 service-card" 
                                         style="cursor: pointer; transition: all 0.3s ease; {{ $selectedService == $service->id ? 'box-shadow: 0 20px 40px rgba(192, 36, 37, 0.25); transform: translateY(-5px); border: 2px solid #c02425;' : 'box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); border: 2px solid transparent;' }}"
                                         wire:click="selectService({{ $service->id }})"
                                         onmouseover="if (!this.style.borderColor.includes('192, 36, 37')) { this.style.transform='translateY(-3px)'; this.style.boxShadow='0 15px 35px rgba(0, 0, 0, 0.12)'; }"
                                         onmouseout="if (!this.style.borderColor.includes('192, 36, 37')) { this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(0, 0, 0, 0.08)'; }">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <div class="flex-grow-1">
                                                    <h6 class="fw-bold mb-2" style="color: #1b1b1b;">{{ $service->name }}</h6>
                                                    <p class="text-muted mb-3">{{ $service->description }}</p>
                                                    <div class="d-flex align-items-center text-muted small mb-3">
                                                        <div class="me-3">
                                                            <i class="fas fa-clock me-1" style="color: #c02425;"></i>{{ $service->duration_hours }}h
                                                        </div>
                                                        <div>
                                                            <i class="fas fa-users me-1" style="color: #c02425;"></i>{{ $service->min_players }}-{{ $service->max_players }} players
                                                        </div>
                                                    </div>
                                                </div>
                                                @if($selectedService == $service->id)
                                                    <div class="ms-3">
                                                        <i class="fas fa-check-circle" style="color: #c02425; font-size: 1.5rem;"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            <div class="border-top pt-3">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <div>
                                                        <span class="fw-bold" style="font-size: 1.5rem; color: #c02425;">
                                                            CHF {{ number_format($service->price, 2) }}
                                                        </span>
                                                        <small class="text-muted ms-1">per person</small>
                                                    </div>
                                                    <div class="text-end">
                                                        <div class="fw-bold text-muted">Total: CHF {{ number_format($service->getTotalPriceForPlayers($playerCount), 2) }}</div>
                                                    </div>
                                                </div>
                                                @if($service->features)
                                                    <div>
                                                        @foreach($service->features as $feature)
                                                            <span class="badge me-1 mb-1" style="background: rgba(192, 36, 37, 0.1); color: #c02425;">{{ $feature }}</span>
                                                        @endforeach
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
            </div>
        </div>
    @elseif($selectedCategory && count($availableServices) === 0)
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-warning" style="border-radius: 1rem; border: none; background: rgba(255, 193, 7, 0.1); color: #856404;">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle me-3" style="font-size: 1.5rem;"></i>
                        <div>
                            <strong>No services available</strong><br>
                            <small>No services available for {{ $playerCount }} players in this category. Please try a different number of players.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Continue Button -->
    @if($selectedService)
        <div class="row">
            <div class="col-12">
                <div class="card border-0" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                    <div class="card-body p-4 text-center">
                        <button type="button" class="btn btn-lg btn-primary px-5" wire:click="nextStep"
                                style="background: linear-gradient(135deg, #c02425 0%, #d63031 100%); border: none; border-radius: 1rem; padding: 1rem 3rem; font-weight: 600; font-size: 1.1rem;">
                            Continue to Date & Details
                            <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                        <div class="mt-3 text-muted">
                            <small>Step 1 of 3 • Next: Select your preferred date and time</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>