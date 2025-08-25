<div class="container-fluid">
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

    /* Mobile optimizations for admin products page */
    @media (max-width: 768px) {
        /* Header section mobile fixes */
        .d-flex.justify-content-between.align-items-center.mb-4 {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 15px;
        }
        
        .btn.btn-primary {
            width: 100%;
            justify-content: center;
            font-size: 0.9rem !important;
            padding: 12px 20px !important;
        }
        
        /* Tab navigation mobile */
        .nav.nav-pills.nav-fill {
            flex-direction: column !important;
            gap: 8px !important;
        }
        
        .nav-pills .nav-link {
            padding: 12px 16px !important;
            font-size: 0.85rem !important;
            text-align: left !important;
            border-radius: 12px !important;
        }
        
        .nav-pills .nav-link i {
            font-size: 0.8rem !important;
        }
        
        /* Stats cards mobile layout - 4 cards in 2x2 grid */
        .row.mb-4 .col-md-3 {
            flex: 0 0 50% !important;
            max-width: 50% !important;
            margin-bottom: 15px;
        }
        
        .row.mb-4 .col-md-3:nth-child(odd) {
            padding-right: 8px;
        }
        
        .row.mb-4 .col-md-3:nth-child(even) {
            padding-left: 8px;
        }
        
        .card-body h3 {
            font-size: 1.3rem !important;
        }
        
        .card-body small {
            font-size: 0.75rem !important;
        }
        
        /* Filters section mobile layout */
        .card-body.p-4 {
            padding: 16px !important;
        }
        
        .col-md-4,
        .col-md-2 {
            margin-bottom: 15px !important;
        }
        
        .form-label {
            font-size: 0.85rem !important;
            margin-bottom: 6px !important;
        }
        
        .input-group .btn {
            font-size: 0.85rem !important;
        }
        
        /* Table mobile responsiveness */
        .table-responsive {
            border-radius: 12px;
            margin: 0 -8px;
        }
        
        .table {
            min-width: 900px;
        }
        
        .table th,
        .table td {
            padding: 12px 8px !important;
            font-size: 0.85rem !important;
        }
        
        .table th {
            font-size: 0.8rem !important;
        }
        
        /* Service/Product name mobile layout */
        .table .fw-semibold.text-dark {
            font-size: 0.9rem !important;
        }
        
        .table small.text-muted {
            font-size: 0.75rem !important;
            display: block !important;
            margin-top: 4px;
        }
        
        /* Badge adjustments */
        .badge {
            font-size: 0.7rem !important;
            padding: 4px 8px !important;
        }
        
        /* Price and duration mobile */
        .fw-semibold.text-success {
            font-size: 0.85rem !important;
        }
        
        .table small {
            font-size: 0.7rem !important;
        }
        
        /* Players column mobile */
        .table .fw-semibold {
            font-size: 0.85rem !important;
        }
        
        /* Actions dropdown mobile */
        .dropdown-menu {
            min-width: 200px !important;
        }
        
        .dropdown-item {
            font-size: 0.85rem !important;
            padding: 8px 16px !important;
        }
        
        /* Modal mobile adjustments */
        .modal-dialog {
            margin: 10px !important;
            max-width: calc(100vw - 20px) !important;
        }
        
        .modal-header,
        .modal-body,
        .modal-footer {
            padding: 16px !important;
        }
        
        .modal-title {
            font-size: 1.1rem !important;
        }
        
        /* Product detail modal mobile */
        .modal-dialog.modal-lg {
            max-width: calc(100vw - 20px) !important;
        }
        
        /* Card footer pagination mobile */
        .card-footer {
            padding: 12px !important;
        }
        
        /* Hide less important columns on mobile */
        .table th:nth-child(5),
        .table td:nth-child(5),
        .table th:nth-child(6),
        .table td:nth-child(6) {
            display: none;
        }
    }

    /* Small mobile screens */
    @media (max-width: 576px) {
        .container-fluid {
            padding-left: 10px !important;
            padding-right: 10px !important;
        }
        
        /* Full width stats cards on small screens */
        .row.mb-4 .col-md-3 {
            flex: 0 0 100% !important;
            max-width: 100% !important;
            padding: 0 !important;
        }
        
        /* Smaller table text */
        .table th,
        .table td {
            padding: 8px 4px !important;
            font-size: 0.8rem !important;
        }
        
        .table {
            min-width: 700px;
        }
        
        /* Hide more columns on very small screens */
        .table th:nth-child(4),
        .table td:nth-child(4) {
            display: none;
        }
        
        /* Filters stacked vertically */
        .col-md-4,
        .col-md-2 {
            flex: 0 0 100% !important;
            max-width: 100% !important;
        }
        
        /* Modal full screen on small screens */
        .modal-dialog {
            margin: 0 !important;
            max-width: 100vw !important;
            height: 100vh !important;
        }
        
        .modal-content {
            height: 100vh !important;
            border-radius: 0 !important;
        }
        
        /* Tab navigation even more compact */
        .nav-pills .nav-link {
            padding: 10px 12px !important;
            font-size: 0.8rem !important;
        }
        
        .nav-pills .nav-link i {
            font-size: 0.75rem !important;
        }
    }

    /* Extra small mobile screens */
    @media (max-width: 480px) {
        /* Hide category column on very small screens */
        .table th:nth-child(3),
        .table td:nth-child(3) {
            display: none;
        }
        
        .table {
            min-width: 600px;
        }
        
        /* More compact cards */
        .card-body {
            padding: 12px !important;
        }
        
        .card-body h3 {
            font-size: 1.1rem !important;
        }
        
        /* Tab text only, hide icons */
        .nav-pills .nav-link i {
            display: none !important;
        }
        
        .nav-pills .nav-link {
            padding: 8px 12px !important;
            font-size: 0.75rem !important;
        }
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