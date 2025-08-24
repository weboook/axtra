<!-- Services Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-1 fw-bold">{{ $stats['total'] }}</h3>
                        <small class="opacity-75">Total Services</small>
                    </div>
                    <div style="background: rgba(255,255,255,0.2); width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-bullseye"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-1 fw-bold">{{ $stats['active'] }}</h3>
                        <small class="opacity-75">Active</small>
                    </div>
                    <div style="background: rgba(255,255,255,0.2); width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-1 fw-bold">{{ $stats['inactive'] }}</h3>
                        <small class="opacity-75">Inactive</small>
                    </div>
                    <div style="background: rgba(255,255,255,0.2); width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-pause-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-1 fw-bold">{{ $stats['categories'] }}</h3>
                        <small class="opacity-75">Categories</small>
                    </div>
                    <div style="background: rgba(255,255,255,0.2); width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-th-large"></i>
                    </div>
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
                <label class="form-label fw-semibold text-muted small">Search Services</label>
                <div class="input-group">
                    <span class="input-group-text border-0" style="background: #f8f9fa;"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" wire:model.live.debounce.300ms="search" class="form-control border-start-0" 
                           placeholder="Service name or description..." style="background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 0 8px 8px 0;">
                </div>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold text-muted small">Category</label>
                <select wire:model.live="categoryFilter" class="form-select" style="border-radius: 8px;">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}">{{ ucwords(str_replace('_', ' ', $category)) }}</option>
                    @endforeach
                </select>
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
                <label class="form-label fw-semibold text-muted small">Per Page</label>
                <select wire:model.live="perPage" class="form-select" style="border-radius: 8px;">
                    <option value="15">15</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold text-muted small">Bulk Actions</label>
                <div class="input-group">
                    <select wire:model="bulkAction" class="form-select" style="border-radius: 8px 0 0 8px;">
                        <option value="">Choose action...</option>
                        <option value="activate">Activate</option>
                        <option value="deactivate">Deactivate</option>
                        <option value="delete">Delete</option>
                    </select>
                    <button wire:click="bulkAction" class="btn btn-outline-primary" 
                            style="border-radius: 0 8px 8px 0;" @if(empty($selectedItems) || !$bulkAction) disabled @endif>
                        Apply
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Services Table -->
<div class="card" style="border: none; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
    <div class="card-header bg-transparent border-0 p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold">Services ({{ $services->total() }})</h5>
            @if(count($selectedItems) > 0)
                <span class="badge bg-primary">{{ count($selectedItems) }} selected</span>
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
                                   id="selectAllItems"
                                   @if(count($selectedItems) === $services->count() && $services->count() > 0) checked @endif
                                   onclick="toggleSelectAllItems(this)">
                        </th>
                        <th class="border-0 fw-semibold" style="color: #6c757d;">
                            <button wire:click="sortBy('name')" class="btn btn-sm btn-link text-decoration-none p-0" style="color: #6c757d;">
                                Service Name @if($sortBy === 'name') <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i> @endif
                            </button>
                        </th>
                        <th class="border-0 fw-semibold" style="color: #6c757d;">
                            <button wire:click="sortBy('category')" class="btn btn-sm btn-link text-decoration-none p-0" style="color: #6c757d;">
                                Category @if($sortBy === 'category') <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i> @endif
                            </button>
                        </th>
                        <th class="border-0 fw-semibold" style="color: #6c757d;">Players</th>
                        <th class="border-0 fw-semibold" style="color: #6c757d;">
                            <button wire:click="sortBy('duration_hours')" class="btn btn-sm btn-link text-decoration-none p-0" style="color: #6c757d;">
                                Duration @if($sortBy === 'duration_hours') <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i> @endif
                            </button>
                        </th>
                        <th class="border-0 fw-semibold" style="color: #6c757d;">
                            <button wire:click="sortBy('price')" class="btn btn-sm btn-link text-decoration-none p-0" style="color: #6c757d;">
                                Price @if($sortBy === 'price') <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i> @endif
                            </button>
                        </th>
                        <th class="border-0 fw-semibold" style="color: #6c757d;">Status</th>
                        <th class="border-0 pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                        <tr style="border-bottom: 1px solid #f0f0f0;">
                            <td class="ps-4">
                                <input type="checkbox" class="form-check-input" 
                                       wire:model="selectedItems" 
                                       value="{{ $service->id }}">
                            </td>
                            <td>
                                <div>
                                    <div class="fw-semibold text-dark">{{ $service->name }}</div>
                                    <small class="text-muted">{{ Str::limit($service->description, 60) }}</small>
                                </div>
                            </td>
                            <td>
                                <span class="badge" style="background: #c02425; color: white;">
                                    {{ $service->category_display }}
                                </span>
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $service->min_players }}-{{ $service->max_players }}</div>
                                <small class="text-muted">players</small>
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $service->duration_hours }}h</div>
                                <small class="text-muted">duration</small>
                            </td>
                            <td>
                                <div class="fw-semibold text-success">CHF {{ number_format($service->price, 2) }}</div>
                                <small class="text-muted">per person</small>
                            </td>
                            <td>
                                @if($service->is_active)
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i>Active
                                    </span>
                                @else
                                    <span class="badge bg-warning">
                                        <i class="fas fa-pause-circle me-1"></i>Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="pe-4">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                            type="button" data-bs-toggle="dropdown"
                                            data-bs-boundary="viewport">
                                        <i class="fas fa-cog"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" style="z-index: 1050;">
                                        <li><a class="dropdown-item" href="#" wire:click="showItemDetail({{ $service->id }})">
                                            <i class="fas fa-eye me-2"></i>View Details
                                        </a></li>
                                        <li><a class="dropdown-item" href="#" wire:click="showEditItem({{ $service->id }})">
                                            <i class="fas fa-edit me-2"></i>Edit Service
                                        </a></li>
                                        <li><a class="dropdown-item" href="#" wire:click="duplicateItem({{ $service->id }})">
                                            <i class="fas fa-copy me-2"></i>Duplicate
                                        </a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="#" wire:click="toggleItemStatus({{ $service->id }})">
                                            <i class="fas fa-{{ $service->is_active ? 'pause' : 'play' }} me-2"></i>
                                            {{ $service->is_active ? 'Deactivate' : 'Activate' }}
                                        </a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#" 
                                               wire:click="deleteItem({{ $service->id }})"
                                               onclick="return confirm('Are you sure you want to delete this service? This action cannot be undone.')">
                                            <i class="fas fa-trash me-2"></i>Delete Service
                                        </a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center p-5">
                                <div class="text-muted">
                                    <i class="fas fa-bullseye fa-3x mb-3"></i>
                                    <h5>No services found</h5>
                                    <p>Try adjusting your search criteria or filters</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($services->hasPages())
            <div class="card-footer bg-transparent border-0 p-4">
                {{ $services->links() }}
            </div>
        @endif
    </div>
</div>