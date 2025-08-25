<div class="container-fluid">
    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="border-radius: 12px; border: none;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="border-radius: 12px; border: none;">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1" style="color: #1a1a1a; font-weight: 700;">Level Management</h1>
            <p class="text-muted mb-0">Create and manage user skill levels, ranks, and progression</p>
        </div>
        <button wire:click="showCreateLevel" class="btn btn-primary d-flex align-items-center" 
                style="background: #c02425; border-color: #c02425; padding: 12px 24px; border-radius: 12px; font-weight: 600;">
            <i class="fas fa-plus me-2"></i>
            Create New Level
        </button>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1 fw-bold">{{ $stats['total'] }}</h4>
                            <small class="opacity-75">Total Levels</small>
                        </div>
                        <i class="fas fa-layer-group fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                <div class="card-body text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1 fw-bold">{{ $stats['active'] }}</h4>
                            <small class="opacity-75">Active Levels</small>
                        </div>
                        <i class="fas fa-check-circle fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);">
                <div class="card-body text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1 fw-bold">{{ $stats['inactive'] }}</h4>
                            <small class="opacity-75">Inactive Levels</small>
                        </div>
                        <i class="fas fa-pause-circle fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);">
                <div class="card-body text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1 fw-bold">{{ $stats['users_with_levels'] }}</h4>
                            <small class="opacity-75">Users with Levels</small>
                        </div>
                        <i class="fas fa-users fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="card mb-4" style="border: none; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-muted small">Search Levels</label>
                    <div class="input-group">
                        <span class="input-group-text border-0" style="background: #f8f9fa;"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" wire:model.live.debounce.300ms="search" class="form-control border-start-0" 
                               placeholder="Name or description..." style="background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 0 8px 8px 0;">
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold text-muted small">Show Inactive</label>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" wire:model.live="showInactive" id="showInactive">
                        <label class="form-check-label" for="showInactive">Include inactive</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold text-muted small">Per Page</label>
                    <select wire:model.live="perPage" class="form-select" style="border-radius: 8px;">
                        <option value="15">15</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-muted small">Bulk Actions</label>
                    <div class="input-group">
                        <select wire:model="bulkAction" class="form-select" style="border-radius: 8px 0 0 8px;">
                            <option value="">Choose action...</option>
                            <option value="activate">Activate</option>
                            <option value="deactivate">Deactivate</option>
                            <option value="delete">Delete (if no users)</option>
                        </select>
                        <button wire:click="bulkAction" class="btn btn-outline-primary" 
                                style="border-radius: 0 8px 8px 0;" @if(empty($selectedLevels) || !$bulkAction) disabled @endif>
                            Apply
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Levels Table -->
    <div class="card" style="border: none; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
        <div class="card-header bg-transparent border-0 p-4">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-semibold">Levels ({{ $levels->total() }})</h5>
                @if(count($selectedLevels) > 0)
                    <span class="badge bg-primary">{{ count($selectedLevels) }} selected</span>
                @endif
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background: #f8f9fa;">
                        <tr>
                            <th class="border-0 ps-4">
                                <input type="checkbox" class="form-check-input" 
                                       id="selectAllLevels"
                                       @if(count($selectedLevels) === $levels->count() && $levels->count() > 0) checked @endif
                                       onclick="toggleSelectAllLevels(this)">
                            </th>
                            <th class="border-0 fw-semibold" style="color: #6c757d;">
                                <button wire:click="sortBy('sort_order')" class="btn btn-sm btn-link text-decoration-none p-0" style="color: #6c757d;">
                                    Order @if($sortBy === 'sort_order') <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i> @endif
                                </button>
                            </th>
                            <th class="border-0 fw-semibold" style="color: #6c757d;">
                                <button wire:click="sortBy('name')" class="btn btn-sm btn-link text-decoration-none p-0" style="color: #6c757d;">
                                    Level @if($sortBy === 'name') <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i> @endif
                                </button>
                            </th>
                            <th class="border-0 fw-semibold" style="color: #6c757d;">
                                <button wire:click="sortBy('points_required')" class="btn btn-sm btn-link text-decoration-none p-0" style="color: #6c757d;">
                                    Points Required @if($sortBy === 'points_required') <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i> @endif
                                </button>
                            </th>
                            <th class="border-0 fw-semibold" style="color: #6c757d;">Users</th>
                            <th class="border-0 fw-semibold" style="color: #6c757d;">Status</th>
                            <th class="border-0 pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($levels as $level)
                            <tr style="border-bottom: 1px solid #f0f0f0;">
                                <td class="ps-4">
                                    <input type="checkbox" class="form-check-input" 
                                           wire:model="selectedLevels" 
                                           value="{{ $level->id }}">
                                </td>
                                <td>
                                    <span class="badge bg-secondary fs-6 px-3 py-2">{{ $level->sort_order }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3 d-flex align-items-center justify-content-center" 
                                             style="width: 40px; height: 40px; background: {{ $level->color }}15; border: 2px solid {{ $level->color }}; border-radius: 12px;">
                                            <i class="{{ $level->icon }}" style="color: {{ $level->color }}; font-size: 1.2rem;"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-dark">{{ $level->name }}</div>
                                            @if($level->description)
                                                <small class="text-muted">{{ Str::limit($level->description, 50) }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-semibold text-primary">{{ number_format($level->points_required) }}</div>
                                    <small class="text-muted">points</small>
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ $level->users_count }}</div>
                                    <small class="text-muted">users</small>
                                    @if($level->users_count > 0)
                                        <button class="btn btn-link btn-sm p-0 text-primary" wire:click="showLevelDetail({{ $level->id }})">
                                            <i class="fas fa-eye me-1"></i>View Users
                                        </button>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-{{ $level->is_active ? 'success' : 'danger' }}">
                                        <i class="fas fa-{{ $level->is_active ? 'check-circle' : 'times-circle' }} me-1"></i>
                                        {{ $level->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="pe-4">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                                type="button" data-bs-toggle="dropdown"
                                                data-bs-boundary="viewport">
                                            <i class="fas fa-cog"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" style="z-index: 1050;">
                                            <li><a class="dropdown-item" href="#" wire:click="showLevelDetail({{ $level->id }})">
                                                <i class="fas fa-eye me-2"></i>View Details
                                            </a></li>
                                            <li><a class="dropdown-item" href="#" wire:click="showEditLevel({{ $level->id }})">
                                                <i class="fas fa-edit me-2"></i>Edit Level
                                            </a></li>
                                            <li><a class="dropdown-item" href="#" wire:click="duplicateLevel({{ $level->id }})">
                                                <i class="fas fa-copy me-2"></i>Duplicate
                                            </a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item" href="#" wire:click="toggleLevelStatus({{ $level->id }})">
                                                <i class="fas fa-{{ $level->is_active ? 'pause' : 'play' }} me-2"></i>
                                                {{ $level->is_active ? 'Deactivate' : 'Activate' }}
                                            </a></li>
                                            @if($level->users_count === 0)
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger" href="#" 
                                                       wire:click="deleteLevel({{ $level->id }})"
                                                       onclick="return confirm('Are you sure you want to delete this level?')">
                                                    <i class="fas fa-trash me-2"></i>Delete Level
                                                </a></li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center p-5">
                                    <div class="text-muted">
                                        <i class="fas fa-layer-group fa-3x mb-3"></i>
                                        <h5>No levels found</h5>
                                        <p>Try adjusting your search criteria or create your first level</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($levels->hasPages())
                <div class="card-footer bg-transparent border-0 p-4">
                    {{ $levels->links() }}
                </div>
            @endif
        </div>
    </div>

    @include('livewire.admin.levels.partials.create-modal')
    @include('livewire.admin.levels.partials.edit-modal')
    @include('livewire.admin.levels.partials.detail-modal')
</div>

@push('styles')
<style>
    .dropdown-menu {
        z-index: 1050 !important;
    }
    
    .table-responsive {
        overflow-x: auto;
        overflow-y: visible;
    }
    
    .table-responsive .dropdown {
        position: static;
    }
    
    .table-responsive .dropdown-menu {
        position: absolute !important;
        z-index: 1050 !important;
    }

    /* Mobile optimizations for admin levels page */
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
        
        .card-body h4 {
            font-size: 1.2rem !important;
        }
        
        .card-body small {
            font-size: 0.75rem !important;
        }
        
        .card-body.p-3 {
            padding: 16px !important;
        }
        
        .card-body i.fa-2x {
            font-size: 1.5rem !important;
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
        
        /* Form switch mobile */
        .form-check.form-switch {
            margin-top: 8px !important;
        }
        
        .form-check-label {
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
        
        /* Level info mobile layout */
        .table .d-flex.align-items-center {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 8px;
        }
        
        .table .d-flex.align-items-center .me-3 {
            margin-right: 0 !important;
            margin-bottom: 8px !important;
        }
        
        /* Level icon mobile */
        .d-flex.align-items-center.justify-content-center {
            width: 35px !important;
            height: 35px !important;
        }
        
        .d-flex.align-items-center.justify-content-center i {
            font-size: 1rem !important;
        }
        
        /* Badge adjustments */
        .badge {
            font-size: 0.7rem !important;
            padding: 4px 8px !important;
        }
        
        .badge.fs-6 {
            font-size: 0.75rem !important;
        }
        
        /* Points and users column mobile */
        .fw-semibold.text-primary {
            font-size: 0.85rem !important;
        }
        
        .table small {
            font-size: 0.7rem !important;
        }
        
        /* View users button mobile */
        .btn.btn-link.btn-sm {
            font-size: 0.7rem !important;
            padding: 2px 0 !important;
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
        
        /* Card footer pagination mobile */
        .card-footer {
            padding: 12px !important;
        }
        
        /* Hide less important columns on mobile */
        .table th:nth-child(4),
        .table td:nth-child(4),
        .table th:nth-child(5),
        .table td:nth-child(5) {
            display: none;
        }
        
        /* Alert mobile */
        .alert {
            margin: 0 8px 16px 8px !important;
            font-size: 0.9rem !important;
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
        .table th:nth-child(3),
        .table td:nth-child(3) {
            display: none;
        }
        
        /* Level order badge smaller */
        .badge.bg-secondary.fs-6 {
            font-size: 0.7rem !important;
            padding: 3px 8px !important;
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
        
        /* Even more compact stats cards */
        .card-body h4 {
            font-size: 1.1rem !important;
        }
        
        .card-body small {
            font-size: 0.7rem !important;
        }
        
        .card-body.p-3 {
            padding: 12px !important;
        }
    }

    /* Extra small mobile screens */
    @media (max-width: 480px) {
        /* Hide sort order column on very small screens */
        .table th:nth-child(2),
        .table td:nth-child(2) {
            display: none;
        }
        
        .table {
            min-width: 600px;
        }
        
        /* More compact cards */
        .card-body {
            padding: 12px !important;
        }
        
        .card-body h4 {
            font-size: 1rem !important;
        }
        
        /* Level icon even smaller */
        .d-flex.align-items-center.justify-content-center {
            width: 30px !important;
            height: 30px !important;
        }
        
        .d-flex.align-items-center.justify-content-center i {
            font-size: 0.9rem !important;
        }
        
        /* Very small badges */
        .badge {
            font-size: 0.65rem !important;
            padding: 2px 6px !important;
        }
        
        /* Form elements smaller */
        .form-check-input {
            transform: scale(0.9);
        }
        
        .form-select,
        .form-control {
            font-size: 0.85rem !important;
        }
        
        /* Alert more compact */
        .alert {
            padding: 10px 12px !important;
        }
    }

    /* Level-specific mobile optimizations */
    @media (max-width: 768px) {
        /* Empty state mobile */
        .text-center.p-5 {
            padding: 40px 20px !important;
        }
        
        .text-center.p-5 .fa-3x {
            font-size: 2rem !important;
        }
        
        .text-center.p-5 h5 {
            font-size: 1.1rem !important;
        }
        
        /* Level name and description mobile */
        .fw-semibold.text-dark {
            font-size: 0.9rem !important;
        }
        
        .table .fw-semibold.text-dark + small {
            font-size: 0.75rem !important;
        }
        
        /* Better touch targets */
        .form-check-input {
            width: 18px;
            height: 18px;
        }
        
        .dropdown-toggle {
            min-width: 40px;
            min-height: 40px;
        }
        
        /* Points display mobile */
        .fw-semibold.text-primary {
            color: #0d6efd !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
function toggleSelectAllLevels(selectAllCheckbox) {
    const checkboxes = document.querySelectorAll('input[type="checkbox"][wire\\:model="selectedLevels"]');
    
    checkboxes.forEach(checkbox => {
        if (!checkbox.disabled) {
            checkbox.checked = selectAllCheckbox.checked;
            checkbox.dispatchEvent(new Event('change'));
        }
    });
}

document.addEventListener('livewire:init', () => {
    function updateSelectAllState() {
        const checkboxes = document.querySelectorAll('input[type="checkbox"][wire\\:model="selectedLevels"]:not([disabled])');
        const selectAllCheckbox = document.getElementById('selectAllLevels');
        
        if (checkboxes.length > 0 && selectAllCheckbox) {
            const checkedCount = Array.from(checkboxes).filter(cb => cb.checked).length;
            selectAllCheckbox.checked = checkedCount === checkboxes.length;
            selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < checkboxes.length;
        }
    }

    document.addEventListener('change', function(e) {
        if (e.target.matches('input[type="checkbox"][wire\\:model="selectedLevels"]')) {
            updateSelectAllState();
        }
    });

    Livewire.hook('morph.updated', () => {
        updateSelectAllState();
    });
});
</script>
@endpush