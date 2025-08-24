<div>
    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 mb-1 fw-bold text-dark">Gift Cards Management</h2>
            <p class="text-muted mb-0">Create, manage, and track gift card sales and usage</p>
        </div>
        <button wire:click="showCreateGiftCard" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Create Gift Card
        </button>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar avatar-md bg-primary bg-opacity-10 text-primary rounded">
                                <i class="fas fa-gift"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title mb-1">Total Gift Cards</h6>
                            <h4 class="card-text mb-0 fw-bold">{{ $stats['total'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar avatar-md bg-success bg-opacity-10 text-success rounded">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title mb-1">Active Cards</h6>
                            <h4 class="card-text mb-0 fw-bold text-success">{{ $stats['active'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar avatar-md bg-info bg-opacity-10 text-info rounded">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title mb-1">Total Value</h6>
                            <h4 class="card-text mb-0 fw-bold text-info">CHF {{ number_format($stats['total_value'], 2) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar avatar-md bg-warning bg-opacity-10 text-warning rounded">
                                <i class="fas fa-wallet"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title mb-1">Remaining Value</h6>
                            <h4 class="card-text mb-0 fw-bold text-warning">CHF {{ number_format($stats['remaining_value'], 2) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label small text-muted mb-2">Search Gift Cards</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" wire:model.live="search" class="form-control border-start-0 ps-0" 
                               placeholder="Search by code, recipient...">
                    </div>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label small text-muted mb-2">Status Filter</label>
                    <select wire:model.live="statusFilter" class="form-select">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="expired">Expired</option>
                        <option value="fully_redeemed">Fully Redeemed</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                
                <div class="col-md-2">
                    <label class="form-label small text-muted mb-2">Per Page</label>
                    <select wire:model.live="perPage" class="form-select">
                        <option value="15">15</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label small text-muted mb-2">Bulk Actions</label>
                    <div class="input-group">
                        <select wire:model="bulkAction" class="form-select">
                            <option value="">Choose action...</option>
                            <option value="activate">Activate</option>
                            <option value="deactivate">Deactivate</option>
                            <option value="extend">Extend (1 year)</option>
                        </select>
                        <button wire:click="bulkAction" class="btn btn-outline-primary" 
                                :disabled="selectedGiftCards.length === 0">Apply</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gift Cards Table -->
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="border-0 ps-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" 
                                       x-on:change="$wire.selectedGiftCards = $event.target.checked ? 
                                       @js($giftCards->pluck('id')->toArray()) : []">
                            </div>
                        </th>
                        <th class="border-0">
                            <button wire:click="sortBy('code')" class="btn btn-link p-0 text-decoration-none fw-semibold text-dark">
                                Code
                                @if($sortBy === 'code')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                @endif
                            </button>
                        </th>
                        <th class="border-0">
                            <button wire:click="sortBy('recipient_name')" class="btn btn-link p-0 text-decoration-none fw-semibold text-dark">
                                Recipient
                                @if($sortBy === 'recipient_name')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                @endif
                            </button>
                        </th>
                        <th class="border-0">
                            <button wire:click="sortBy('original_amount')" class="btn btn-link p-0 text-decoration-none fw-semibold text-dark">
                                Value
                                @if($sortBy === 'original_amount')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                @endif
                            </button>
                        </th>
                        <th class="border-0">Remaining</th>
                        <th class="border-0">Status</th>
                        <th class="border-0">
                            <button wire:click="sortBy('valid_until')" class="btn btn-link p-0 text-decoration-none fw-semibold text-dark">
                                Expires
                                @if($sortBy === 'valid_until')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                @endif
                            </button>
                        </th>
                        <th class="border-0">Purchaser</th>
                        <th class="border-0 pe-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($giftCards as $giftCard)
                    <tr>
                        <td class="ps-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" 
                                       wire:model="selectedGiftCards" value="{{ $giftCard->id }}">
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm bg-primary bg-opacity-10 text-primary rounded me-3">
                                    <i class="fas fa-gift"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $giftCard->code }}</div>
                                    <small class="text-muted">{{ $giftCard->transactions_count }} transaction(s)</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div>
                                <div class="fw-medium">{{ $giftCard->recipient_name }}</div>
                                <small class="text-muted">{{ $giftCard->recipient_email }}</small>
                            </div>
                        </td>
                        <td>
                            <span class="fw-semibold">CHF {{ number_format($giftCard->original_amount, 2) }}</span>
                        </td>
                        <td>
                            <div>
                                <span class="fw-medium">CHF {{ number_format($giftCard->remaining_amount, 2) }}</span>
                                <div class="progress mt-1" style="height: 4px;">
                                    <div class="progress-bar bg-{{ $giftCard->status_color }}" 
                                         style="width: {{ $giftCard->usage_percentage }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-{{ $giftCard->status_color }} bg-opacity-10 text-{{ $giftCard->status_color }} border border-{{ $giftCard->status_color }}">
                                {{ str_replace('_', ' ', title_case($giftCard->status)) }}
                            </span>
                        </td>
                        <td>
                            <div>
                                <div class="fw-medium">{{ $giftCard->valid_until->format('M j, Y') }}</div>
                                <small class="text-muted">{{ $giftCard->days_until_expiry }} days left</small>
                            </div>
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
                        <td class="pe-3">
                            <div class="dropdown">
                                <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#" wire:click.prevent="showGiftCardDetail({{ $giftCard->id }})">
                                        <i class="fas fa-eye me-2"></i>View Details</a></li>
                                    <li><a class="dropdown-item" href="#" wire:click.prevent="showGiftCardTransactions({{ $giftCard->id }})">
                                        <i class="fas fa-history me-2"></i>View Transactions</a></li>
                                    <li><a class="dropdown-item" href="#" wire:click.prevent="showEditGiftCard({{ $giftCard->id }})">
                                        <i class="fas fa-edit me-2"></i>Edit</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="#" wire:click.prevent="toggleGiftCardStatus({{ $giftCard->id }})">
                                        <i class="fas fa-{{ $giftCard->is_active ? 'pause' : 'play' }} me-2"></i>
                                        {{ $giftCard->is_active ? 'Deactivate' : 'Activate' }}</a></li>
                                    <li><a class="dropdown-item" href="#" wire:click.prevent="extendGiftCard({{ $giftCard->id }})">
                                        <i class="fas fa-calendar-plus me-2"></i>Extend (1 Year)</a></li>
                                    @if($giftCard->remaining_amount > 0)
                                    <li><a class="dropdown-item text-warning" href="#" wire:click.prevent="refundGiftCard({{ $giftCard->id }})" 
                                           onclick="return confirm('Are you sure you want to refund this gift card?')">
                                        <i class="fas fa-undo me-2"></i>Refund</a></li>
                                    @endif
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-gift fa-3x mb-3"></i>
                                <h5>No Gift Cards Found</h5>
                                <p class="mb-0">Start by creating your first gift card.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($giftCards->hasPages())
        <div class="card-footer bg-white border-top-0">
            {{ $giftCards->links() }}
        </div>
        @endif
    </div>

    <!-- Recent Transactions -->
    @if($recentTransactions->isNotEmpty())
    <div class="card border-0 shadow-sm mt-4">
        <div class="card-header bg-white">
            <h6 class="card-title mb-0 fw-semibold">
                <i class="fas fa-history me-2 text-primary"></i>Recent Transactions
            </h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0">Gift Card</th>
                            <th class="border-0">Type</th>
                            <th class="border-0">Amount</th>
                            <th class="border-0">User</th>
                            <th class="border-0">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentTransactions as $transaction)
                        <tr>
                            <td>
                                <span class="fw-medium">{{ $transaction->giftCard->code }}</span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $transaction->type_color }} bg-opacity-10 text-{{ $transaction->type_color }}">
                                    {{ $transaction->type_display }}
                                </span>
                            </td>
                            <td>CHF {{ number_format($transaction->amount, 2) }}</td>
                            <td>
                                @if($transaction->user)
                                    {{ $transaction->user->name }}
                                @else
                                    <span class="text-muted">System</span>
                                @endif
                            </td>
                            <td class="text-muted">{{ $transaction->transaction_date->format('M j, Y g:i A') }}</td>
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