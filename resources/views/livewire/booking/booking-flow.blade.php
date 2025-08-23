<div class="container-fluid px-0">
    @if($isGuest)
        <!-- Guest Layout - Clean without sidebar/navbar -->
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-8">
                    @include('livewire.booking.partials.booking-content')
                </div>
            </div>
        </div>
    @else
        <!-- Authenticated Layout -->
        <div class="container-fluid px-4">
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

    // Initialize and reinitialize Flatpickr
    function initFlatpickr() {
        const dateInput = document.querySelector('#selectedDate');
        if (dateInput) {
            // Destroy existing instance if it exists
            if (dateInput._flatpickr) {
                dateInput._flatpickr.destroy();
            }
            
            // Create new instance
            flatpickr(dateInput, {
                minDate: "today",
                dateFormat: "Y-m-d",
                theme: "material_red",
                disableMobile: true,
                allowInput: false,
                clickOpens: true,
                onChange: function(selectedDates, dateStr, instance) {
                    // Update Livewire property
                    @this.set('selectedDate', dateStr);
                },
                locale: {
                    firstDayOfWeek: 1 // Start week on Monday
                }
            });
        }
    }

    // Initialize on DOM ready
    document.addEventListener('DOMContentLoaded', initFlatpickr);
    
    // Reinitialize after Livewire updates
    document.addEventListener('livewire:navigated', initFlatpickr);
    document.addEventListener('livewire:updated', initFlatpickr);
    
    // Handle upsell quantity changes
    function updateUpsell(upsellId, quantity) {
        @this.call('updateUpsellQuantity', upsellId, quantity);
    }
</script>
@endpush