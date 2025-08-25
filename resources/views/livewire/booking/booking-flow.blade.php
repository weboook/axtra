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
        
        // Reinitialize Flatpickr after any Livewire component update
        Livewire.hook('morph.updated', () => {
            forceReinitFlatpickr();
        });
        
        // Reinitialize after errors are cleared/shown
        Livewire.hook('message.processed', () => {
            setTimeout(forceReinitFlatpickr, 150);
        });
        
        // Reinitialize after validation errors or any component response
        Livewire.hook('message.received', () => {
            setTimeout(forceReinitFlatpickr, 100);
        });
        
        // Additional hook for error handling
        Livewire.hook('element.updated', (el, component) => {
            if (el.querySelector('#selectedDate')) {
                setTimeout(forceReinitFlatpickr, 50);
            }
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
        setTimeout(() => {
            const dateInput = document.querySelector('#selectedDate');
            if (dateInput && !dateInput.dataset.flatpickrInitialized) {
                try {
                    // Clean up any existing instance
                    destroyFlatpickr(dateInput);
                    
                    // Ensure the input is clean
                    dateInput.removeAttribute('readonly');
                    dateInput.classList.remove('flatpickr-input');
                    
                    // Check if flatpickr is available
                    if (typeof flatpickr === 'undefined') {
                        console.warn('Flatpickr not loaded');
                        return;
                    }
                    
                    // Create new instance
                    const fp = flatpickr(dateInput, {
                        minDate: "today",
                        dateFormat: "Y-m-d",
                        theme: "material_red",
                        disableMobile: true,
                        allowInput: false,
                        clickOpens: true,
                        defaultDate: @this.selectedDate || null,
                        onChange: function(selectedDates, dateStr, instance) {
                            // Update Livewire property and trigger slot loading
                            @this.call('setSelectedDate', dateStr);
                        },
                        locale: {
                            firstDayOfWeek: 1 // Start week on Monday
                        },
                        onReady: function(selectedDates, dateStr, instance) {
                            console.log('Flatpickr ready with date:', dateStr);
                        }
                    });
                    
                    // Store reference and mark as initialized
                    if (fp && typeof fp.destroy === 'function') {
                        dateInput._flatpickr = fp;
                        dateInput.dataset.flatpickrInitialized = 'true';
                        console.log('Flatpickr initialized successfully');
                    } else {
                        console.error('Failed to create Flatpickr instance');
                    }
                    
                } catch (error) {
                    console.error('Error initializing Flatpickr:', error);
                    // Remove the initialization flag so it can retry
                    delete dateInput.dataset.flatpickrInitialized;
                }
            }
        }, 100); // Small delay to ensure DOM is ready
    }
    
    // Safe destroy function
    function destroyFlatpickr(dateInput) {
        try {
            if (dateInput._flatpickr) {
                if (typeof dateInput._flatpickr.destroy === 'function') {
                    dateInput._flatpickr.destroy();
                } else if (typeof dateInput._flatpickr.clear === 'function') {
                    dateInput._flatpickr.clear();
                }
                dateInput._flatpickr = null;
            }
        } catch (error) {
            console.warn('Error destroying Flatpickr:', error);
            dateInput._flatpickr = null;
        }
    }
    
    // Force reinitialize Flatpickr (for after errors)
    function forceReinitFlatpickr() {
        setTimeout(() => {
            const dateInput = document.querySelector('#selectedDate');
            if (dateInput) {
                try {
                    // Remove initialization flag
                    delete dateInput.dataset.flatpickrInitialized;
                    
                    // Safely destroy existing instance
                    destroyFlatpickr(dateInput);
                    
                    // Clear any existing event listeners
                    dateInput.removeAttribute('readonly');
                    
                    // Reinitialize after a small delay
                    setTimeout(() => {
                        initFlatpickr();
                        console.log('Flatpickr force reinitialized');
                    }, 50);
                    
                } catch (error) {
                    console.error('Error reinitializing Flatpickr:', error);
                    // Fallback - try simple reinitialization
                    setTimeout(initFlatpickr, 100);
                }
            }
        }, 10);
    }

    // Initialize on DOM ready
    document.addEventListener('DOMContentLoaded', initFlatpickr);
    
    // Reinitialize after Livewire updates
    document.addEventListener('livewire:navigated', forceReinitFlatpickr);
    document.addEventListener('livewire:updated', forceReinitFlatpickr);
    
    // Handle validation errors specifically
    document.addEventListener('livewire:validation-errors', forceReinitFlatpickr);
    
    // Additional safety net for any DOM mutations
    document.addEventListener('livewire:load', forceReinitFlatpickr);
    
    // Simplified mutation observer to avoid excessive reinitializations
    const observer = new MutationObserver(function(mutations) {
        let shouldReinit = false;
        
        mutations.forEach(function(mutation) {
            // Only check for added nodes containing the date input
            if (mutation.addedNodes.length > 0) {
                mutation.addedNodes.forEach(function(node) {
                    if (node.nodeType === Node.ELEMENT_NODE) {
                        // Check if date input was added
                        if (node.id === 'selectedDate' || (node.querySelector && node.querySelector('#selectedDate'))) {
                            shouldReinit = true;
                        }
                    }
                });
            }
        });
        
        if (shouldReinit) {
            setTimeout(initFlatpickr, 150);
        }
    });
    
    // Start observing with reduced scope
    if (document.body) {
        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    }
    
    // Handle upsell quantity changes
    function updateUpsell(upsellId, quantity) {
        @this.call('updateUpsellQuantity', upsellId, quantity);
    }
</script>
@endpush