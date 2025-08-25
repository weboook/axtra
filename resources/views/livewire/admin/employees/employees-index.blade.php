<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1" style="color: #1a1a1a; font-weight: 700;">Employee Management</h1>
            <p class="text-muted mb-0">Manage staff members, roles, and permissions</p>
        </div>
        <button wire:click="showCreateEmployee" class="btn btn-primary d-flex align-items-center" 
                style="background: #c02425; border-color: #c02425; padding: 12px 24px; border-radius: 12px; font-weight: 600;">
            <i class="fas fa-plus me-2"></i>
            Add New Employee
        </button>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1 fw-bold">{{ $stats['total'] }}</h3>
                            <small class="opacity-75">Total Employees</small>
                        </div>
                        <div style="background: rgba(255,255,255,0.2); width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-users"></i>
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
                            <h3 class="mb-1 fw-bold">{{ $stats['positions'] }}</h3>
                            <small class="opacity-75">Positions</small>
                        </div>
                        <div style="background: rgba(255,255,255,0.2); width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-briefcase"></i>
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
                    <label class="form-label fw-semibold text-muted small">Search Employees</label>
                    <div class="input-group">
                        <span class="input-group-text border-0" style="background: #f8f9fa;"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" wire:model.live.debounce.300ms="search" class="form-control border-start-0" 
                               placeholder="Name, email, ID, or position..." style="background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 0 8px 8px 0;">
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold text-muted small">Position</label>
                    <select wire:model.live="positionFilter" class="form-select" style="border-radius: 8px;">
                        <option value="">All Positions</option>
                        @foreach($positions as $position)
                            <option value="{{ $position }}">{{ ucfirst($position) }}</option>
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
                                style="border-radius: 0 8px 8px 0;" @if(empty($selectedEmployees) || !$bulkAction) disabled @endif>
                            Apply
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Employees Table -->
    <div class="card" style="border: none; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
        <div class="card-header bg-transparent border-0 p-4">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-semibold">Employees ({{ $employees->total() + $adminUsers->count() }})</h5>
                @if(count($selectedEmployees) > 0)
                    <span class="badge bg-primary">{{ count($selectedEmployees) }} selected</span>
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
                                       id="selectAllEmployees"
                                       @if(count($selectedEmployees) === $employees->count() && $employees->count() > 0) checked @endif
                                       onclick="toggleSelectAllEmployees(this)">
                            </th>
                            <th class="border-0 fw-semibold" style="color: #6c757d;">
                                <button wire:click="sortBy('employee_id')" class="btn btn-sm btn-link text-decoration-none p-0" style="color: #6c757d;">
                                    Employee ID @if($sortBy === 'employee_id') <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i> @endif
                                </button>
                            </th>
                            <th class="border-0 fw-semibold" style="color: #6c757d;">
                                <button wire:click="sortBy('user_id')" class="btn btn-sm btn-link text-decoration-none p-0" style="color: #6c757d;">
                                    Employee @if($sortBy === 'user_id') <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i> @endif
                                </button>
                            </th>
                            <th class="border-0 fw-semibold" style="color: #6c757d;">
                                <button wire:click="sortBy('position')" class="btn btn-sm btn-link text-decoration-none p-0" style="color: #6c757d;">
                                    Position @if($sortBy === 'position') <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i> @endif
                                </button>
                            </th>
                            <th class="border-0 fw-semibold" style="color: #6c757d;">Status</th>
                            <th class="border-0 fw-semibold" style="color: #6c757d;">
                                <button wire:click="sortBy('hourly_rate')" class="btn btn-sm btn-link text-decoration-none p-0" style="color: #6c757d;">
                                    Rate @if($sortBy === 'hourly_rate') <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i> @endif
                                </button>
                            </th>
                            <th class="border-0 fw-semibold" style="color: #6c757d;">
                                <button wire:click="sortBy('hire_date')" class="btn btn-sm btn-link text-decoration-none p-0" style="color: #6c757d;">
                                    Hire Date @if($sortBy === 'hire_date') <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i> @endif
                                </button>
                            </th>
                            <th class="border-0 pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employees as $employee)
                            <tr style="border-bottom: 1px solid #f0f0f0;">
                                <td class="ps-4">
                                    <input type="checkbox" class="form-check-input" 
                                           wire:model="selectedEmployees" 
                                           value="{{ $employee->id }}">
                                </td>
                                <td>
                                    <span class="badge bg-dark">{{ $employee->employee_id }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <img src="{{ $employee->user->profile_photo_url }}" 
                                                 class="rounded-circle" 
                                                 width="40" height="40"
                                                 alt="{{ $employee->user->name }}"
                                                 style="object-fit: cover;">
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-dark">{{ $employee->user->name }}</div>
                                            <small class="text-muted">{{ $employee->user->email }}</small>
                                            @if($employee->user->phone)
                                                <br><small class="text-muted">{{ $employee->user->phone }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($employee->user->role === 'admin')
                                        <span class="badge" style="background: #c02425; color: white;">
                                            <i class="fas fa-crown me-1"></i>Administrator
                                        </span>
                                    @else
                                        <span class="badge" style="background: #17a2b8; color: white;">
                                            <i class="fas fa-briefcase me-1"></i>{{ ucfirst($employee->position) }}
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($employee->is_active)
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle me-1"></i>Active
                                        </span>
                                    @else
                                        <span class="badge bg-warning">
                                            <i class="fas fa-pause-circle me-1"></i>Inactive
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($employee->user->role === 'admin')
                                        <span class="text-muted">Admin</span>
                                    @elseif($employee->hourly_rate)
                                        <div class="fw-semibold text-success">CHF {{ number_format($employee->hourly_rate, 2) }}</div>
                                        <small class="text-muted">per hour</small>
                                    @else
                                        <span class="text-muted">Not set</span>
                                    @endif
                                </td>
                                <td>
                                    <div>{{ $employee->hire_date->format('M d, Y') }}</div>
                                    <small class="text-muted">{{ $employee->hire_date->diffForHumans() }}</small>
                                </td>
                                <td class="pe-4">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                                type="button" data-bs-toggle="dropdown"
                                                data-bs-boundary="viewport">
                                            <i class="fas fa-cog"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" style="z-index: 1050;">
                                            <li><a class="dropdown-item" href="#" wire:click="showEmployeeDetail({{ $employee->id }})">
                                                <i class="fas fa-eye me-2"></i>View Details
                                            </a></li>
                                            @if($employee->user->role !== 'admin')
                                                <li><a class="dropdown-item" href="#" wire:click="showEditEmployee({{ $employee->id }})">
                                                    <i class="fas fa-edit me-2"></i>Edit Employee
                                                </a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item" href="#" wire:click="toggleEmployeeStatus({{ $employee->id }})">
                                                    <i class="fas fa-{{ $employee->is_active ? 'pause' : 'play' }} me-2"></i>
                                                    {{ $employee->is_active ? 'Deactivate' : 'Activate' }}
                                                </a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger" href="#" 
                                                       wire:click="deleteEmployee({{ $employee->id }})"
                                                       onclick="return confirm('Are you sure you want to delete this employee? This will revert their user role to customer.')">
                                                    <i class="fas fa-trash me-2"></i>Delete Employee
                                                </a></li>
                                            @else
                                                <li><span class="dropdown-item text-muted">
                                                    <i class="fas fa-info-circle me-2"></i>Admin users cannot be modified
                                                </span></li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                        @endforelse

                        {{-- Show admin users who don't have employee records --}}
                        @foreach($adminUsers as $admin)
                            <tr style="border-bottom: 1px solid #f0f0f0;">
                                <td class="ps-4">
                                    <input type="checkbox" class="form-check-input" disabled>
                                </td>
                                <td>
                                    <span class="badge bg-warning">ADMIN</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <img src="{{ $admin->profile_photo_url }}" 
                                                 class="rounded-circle" 
                                                 width="40" height="40"
                                                 alt="{{ $admin->name }}"
                                                 style="object-fit: cover;">
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-dark">{{ $admin->name }}</div>
                                            <small class="text-muted">{{ $admin->email }}</small>
                                            @if($admin->phone)
                                                <br><small class="text-muted">{{ $admin->phone }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge" style="background: #c02425; color: white;">
                                        <i class="fas fa-crown me-1"></i>Administrator
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i>Active
                                    </span>
                                </td>
                                <td>
                                    <span class="text-muted">Admin</span>
                                </td>
                                <td>
                                    <div>{{ $admin->created_at->format('M d, Y') }}</div>
                                    <small class="text-muted">{{ $admin->created_at->diffForHumans() }}</small>
                                </td>
                                <td class="pe-4">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                                type="button" data-bs-toggle="dropdown"
                                                data-bs-boundary="viewport">
                                            <i class="fas fa-cog"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" style="z-index: 1050;">
                                            <li><span class="dropdown-item text-muted">
                                                <i class="fas fa-info-circle me-2"></i>Admin users cannot be modified
                                            </span></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        @if($employees->isEmpty() && $adminUsers->isEmpty())
                            <tr>
                                <td colspan="8" class="text-center p-5">
                                    <div class="text-muted">
                                        <i class="fas fa-user-tie fa-3x mb-3"></i>
                                        <h5>No employees found</h5>
                                        <p>Try adjusting your search criteria or filters</p>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            
            @if($employees->hasPages())
                <div class="card-footer bg-transparent border-0 p-4">
                    {{ $employees->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Create Employee Modal -->
    @if($showCreateModal)
        @livewire('admin.employees.employee-create')
    @endif

    <!-- Edit Employee Modal -->
    @if($showEditModal && $selectedEmployee)
        @livewire('admin.employees.employee-edit', ['employeeId' => $selectedEmployee->id])
    @endif

    <!-- Employee Detail Modal -->
    @if($showDetailModal && $selectedEmployee)
        <div class="modal fade show" style="display: block; background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" style="border-radius: 16px;">
                    <div class="modal-header border-0 p-4">
                        <h5 class="modal-title fw-bold">Employee Details</h5>
                        <button type="button" class="btn-close" wire:click="closeModals"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row">
                            <div class="col-md-4 text-center mb-4">
                                <img src="{{ $selectedEmployee->user->profile_photo_url }}" 
                                     class="rounded-circle mb-3" 
                                     width="120" height="120"
                                     style="object-fit: cover;">
                                <h5>{{ $selectedEmployee->user->name }}</h5>
                                <span class="badge" style="background: #17a2b8; color: white;">
                                    {{ ucfirst($selectedEmployee->position) }}
                                </span>
                                <div class="mt-2">
                                    <span class="badge {{ $selectedEmployee->is_active ? 'bg-success' : 'bg-warning' }}">
                                        {{ $selectedEmployee->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row g-3">
                                    <div class="col-6">
                                        <label class="text-muted small">Employee ID</label>
                                        <div class="fw-semibold">{{ $selectedEmployee->employee_id }}</div>
                                    </div>
                                    <div class="col-6">
                                        <label class="text-muted small">Email</label>
                                        <div class="fw-semibold">{{ $selectedEmployee->user->email }}</div>
                                    </div>
                                    <div class="col-6">
                                        <label class="text-muted small">Phone</label>
                                        <div class="fw-semibold">{{ $selectedEmployee->user->phone ?? 'N/A' }}</div>
                                    </div>
                                    <div class="col-6">
                                        <label class="text-muted small">Hire Date</label>
                                        <div class="fw-semibold">{{ $selectedEmployee->hire_date->format('M d, Y') }}</div>
                                    </div>
                                    <div class="col-6">
                                        <label class="text-muted small">Hourly Rate</label>
                                        <div class="fw-semibold">{{ $selectedEmployee->hourly_rate ? 'CHF ' . number_format($selectedEmployee->hourly_rate, 2) : 'Not set' }}</div>
                                    </div>
                                    <div class="col-6">
                                        <label class="text-muted small">Employment Duration</label>
                                        <div class="fw-semibold">{{ $selectedEmployee->hire_date->diffForHumans(null, true) }}</div>
                                    </div>
                                    @if($selectedEmployee->permissions && count($selectedEmployee->permissions) > 0)
                                        <div class="col-12">
                                            <label class="text-muted small">Permissions</label>
                                            <div class="mt-2">
                                                @foreach($selectedEmployee->permissions as $permission)
                                                    <span class="badge bg-primary me-1 mb-1">{{ ucfirst(str_replace('_', ' ', $permission)) }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                    @if($selectedEmployee->notes)
                                        <div class="col-12">
                                            <label class="text-muted small">Notes</label>
                                            <div class="fw-semibold">{{ $selectedEmployee->notes }}</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
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

    /* Mobile optimizations for admin employees page */
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
        
        /* Employee info mobile layout */
        .table .d-flex.align-items-center {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 8px;
        }
        
        .table .d-flex.align-items-center .me-3 {
            margin-right: 0 !important;
            margin-bottom: 8px !important;
        }
        
        .table .d-flex.align-items-center img {
            width: 35px !important;
            height: 35px !important;
        }
        
        /* Badge adjustments */
        .badge {
            font-size: 0.7rem !important;
            padding: 4px 8px !important;
        }
        
        .badge.bg-dark {
            font-size: 0.65rem !important;
        }
        
        .badge.bg-warning {
            font-size: 0.65rem !important;
        }
        
        /* Position badges mobile */
        .badge i {
            font-size: 0.65rem !important;
        }
        
        /* Rate column mobile */
        .fw-semibold.text-success {
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
        
        /* Employee detail modal mobile */
        .modal-dialog.modal-lg {
            max-width: calc(100vw - 20px) !important;
        }
        
        .modal-body .row {
            flex-direction: column !important;
        }
        
        .modal-body .col-md-4,
        .modal-body .col-md-8 {
            flex: none !important;
            max-width: 100% !important;
        }
        
        .modal-body .col-md-4 {
            margin-bottom: 20px;
        }
        
        .modal-body .col-6 {
            flex: 0 0 100% !important;
            max-width: 100% !important;
            margin-bottom: 15px;
        }
        
        /* Card footer pagination mobile */
        .card-footer {
            padding: 12px !important;
        }
        
        /* Hide less important columns on mobile */
        .table th:nth-child(6),
        .table td:nth-child(6),
        .table th:nth-child(7),
        .table td:nth-child(7) {
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
        .table th:nth-child(5),
        .table td:nth-child(5) {
            display: none;
        }
        
        /* Employee ID badge smaller */
        .badge.bg-dark,
        .badge.bg-warning {
            font-size: 0.6rem !important;
            padding: 2px 6px !important;
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
        
        /* Permissions badges smaller */
        .badge.bg-primary {
            font-size: 0.65rem !important;
            padding: 3px 6px !important;
            margin: 1px !important;
        }
    }

    /* Extra small mobile screens */
    @media (max-width: 480px) {
        /* Hide employee ID column on very small screens */
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
        
        .card-body h3 {
            font-size: 1.1rem !important;
        }
        
        /* Smaller employee images */
        .table .d-flex.align-items-center img {
            width: 30px !important;
            height: 30px !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function toggleSelectAllEmployees(selectAllCheckbox) {
        const checkboxes = document.querySelectorAll('input[type="checkbox"][wire\\:model="selectedEmployees"]');
        
        checkboxes.forEach(checkbox => {
            if (!checkbox.disabled) {
                checkbox.checked = selectAllCheckbox.checked;
                checkbox.dispatchEvent(new Event('change'));
            }
        });
    }

    // Update select all checkbox based on individual selections
    document.addEventListener('livewire:init', () => {
        // Check if all checkboxes are selected
        function updateSelectAllState() {
            const checkboxes = document.querySelectorAll('input[type="checkbox"][wire\\:model="selectedEmployees"]:not([disabled])');
            const selectAllCheckbox = document.getElementById('selectAllEmployees');
            
            if (checkboxes.length > 0 && selectAllCheckbox) {
                const checkedCount = Array.from(checkboxes).filter(cb => cb.checked).length;
                selectAllCheckbox.checked = checkedCount === checkboxes.length;
                selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < checkboxes.length;
            }
        }

        // Listen for individual checkbox changes
        document.addEventListener('change', function(e) {
            if (e.target.matches('input[type="checkbox"][wire\\:model="selectedEmployees"]')) {
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