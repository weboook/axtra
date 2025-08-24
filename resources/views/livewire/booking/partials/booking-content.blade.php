<!-- Booking Progress Steps -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
            <div class="card-body p-4">
                <!-- Main Titles inside card -->
                <div class="text-center mb-4">
                    @if($step === 1)
                        <h2 class="h3 fw-bold text-dark mb-1">Choose your perfect axe throwing adventure</h2>
                        <p class="text-muted mb-0">Book Your Axe Throwing Experience</p>
                    @elseif($step === 2)
                        <h2 class="h3 fw-bold text-dark mb-1">Book Your Axe Throwing Experience</h2>
                        <p class="text-muted mb-0">Select your date and provide event details</p>
                    @else
                        <h2 class="h3 fw-bold text-dark mb-1">Book Your Axe Throwing Experience</h2>
                        <p class="text-muted mb-0">Review your booking and complete payment</p>
                    @endif
                </div>
                <div class="row g-0">
                    @foreach([
                        ['step' => 1, 'icon' => 'fas fa-list', 'title' => 'Select Service'],
                        ['step' => 2, 'icon' => 'fas fa-calendar', 'title' => 'Date & Details'],
                        ['step' => 3, 'icon' => 'fas fa-credit-card', 'title' => 'Checkout']
                    ] as $progressStep)
                        <div class="col-4">
                            <div class="d-flex flex-column align-items-center text-center position-relative {{ $step >= $progressStep['step'] ? '' : 'opacity-50' }}">
                                <!-- Progress Line (for steps 1 and 2) -->
                                @if(!$loop->last)
                                    <div class="position-absolute d-none d-md-block" style="top: 25px; left: 75%; width: 50%; height: 3px; background: #e9ecef; z-index: 1;">
                                        <div class="progress-bar" role="progressbar" 
                                             style="width: {{ $step > $progressStep['step'] ? '100' : '0' }}%; height: 100%; background: linear-gradient(135deg, #c02425 0%, #d63031 100%); transition: width 0.5s ease;"></div>
                                    </div>
                                @endif
                                
                                <!-- Step Icon -->
                                <div class="mb-3 position-relative" style="background: {{ $step >= $progressStep['step'] ? 'linear-gradient(135deg, #c02425 0%, #d63031 100%)' : 'linear-gradient(135deg, #6c757d 0%, #495057 100%)' }}; width: 50px; height: 50px; border-radius: 15px; display: flex; align-items: center; justify-content: center; color: white; transition: all 0.3s ease; z-index: 2;">
                                    <i class="{{ $progressStep['icon'] }}" style="font-size: 1.2rem;"></i>
                                </div>
                                
                                <!-- Step Content -->
                                <div>
                                    <div class="fw-bold mb-1" style="color: #1b1b1b; font-size: 0.9rem;">{{ $progressStep['title'] }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@if($step === 1)
    @include('livewire.booking.partials.step-1-service-selection')
@elseif($step === 2)
    @include('livewire.booking.partials.step-2-date-details')
@elseif($step === 3)
    @include('livewire.booking.partials.step-3-checkout')
@endif