<div class="container-fluid p-4">
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
            <h1 class="h3 mb-1" style="color: #1a1a1a; font-weight: 700;">Gift Cards Management</h1>
            <p class="text-muted mb-0">Create, manage, and track gift card sales and usage</p>
        </div>
        <button wire:click="showCreateGiftCard" class="btn btn-primary d-flex align-items-center" 
                style="background: #c02425; border-color: #c02425; padding: 12px 24px; border-radius: 12px; font-weight: 600;">
            <i class="fas fa-plus me-2"></i>
            Create New Gift Card
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
                            <small class="opacity-75">Total Gift Cards</small>
                        </div>
                        <i class="fas fa-gift fa-2x opacity-50"></i>
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
                            <small class="opacity-75">Active Cards</small>
                        </div>
                        <i class="fas fa-check-circle fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);">
                <div class="card-body text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1 fw-bold">CHF {{ number_format($stats['total_value'], 0) }}</h4>
                            <small class="opacity-75">Total Value</small>
                        </div>
                        <i class="fas fa-dollar-sign fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #6f42c1 0%, #9c5ade 100%);">
                <div class="card-body text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1 fw-bold">CHF {{ number_format($stats['remaining_value'], 0) }}</h4>
                            <small class="opacity-75">Remaining Value</small>
                        </div>
                        <i class="fas fa-wallet fa-2x opacity-50"></i>
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
                    <label class="form-label fw-semibold text-muted small">Search Gift Cards</label>
                    <div class="input-group">
                        <span class="input-group-text border-0" style="background: #f8f9fa;"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" wire:model.live.debounce.300ms="search" class="form-control border-start-0" 
                               placeholder="Code, recipient, email..." style="background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 0 8px 8px 0;">
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold text-muted small">Status</label>
                    <select wire:model.live="statusFilter" class="form-select" style="border-radius: 8px;">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="expired">Expired</option>
                        <option value="fully_redeemed">Fully Redeemed</option>
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
                <div class="col-md-5">
                    <label class="form-label fw-semibold text-muted small">Bulk Actions</label>
                    <div class="input-group">
                        <select wire:model="bulkAction" class="form-select" style="border-radius: 8px 0 0 8px;">
                            <option value="">Choose action...</option>
                            <option value="activate">Activate</option>
                            <option value="deactivate">Deactivate</option>
                            <option value="extend">Extend 1 Year</option>
                        </select>
                        <button wire:click="bulkAction" class="btn btn-outline-primary" 
                                style="border-radius: 0 8px 8px 0;" @if(empty($selectedGiftCards) || !$bulkAction) disabled @endif>
                            Apply
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gift Cards Table -->
    <div class="card" style="border: none; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
        <div class="card-header bg-transparent border-0 p-4">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-semibold">Gift Cards ({{ $giftCards->total() }})</h5>
                @if(count($selectedGiftCards) > 0)
                    <span class="badge bg-primary">{{ count($selectedGiftCards) }} selected</span>
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
                                       id="selectAllGiftCards"
                                       @if(count($selectedGiftCards) === $giftCards->count() && $giftCards->count() > 0) checked @endif
                                       onclick="toggleSelectAllGiftCards(this)">
                            </th>
                            <th class="border-0 fw-semibold" style="color: #6c757d;">
                                <button wire:click="sortBy('code')" class="btn btn-sm btn-link text-decoration-none p-0" style="color: #6c757d;">
                                    Code @if($sortBy === 'code') <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i> @endif
                                </button>
                            </th>
                            <th class="border-0 fw-semibold" style="color: #6c757d;">
                                <button wire:click="sortBy('recipient_name')" class="btn btn-sm btn-link text-decoration-none p-0" style="color: #6c757d;">
                                    Recipient @if($sortBy === 'recipient_name') <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i> @endif
                                </button>
                            </th>
                            <th class="border-0 fw-semibold" style="color: #6c757d;">Value & Remaining</th>
                            <th class="border-0 fw-semibold" style="color: #6c757d;">
                                <button wire:click="sortBy('valid_until')" class="btn btn-sm btn-link text-decoration-none p-0" style="color: #6c757d;">
                                    Expires @if($sortBy === 'valid_until') <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i> @endif
                                </button>
                            </th>
                            <th class="border-0 fw-semibold" style="color: #6c757d;">Status</th>
                            <th class="border-0 fw-semibold" style="color: #6c757d;">Purchaser</th>
                            <th class="border-0 pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($giftCards as $giftCard)
                            <tr style="border-bottom: 1px solid #f0f0f0;">
                                <td class="ps-4">
                                    <input type="checkbox" class="form-check-input" 
                                           wire:model="selectedGiftCards" 
                                           value="{{ $giftCard->id }}">
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3" style="background: rgba(192, 36, 37, 0.1); padding: 8px 12px; border-radius: 8px; border: 1px solid rgba(192, 36, 37, 0.2);">
                                            <code style="color: #c02425; font-weight: bold; font-size: 0.9rem;">{{ $giftCard->code }}</code>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <div class="fw-semibold text-dark">{{ $giftCard->recipient_name }}</div>
                                        <small class="text-muted">{{ $giftCard->recipient_email }}</small>
                                        @if($giftCard->transactions_count > 0)
                                            <div class="small text-muted mt-1">
                                                <i class="fas fa-receipt fa-xs me-1"></i>{{ $giftCard->transactions_count }} transaction(s)
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-semibold text-success">CHF {{ number_format($giftCard->original_amount, 2) }}</div>
                                    <div class="small">
                                        <strong>Remaining:</strong> <span class="text-{{ $giftCard->remaining_amount > 0 ? 'info' : 'muted' }}">CHF {{ number_format($giftCard->remaining_amount, 2) }}</span>
                                    </div>
                                    @if($giftCard->usage_percentage > 0)
                                        <div class="progress mt-1" style="height: 4px;">
                                            <div class="progress-bar bg-{{ $giftCard->status_color }}" 
                                                 style="width: {{ $giftCard->usage_percentage }}%"></div>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="small">
                                        <strong>Until:</strong> {{ $giftCard->valid_until->format('M j, Y') }}
                                        @if($giftCard->status === 'active' && $giftCard->days_until_expiry <= 30)
                                            <div class="badge bg-warning text-dark mt-1">
                                                <i class="fas fa-clock me-1"></i>{{ $giftCard->days_until_expiry }} days left
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $giftCard->status_color }}">
                                        <i class="fas fa-{{ match($giftCard->status) {
                                            'active' => 'check-circle',
                                            'expired' => 'clock',
                                            'fully_redeemed' => 'wallet',
                                            'partially_used' => 'credit-card',
                                            'inactive' => 'times-circle',
                                            default => 'question-circle'
                                        } }} me-1"></i>
                                        {{ str_replace('_', ' ', ucfirst($giftCard->status)) }}
                                    </span>
                                </td>
                                <td>
                                    @if($giftCard->purchaser)
                                        <div>
                                            <div class="fw-medium">{{ $giftCard->purchaser->name }}</div>
                                            <small class="text-muted">{{ $giftCard->created_at->format('M j, Y') }}</small>
                                        </div>
                                    @else
                                        <span class="text-muted">System</span>
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
                                            <li><a class="dropdown-item" href="#" wire:click="showGiftCardDetail({{ $giftCard->id }})">
                                                <i class="fas fa-eye me-2"></i>View Details
                                            </a></li>
                                            <li><a class="dropdown-item" href="#" wire:click="showGiftCardTransactions({{ $giftCard->id }})">
                                                <i class="fas fa-history me-2"></i>View Transactions
                                            </a></li>
                                            <li><a class="dropdown-item" href="#" wire:click="showEditGiftCard({{ $giftCard->id }})">
                                                <i class="fas fa-edit me-2"></i>Edit Gift Card
                                            </a></li>
                                            @if($giftCard->status !== 'expired')
                                                <li><a class="dropdown-item" href="#" wire:click="extendGiftCard({{ $giftCard->id }}, 365)">
                                                    <i class="fas fa-calendar-plus me-2"></i>Extend 1 Year
                                                </a></li>
                                            @endif
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item" href="#" wire:click="toggleGiftCardStatus({{ $giftCard->id }})">
                                                <i class="fas fa-{{ $giftCard->is_active ? 'pause' : 'play' }} me-2"></i>
                                                {{ $giftCard->is_active ? 'Deactivate' : 'Activate' }}
                                            </a></li>
                                            @if($giftCard->remaining_amount > 0)
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger" href="#" 
                                                       wire:click="refundGiftCard({{ $giftCard->id }})"
                                                       onclick="return confirm('Are you sure you want to refund this gift card?')">
                                                    <i class="fas fa-undo me-2"></i>Refund Gift Card
                                                </a></li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center p-5">
                                    <div class="text-muted">
                                        <i class="fas fa-gift fa-3x mb-3"></i>
                                        <h5>No gift cards found</h5>
                                        <p>Try adjusting your search criteria or create your first gift card</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($giftCards->hasPages())
                <div class="card-footer bg-transparent border-0 p-4">
                    {{ $giftCards->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Recent Transaction Activity -->
    @if($recentTransactions->count() > 0)
        <div class="card mt-4" style="border: none; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
            <div class="card-header bg-transparent border-0 p-4">
                <h5 class="mb-0 fw-semibold">
                    <i class="fas fa-chart-line me-2"></i>Recent Gift Card Activity
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead style="background: #f8f9fa;">
                            <tr>
                                <th class="border-0 ps-4">Date</th>
                                <th class="border-0">Gift Card</th>
                                <th class="border-0">Type</th>
                                <th class="border-0">Amount</th>
                                <th class="border-0">User</th>
                                <th class="border-0 pe-4">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentTransactions as $transaction)
                                <tr style="border-bottom: 1px solid #f0f0f0;">
                                    <td class="ps-4">
                                        <small>{{ $transaction->transaction_date->format('M j, Y H:i') }}</small>
                                    </td>
                                    <td>
                                        <code style="background: rgba(192, 36, 37, 0.1); color: #c02425; padding: 2px 6px; border-radius: 4px;">
                                            {{ $transaction->giftCard->code }}
                                        </code>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $transaction->type_color }}">
                                            {{ $transaction->type_display }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($transaction->transaction_type === 'redemption')
                                            <span class="fw-bold text-danger">-CHF {{ number_format($transaction->amount, 2) }}</span>
                                        @elseif($transaction->transaction_type === 'purchase')
                                            <span class="fw-bold text-success">+CHF {{ number_format($transaction->amount, 2) }}</span>
                                        @else
                                            <span class="fw-bold text-info">CHF {{ number_format($transaction->amount, 2) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small>{{ $transaction->user->name ?? 'System' }}</small>
                                    </td>
                                    <td class="pe-4">
                                        @if($transaction->booking)
                                            <small>Booking #{{ $transaction->booking->id }}</small>
                                        @elseif($transaction->description)
                                            <small class="text-muted">{{ $transaction->description }}</small>
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

    @include('livewire.admin.gift-cards.partials.create-modal')
    @include('livewire.admin.gift-cards.partials.edit-modal')
    @include('livewire.admin.gift-cards.partials.detail-modal')
    @include('livewire.admin.gift-cards.partials.transactions-modal')
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
function toggleSelectAllGiftCards(selectAllCheckbox) {
    const checkboxes = document.querySelectorAll('input[type="checkbox"][wire\\:model="selectedGiftCards"]');
    
    checkboxes.forEach(checkbox => {
        if (!checkbox.disabled) {
            checkbox.checked = selectAllCheckbox.checked;
            checkbox.dispatchEvent(new Event('change'));
        }
    });
}

document.addEventListener('livewire:init', () => {
    function updateSelectAllState() {
        const checkboxes = document.querySelectorAll('input[type="checkbox"][wire\\:model="selectedGiftCards"]:not([disabled])');
        const selectAllCheckbox = document.getElementById('selectAllGiftCards');
        
        if (checkboxes.length > 0 && selectAllCheckbox) {
            const checkedCount = Array.from(checkboxes).filter(cb => cb.checked).length;
            selectAllCheckbox.checked = checkedCount === checkboxes.length;
            selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < checkboxes.length;
        }
    }

    document.addEventListener('change', function(e) {
        if (e.target.matches('input[type="checkbox"][wire\\:model="selectedGiftCards"]')) {
            updateSelectAllState();
        }
    });

    Livewire.hook('morph.updated', () => {
        updateSelectAllState();
    });
});
</script>
@endpush