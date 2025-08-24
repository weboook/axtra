<div class="container-fluid p-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1" style="color: #1a1a1a; font-weight: 700;">Product Management</h1>
            <p class="text-muted mb-0">Manage services, products, and event types</p>
        </div>
        <button wire:click="showCreateItem" class="btn btn-primary d-flex align-items-center" 
                style="background: #c02425; border-color: #c02425; padding: 12px 24px; border-radius: 12px; font-weight: 600;">
            <i class="fas fa-plus me-2"></i>
            Add New {{ ucfirst(str_replace('_', ' ', $managementMode)) }}
        </button>
    </div>

    <!-- Management Mode Tabs -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0" style="border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                <div class="card-body p-0">
                    <nav class="nav nav-pills nav-fill p-1" style="background: #f8f9fa; border-radius: 16px;">
                        <button class="nav-link rounded-pill fw-semibold {{ $managementMode === 'services' ? 'active' : '' }}" 
                                wire:click="setManagementMode('services')"
                                style="{{ $managementMode === 'services' ? 'background: #c02425; color: white;' : 'color: #666;' }}">
                            <i class="fas fa-bullseye me-2"></i>
                            Services
                        </button>
                        <button class="nav-link rounded-pill fw-semibold {{ $managementMode === 'products' ? 'active' : '' }}" 
                                wire:click="setManagementMode('products')"
                                style="{{ $managementMode === 'products' ? 'background: #c02425; color: white;' : 'color: #666;' }}">
                            <i class="fas fa-shopping-cart me-2"></i>
                            Products & Upsells
                        </button>
                        <button class="nav-link rounded-pill fw-semibold {{ $managementMode === 'event_types' ? 'active' : '' }}" 
                                wire:click="setManagementMode('event_types')"
                                style="{{ $managementMode === 'event_types' ? 'background: #c02425; color: white;' : 'color: #666;' }}">
                            <i class="fas fa-calendar-alt me-2"></i>
                            Event Types
                        </button>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Services Management -->
    @if($managementMode === 'services')
        @include('livewire.admin.products.partials.services-management', compact('services', 'stats', 'categories'))
    @endif

    <!-- Products Management -->
    @if($managementMode === 'products')
        @include('livewire.admin.products.partials.products-management', compact('products', 'stats', 'categories', 'types'))
    @endif

    <!-- Event Types Management -->
    @if($managementMode === 'event_types')
        @include('livewire.admin.products.partials.event-types-management', compact('eventTypes', 'stats'))
    @endif

    <!-- Create Modal -->
    @if($showCreateModal)
        @if($managementMode === 'services')
            @livewire('admin.products.service-create')
        @elseif($managementMode === 'products')
            @livewire('admin.products.product-create')
        @else
            @livewire('admin.products.event-type-create')
        @endif
    @endif

    <!-- Edit Modal -->
    @if($showEditModal && $selectedItem)
        @if($managementMode === 'services')
            @livewire('admin.products.service-edit', ['serviceId' => $selectedItem->id])
        @elseif($managementMode === 'products')
            @livewire('admin.products.product-edit', ['productId' => $selectedItem->id])
        @else
            @livewire('admin.products.event-type-edit', ['eventTypeId' => $selectedItem->id])
        @endif
    @endif

    <!-- Detail Modal -->
    @if($showDetailModal && $selectedItem)
        <div class="modal fade show" style="display: block; background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" style="border-radius: 16px;">
                    <div class="modal-header border-0 p-4">
                        <h5 class="modal-title fw-bold">{{ ucfirst(str_replace('_', ' ', $managementMode)) }} Details</h5>
                        <button type="button" class="btn-close" wire:click="closeModals"></button>
                    </div>
                    <div class="modal-body p-4">
                        @if($managementMode === 'services')
                            @include('livewire.admin.products.partials.service-detail')
                        @elseif($managementMode === 'products')
                            @include('livewire.admin.products.partials.product-detail')
                        @else
                            @include('livewire.admin.products.partials.event-type-detail')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('styles')
<style>
    /* Ensure dropdowns appear above the table container */
    .table-responsive {
        overflow-x: auto;
        overflow-y: visible;
    }
    
    .dropdown-menu {
        z-index: 1050 !important;
    }
    
    /* Prevent dropdown from being clipped */
    .table-responsive .dropdown {
        position: static;
    }
    
    .table-responsive .dropdown-menu {
        position: absolute !important;
        z-index: 1050 !important;
    }

    /* Tab styling */
    .nav-pills .nav-link {
        transition: all 0.3s ease;
    }
    
    .nav-pills .nav-link:hover {
        background: rgba(192, 36, 37, 0.1) !important;
        color: #c02425 !important;
    }
</style>
@endpush

@push('scripts')
<script>
    function toggleSelectAllItems(selectAllCheckbox) {
        const checkboxes = document.querySelectorAll('input[type="checkbox"][wire\\:model="selectedItems"]');
        
        checkboxes.forEach(checkbox => {
            if (!checkbox.disabled) {
                checkbox.checked = selectAllCheckbox.checked;
                checkbox.dispatchEvent(new Event('change'));
            }
        });
    }

    // Update select all checkbox based on individual selections
    document.addEventListener('livewire:init', () => {
        function updateSelectAllState() {
            const checkboxes = document.querySelectorAll('input[type="checkbox"][wire\\:model="selectedItems"]:not([disabled])');
            const selectAllCheckbox = document.getElementById('selectAllItems');
            
            if (checkboxes.length > 0 && selectAllCheckbox) {
                const checkedCount = Array.from(checkboxes).filter(cb => cb.checked).length;
                selectAllCheckbox.checked = checkedCount === checkboxes.length;
                selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < checkboxes.length;
            }
        }

        // Listen for individual checkbox changes
        document.addEventListener('change', function(e) {
            if (e.target.matches('input[type="checkbox"][wire\\:model="selectedItems"]')) {
                updateSelectAllState();
            }
        });

        // Update on Livewire updates
        Livewire.hook('morph.updated', () => {
            updateSelectAllState();
        });
    });
</script>
@endpush