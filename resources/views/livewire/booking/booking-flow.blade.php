<div class="container-fluid">
    @if($isGuest)
        <!-- Guest Layout - Clean without sidebar/navbar -->
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-8">
                    @include('livewire.booking.partials.booking-content')
                </div>
            </div>
        </div>
    @else
        <!-- Authenticated Layout -->
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-12 col-xl-10">
                    @include('livewire.booking.partials.booking-content')
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
    let flatpickrInstance = null;

    document.addEventListener('livewire:init', () => {
        // Auto-advance and scroll functionality
        Livewire.on('service-selected', () => {
            setTimeout(() => {
                @this.nextStep();
            }, 1000);
        });
        
        Livewire.on('category-selected', () => {
            setTimeout(() => {
                scrollToElement('#step-1 .card:has(.service-card)', 500);
            }, 300);
        });
        
        Livewire.on('step-changed', (data) => {
            setTimeout(() => {
                scrollToElement('#step-' + data.step, 300);
            }, 200);
        });
    });

    // Scroll helper function
    function scrollToElement(selector, delay = 0) {
        setTimeout(() => {
            const element = document.querySelector(selector);
            if (element) {
                element.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'start',
                    inline: 'nearest'
                });
            }
        }, delay);
    }

    // Simple Flatpickr initialization
    function initFlatpickr() {
        const dateInput = document.querySelector('#selectedDate');
        if (!dateInput || typeof flatpickr === 'undefined') {
            return;
        }
        
        // Destroy existing instance if any
        if (flatpickrInstance) {
            try {
                flatpickrInstance.destroy();
            } catch (e) {}
            flatpickrInstance = null;
        }
        
        // Create new instance
        flatpickrInstance = flatpickr(dateInput, {
            minDate: "today",
            dateFormat: "Y-m-d",
            onChange: function(selectedDates, dateStr) {
                @this.set('selectedDate', dateStr);
            }
        });
    }

    // Initialize when DOM is ready
    document.addEventListener('DOMContentLoaded', initFlatpickr);
    
    // Reinitialize after Livewire updates
    document.addEventListener('livewire:navigated', initFlatpickr);
    
    // Handle upsell quantity changes
    function updateUpsell(upsellId, quantity) {
        @this.call('updateUpsellQuantity', upsellId, quantity);
    }
</script>
@endpush