<div class="container-fluid p-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1" style="color: #1a1a1a; font-weight: 700;">Lane Management</h1>
            <p class="text-muted mb-0">Manage lanes, track maintenance, and view history</p>
        </div>
        <button wire:click="showCreateLane" class="btn btn-primary d-flex align-items-center" 
                style="background: #c02425; border-color: #c02425; padding: 12px 24px; border-radius: 12px; font-weight: 600;">
            <i class="fas fa-plus me-2"></i>
            Add New Lane
        </button>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-2">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1 fw-bold">{{ $stats['total'] }}</h4>
                            <small class="opacity-75">Total Lanes</small>
                        </div>
                        <i class="fas fa-road fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                <div class="card-body text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1 fw-bold">{{ $stats['operational'] }}</h4>
                            <small class="opacity-75">Operational</small>
                        </div>
                        <i class="fas fa-check-circle fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);">
                <div class="card-body text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1 fw-bold">{{ $stats['maintenance'] }}</h4>
                            <small class="opacity-75">Maintenance</small>
                        </div>
                        <i class="fas fa-tools fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);">
                <div class="card-body text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1 fw-bold">{{ $stats['damaged'] }}</h4>
                            <small class="opacity-75">Damaged</small>
                        </div>
                        <i class="fas fa-exclamation-triangle fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);">
                <div class="card-body text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1 fw-bold">{{ $stats['active'] }}</h4>
                            <small class="opacity-75">Active</small>
                        </div>
                        <i class="fas fa-power-off fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);">
                <div class="card-body text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1 fw-bold">{{ $stats['inactive'] }}</h4>
                            <small class="opacity-75">Inactive</small>
                        </div>
                        <i class="fas fa-pause-circle fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="card mb-4" style="border: none; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-semibold text-muted small">Search Lanes</label>
                    <div class="input-group">
                        <span class="input-group-text border-0" style="background: #f8f9fa;"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" wire:model.live.debounce.300ms="search" class="form-control border-start-0" 
                               placeholder="Lane name or description..." style="background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 0 8px 8px 0;">
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold text-muted small">Status</label>
                    <select wire:model.live="statusFilter" class="form-select" style="border-radius: 8px;">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold text-muted small">Maintenance</label>
                    <select wire:model.live="maintenanceFilter" class="form-select" style="border-radius: 8px;">
                        <option value="">All</option>
                        <option value="operational">Operational</option>
                        <option value="maintenance">Maintenance</option>
                        <option value="damaged">Damaged</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold text-muted small">Per Page</label>
                    <select wire:model.live="perPage" class="form-select" style="border-radius: 8px;">
                        <option value="12">12</option>
                        <option value="24">24</option>
                        <option value="48">48</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold text-muted small">Bulk Actions</label>
                    <div class="input-group">
                        <select wire:model="bulkAction" class="form-select" style="border-radius: 8px 0 0 8px;">
                            <option value="">Choose action...</option>
                            <option value="activate">Activate</option>
                            <option value="deactivate">Deactivate</option>
                            <option value="maintenance">Set Maintenance</option>
                            <option value="operational">Set Operational</option>
                        </select>
                        <button wire:click="bulkAction" class="btn btn-outline-primary" 
                                style="border-radius: 0 8px 8px 0;" @if(empty($selectedLanes) || !$bulkAction) disabled @endif>
                            Apply
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lanes Grid -->
    <div class="row">
        @forelse($lanes as $lane)
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                <div class="card h-100" style="border: none; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                    <div class="card-header bg-transparent border-0 p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model="selectedLanes" value="{{ $lane->id }}">
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                        type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-cog"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#" wire:click="showLaneHistory({{ $lane->id }})">
                                        <i class="fas fa-history me-2"></i>View History
                                    </a></li>
                                    <li><a class="dropdown-item" href="#" wire:click="showAddHistory({{ $lane->id }})">
                                        <i class="fas fa-plus me-2"></i>Add History Entry
                                    </a></li>
                                    <li><a class="dropdown-item" href="#" wire:click="showEditLane({{ $lane->id }})">
                                        <i class="fas fa-edit me-2"></i>Edit Lane
                                    </a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li class="dropdown-header">Status</li>
                                    <li><a class="dropdown-item" href="#" wire:click="updateMaintenanceStatus({{ $lane->id }}, 'operational')">
                                        <i class="fas fa-check-circle me-2 text-success"></i>Operational
                                    </a></li>
                                    <li><a class="dropdown-item" href="#" wire:click="updateMaintenanceStatus({{ $lane->id }}, 'maintenance')">
                                        <i class="fas fa-tools me-2 text-warning"></i>Maintenance
                                    </a></li>
                                    <li><a class="dropdown-item" href="#" wire:click="updateMaintenanceStatus({{ $lane->id }}, 'damaged')">
                                        <i class="fas fa-exclamation-triangle me-2 text-danger"></i>Damaged
                                    </a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="#" 
                                           wire:click="deleteLane({{ $lane->id }})"
                                           onclick="return confirm('Are you sure you want to delete this lane?')">
                                        <i class="fas fa-trash me-2"></i>Delete Lane
                                    </a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body p-3">
                        <!-- Lane Header -->
                        <div class="text-center mb-3">
                            <h5 class="fw-bold mb-1">{{ $lane->name }}</h5>
                            @if($lane->description)
                                <small class="text-muted">{{ $lane->description }}</small>
                            @endif
                        </div>

                        <!-- Status Badges -->
                        <div class="text-center mb-3">
                            <span class="badge bg-{{ $lane->is_active ? 'success' : 'secondary' }} me-2">
                                <i class="fas fa-power-off me-1"></i>{{ $lane->is_active ? 'Active' : 'Inactive' }}
                            </span>
                            <span class="badge bg-{{ $lane->status_color }}">
                                <i class="{{ $lane->status_icon }} me-1"></i>{{ ucfirst($lane->maintenance_status) }}
                            </span>
                        </div>

                        <!-- Quick Stats -->
                        <div class="row g-2 mb-3">
                            <div class="col-4">
                                <div class="text-center p-2 rounded" style="background: rgba(220, 53, 69, 0.1);">
                                    <div class="fw-bold text-danger">{{ $lane->axe_breaks_count }}</div>
                                    <small class="text-muted">Axe Breaks</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="text-center p-2 rounded" style="background: rgba(255, 193, 7, 0.1);">
                                    <div class="fw-bold text-warning">{{ $lane->block_replacements_count }}</div>
                                    <small class="text-muted">Block Replace</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="text-center p-2 rounded" style="background: rgba(13, 202, 240, 0.1);">
                                    <div class="fw-bold text-info">{{ $lane->history_count }}</div>
                                    <small class="text-muted">Total Events</small>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-primary btn-sm" wire:click="showLaneHistory({{ $lane->id }})">
                                <i class="fas fa-history me-1"></i>View History
                            </button>
                        </div>
                    </div>

                    @if($lane->last_maintenance)
                        <div class="card-footer bg-transparent border-0 p-3 pt-0">
                            <small class="text-muted">
                                <i class="fas fa-calendar-alt me-1"></i>
                                Last maintenance: {{ $lane->last_maintenance->format('M j, Y') }}
                            </small>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center p-5">
                    <i class="fas fa-road fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No lanes found</h5>
                    <p class="text-muted">Try adjusting your search criteria or add a new lane</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($lanes->hasPages())
        <div class="mt-4">
            {{ $lanes->links() }}
        </div>
    @endif

    <!-- History Modal -->
    @if($showHistoryModal && $selectedLane)
        <div class="modal fade show" style="display: block; background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-xl">
                <div class="modal-content" style="border-radius: 16px;">
                    <div class="modal-header border-0 p-4">
                        <h5 class="modal-title fw-bold">
                            <i class="fas fa-history me-2"></i>{{ $selectedLane->name }} - History & Statistics
                        </h5>
                        <button type="button" class="btn-close" wire:click="closeModals"></button>
                    </div>
                    <div class="modal-body p-4">
                        @include('livewire.admin.lanes.partials.lane-history')
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Create/Edit Modals would be included here -->
    @if($showCreateModal)
        @livewire('admin.lanes.lane-create')
    @endif

    @if($showEditModal && $selectedLane)
        @livewire('admin.lanes.lane-edit', ['laneId' => $selectedLane->id])
    @endif

    @if($showAddHistoryModal && $selectedLane)
        @livewire('admin.lanes.lane-history-create', ['laneId' => $selectedLane->id])
    @endif
</div>

@push('styles')
<style>
    .dropdown-menu {
        z-index: 1050 !important;
    }
    
    .card:hover {
        transform: translateY(-2px);
        transition: all 0.2s ease;
        box-shadow: 0 6px 25px rgba(0,0,0,0.15) !important;
    }
</style>
@endpush
