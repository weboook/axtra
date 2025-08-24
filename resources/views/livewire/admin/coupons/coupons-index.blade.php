<div class="container-fluid p-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1" style="color: #1a1a1a; font-weight: 700;">Coupon Management</h1>
            <p class="text-muted mb-0">Create and manage discount coupons and promotional codes</p>
        </div>
        <button wire:click="showCreateCoupon" class="btn btn-primary d-flex align-items-center" 
                style="background: #c02425; border-color: #c02425; padding: 12px 24px; border-radius: 12px; font-weight: 600;">
            <i class="fas fa-plus me-2"></i>
            Create New Coupon
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
                            <small class="opacity-75">Total Coupons</small>
                        </div>
                        <i class="fas fa-tags fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                <div class="card-body text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1 fw-bold">{{ $stats['active'] }}</h4>
                            <small class="opacity-75">Active</small>
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
                            <h4 class="mb-1 fw-bold">{{ $stats['expired'] }}</h4>
                            <small class="opacity-75">Expired</small>
                        </div>
                        <i class="fas fa-clock fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);">
                <div class="card-body text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1 fw-bold">{{ $stats['upcoming'] }}</h4>
                            <small class="opacity-75">Upcoming</small>
                        </div>
                        <i class="fas fa-calendar fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #e83e8c 0%, #d63384 100%);">
                <div class="card-body text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1 fw-bold">{{ $stats['total_usage'] }}</h4>
                            <small class="opacity-75">Total Uses</small>
                        </div>
                        <i class="fas fa-chart-line fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #6f42c1 0%, #9c5ade 100%);">
                <div class="card-body text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1 fw-bold">CHF {{ number_format($stats['total_savings'], 0) }}</h4>
                            <small class="opacity-75">Total Savings</small>
                        </div>
                        <i class="fas fa-piggy-bank fa-2x opacity-50"></i>
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
                    <label class="form-label fw-semibold text-muted small">Search Coupons</label>
                    <div class="input-group">
                        <span class="input-group-text border-0" style="background: #f8f9fa;"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" wire:model.live.debounce.300ms="search" class="form-control border-start-0" 
                               placeholder="Code, name, or description..." style="background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 0 8px 8px 0;">
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold text-muted small">Status</label>
                    <select wire:model.live="statusFilter" class="form-select" style="border-radius: 8px;">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="expired">Expired</option>
                        <option value="upcoming">Upcoming</option>
                        <option value="inactive">Inactive</option>
                        <option value="exhausted">Exhausted</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold text-muted small">Type</label>
                    <select wire:model.live="typeFilter" class="form-select" style="border-radius: 8px;">
                        <option value="">All Types</option>
                        <option value="percentage">Percentage</option>
                        <option value="fixed">Fixed Amount</option>
                        <option value="buy_x_get_y">Buy X Get Y</option>
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
                <div class="col-md-3">
                    <label class="form-label fw-semibold text-muted small">Bulk Actions</label>
                    <div class="input-group">
                        <select wire:model="bulkAction" class="form-select" style="border-radius: 8px 0 0 8px;">
                            <option value="">Choose action...</option>
                            <option value="activate">Activate</option>
                            <option value="deactivate">Deactivate</option>
                            <option value="extend">Extend 30 Days</option>
                            <option value="delete">Delete</option>
                        </select>
                        <button wire:click="bulkAction" class="btn btn-outline-primary" 
                                style="border-radius: 0 8px 8px 0;" @if(empty($selectedCoupons) || !$bulkAction) disabled @endif>
                            Apply
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Coupons Table -->
    <div class="card" style="border: none; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
        <div class="card-header bg-transparent border-0 p-4">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-semibold">Coupons ({{ $coupons->total() }})</h5>
                @if(count($selectedCoupons) > 0)
                    <span class="badge bg-primary">{{ count($selectedCoupons) }} selected</span>
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
                                       id="selectAllCoupons"
                                       @if(count($selectedCoupons) === $coupons->count() && $coupons->count() > 0) checked @endif
                                       onclick="toggleSelectAllCoupons(this)">
                            </th>
                            <th class="border-0 fw-semibold" style="color: #6c757d;">
                                <button wire:click="sortBy('code')" class="btn btn-sm btn-link text-decoration-none p-0" style="color: #6c757d;">
                                    Code @if($sortBy === 'code') <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i> @endif
                                </button>
                            </th>
                            <th class="border-0 fw-semibold" style="color: #6c757d;">
                                <button wire:click="sortBy('name')" class="btn btn-sm btn-link text-decoration-none p-0" style="color: #6c757d;">
                                    Name @if($sortBy === 'name') <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i> @endif
                                </button>
                            </th>
                            <th class="border-0 fw-semibold" style="color: #6c757d;">Type & Value</th>
                            <th class="border-0 fw-semibold" style="color: #6c757d;">
                                <button wire:click="sortBy('valid_until')" class="btn btn-sm btn-link text-decoration-none p-0" style="color: #6c757d;">
                                    Validity @if($sortBy === 'valid_until') <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i> @endif
                                </button>
                            </th>
                            <th class="border-0 fw-semibold" style="color: #6c757d;">Usage</th>
                            <th class="border-0 fw-semibold" style="color: #6c757d;">Status</th>
                            <th class="border-0 pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($coupons as $coupon)
                            <tr style="border-bottom: 1px solid #f0f0f0;">
                                <td class="ps-4">
                                    <input type="checkbox" class="form-check-input" 
                                           wire:model="selectedCoupons" 
                                           value="{{ $coupon->id }}">
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3" style="background: rgba(192, 36, 37, 0.1); padding: 8px 12px; border-radius: 8px; border: 1px solid rgba(192, 36, 37, 0.2);">
                                            <code style="color: #c02425; font-weight: bold; font-size: 0.9rem;">{{ $coupon->code }}</code>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <div class="fw-semibold text-dark">{{ $coupon->name }}</div>
                                        @if($coupon->description)
                                            <small class="text-muted">{{ Str::limit($coupon->description, 50) }}</small>
                                        @endif
                                        @if($coupon->creator)
                                            <div class="small text-muted mt-1">
                                                <i class="fas fa-user fa-xs me-1"></i>{{ $coupon->creator->name }}
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info mb-1">{{ $coupon->type_display }}</span><br>
                                    <span class="fw-bold text-success">{{ $coupon->value_display }}</span>
                                    @if($coupon->minimum_amount)
                                        <div class="small text-muted">Min: CHF {{ number_format($coupon->minimum_amount, 2) }}</div>
                                    @endif
                                </td>
                                <td>
                                    <div class="small">
                                        <strong>From:</strong> {{ $coupon->valid_from->format('M j, Y') }}<br>
                                        <strong>Until:</strong> {{ $coupon->valid_until->format('M j, Y') }}
                                        @if($coupon->status === 'active' && $coupon->days_until_expiry <= 7)
                                            <div class="badge bg-warning text-dark mt-1">
                                                <i class="fas fa-clock me-1"></i>{{ $coupon->days_until_expiry }} days left
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ $coupon->used_count }}</div>
                                    <div class="small text-muted">
                                        of {{ $coupon->remaining_uses }}
                                    </div>
                                    @if($coupon->usages_count > 0)
                                        <button class="btn btn-link btn-sm p-0 text-primary" wire:click="showCouponUsage({{ $coupon->id }})">
                                            <i class="fas fa-chart-bar me-1"></i>View Usage
                                        </button>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-{{ $coupon->status_color }}">
                                        <i class="fas fa-{{ match($coupon->status) {
                                            'active' => 'check-circle',
                                            'expired' => 'clock',
                                            'upcoming' => 'calendar',
                                            'exhausted' => 'ban',
                                            'inactive' => 'times-circle',
                                            default => 'question-circle'
                                        } }} me-1"></i>
                                        {{ ucfirst($coupon->status) }}
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
                                            <li><a class="dropdown-item" href="#" wire:click="showCouponDetail({{ $coupon->id }})">
                                                <i class="fas fa-eye me-2"></i>View Details
                                            </a></li>
                                            <li><a class="dropdown-item" href="#" wire:click="showEditCoupon({{ $coupon->id }})">
                                                <i class="fas fa-edit me-2"></i>Edit Coupon
                                            </a></li>
                                            <li><a class="dropdown-item" href="#" wire:click="duplicateCoupon({{ $coupon->id }})">
                                                <i class="fas fa-copy me-2"></i>Duplicate
                                            </a></li>
                                            @if($coupon->status !== 'expired')
                                                <li><a class="dropdown-item" href="#" wire:click="extendCoupon({{ $coupon->id }}, 30)">
                                                    <i class="fas fa-calendar-plus me-2"></i>Extend 30 Days
                                                </a></li>
                                            @endif
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item" href="#" wire:click="toggleCouponStatus({{ $coupon->id }})">
                                                <i class="fas fa-{{ $coupon->is_active ? 'pause' : 'play' }} me-2"></i>
                                                {{ $coupon->is_active ? 'Deactivate' : 'Activate' }}
                                            </a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item text-danger" href="#" 
                                                   wire:click="deleteCoupon({{ $coupon->id }})"
                                                   onclick="return confirm('Are you sure you want to delete this coupon?')">
                                                <i class="fas fa-trash me-2"></i>Delete Coupon
                                            </a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center p-5">
                                    <div class="text-muted">
                                        <i class="fas fa-tags fa-3x mb-3"></i>
                                        <h5>No coupons found</h5>
                                        <p>Try adjusting your search criteria or create your first coupon</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($coupons->hasPages())
                <div class="card-footer bg-transparent border-0 p-4">
                    {{ $coupons->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Recent Usage Activity -->
    @if($recentUsage->count() > 0)
        <div class="card mt-4" style="border: none; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
            <div class="card-header bg-transparent border-0 p-4">
                <h5 class="mb-0 fw-semibold">
                    <i class="fas fa-chart-line me-2"></i>Recent Coupon Usage
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead style="background: #f8f9fa;">
                            <tr>
                                <th class="border-0 ps-4">Used At</th>
                                <th class="border-0">Coupon</th>
                                <th class="border-0">User</th>
                                <th class="border-0">Discount</th>
                                <th class="border-0 pe-4">Booking</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentUsage as $usage)
                                <tr style="border-bottom: 1px solid #f0f0f0;">
                                    <td class="ps-4">
                                        <small>{{ $usage->used_at->format('M j, Y H:i') }}</small>
                                    </td>
                                    <td>
                                        <code style="background: rgba(192, 36, 37, 0.1); color: #c02425; padding: 2px 6px; border-radius: 4px;">
                                            {{ $usage->coupon->code }}
                                        </code>
                                    </td>
                                    <td>
                                        <small>{{ $usage->user->name ?? 'Guest' }}</small>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-success">CHF {{ number_format($usage->discount_amount, 2) }}</span>
                                    </td>
                                    <td class="pe-4">
                                        @if($usage->booking)
                                            <small>Booking #{{ $usage->booking->id }}</small>
                                        @else
                                            <small class="text-muted">-</small>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <!-- Create/Edit/Detail Modals -->
    @if($showCreateModal)
        @livewire('admin.coupons.coupon-create')
    @endif

    @if($showEditModal && $selectedCoupon)
        @livewire('admin.coupons.coupon-edit', ['couponId' => $selectedCoupon->id])
    @endif

    @if($showDetailModal && $selectedCoupon)
        @include('livewire.admin.coupons.partials.coupon-detail')
    @endif

    @if($showUsageModal && $selectedCoupon)
        @include('livewire.admin.coupons.partials.coupon-usage')
    @endif
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
</style>
@endpush

@push('scripts')
<script>
function toggleSelectAllCoupons(selectAllCheckbox) {
    const checkboxes = document.querySelectorAll('input[type="checkbox"][wire\\:model="selectedCoupons"]');
    
    checkboxes.forEach(checkbox => {
        if (!checkbox.disabled) {
            checkbox.checked = selectAllCheckbox.checked;
            checkbox.dispatchEvent(new Event('change'));
        }
    });
}

document.addEventListener('livewire:init', () => {
    function updateSelectAllState() {
        const checkboxes = document.querySelectorAll('input[type="checkbox"][wire\\:model="selectedCoupons"]:not([disabled])');
        const selectAllCheckbox = document.getElementById('selectAllCoupons');
        
        if (checkboxes.length > 0 && selectAllCheckbox) {
            const checkedCount = Array.from(checkboxes).filter(cb => cb.checked).length;
            selectAllCheckbox.checked = checkedCount === checkboxes.length;
            selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < checkboxes.length;
        }
    }

    document.addEventListener('change', function(e) {
        if (e.target.matches('input[type="checkbox"][wire\\:model="selectedCoupons"]')) {
            updateSelectAllState();
        }
    });

    Livewire.hook('morph.updated', () => {
        updateSelectAllState();
    });
});
</script>
@endpush
