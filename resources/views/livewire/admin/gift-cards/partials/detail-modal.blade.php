<!-- Gift Card Detail Modal -->
@if($showDetailModal && $selectedGiftCard)
<div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Gift Card Details - {{ $selectedGiftCard->code }}</h5>
                <button type="button" class="btn-close" wire:click="closeModals"></button>
            </div>
            <div class="modal-body">
                <div class="row g-4">
                    <!-- Gift Card Information -->
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header">
                                <h6 class="card-title mb-0"><i class="fas fa-gift me-2"></i>Gift Card Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-6">
                                        <small class="text-muted">Code</small>
                                        <div class="fw-semibold">{{ $selectedGiftCard->code }}</div>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Status</small>
                                        <div>
                                            <span class="badge bg-{{ $selectedGiftCard->status_color }} bg-opacity-10 text-{{ $selectedGiftCard->status_color }}">
                                                {{ str_replace('_', ' ', title_case($selectedGiftCard->status)) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Original Amount</small>
                                        <div class="fw-semibold">CHF {{ number_format($selectedGiftCard->original_amount, 2) }}</div>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Remaining Amount</small>
                                        <div class="fw-semibold text-{{ $selectedGiftCard->remaining_amount > 0 ? 'success' : 'muted' }}">
                                            CHF {{ number_format($selectedGiftCard->remaining_amount, 2) }}
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <small class="text-muted">Usage Progress</small>
                                        <div class="progress mt-1" style="height: 8px;">
                                            <div class="progress-bar bg-{{ $selectedGiftCard->status_color }}" 
                                                 style="width: {{ $selectedGiftCard->usage_percentage }}%"></div>
                                        </div>
                                        <small class="text-muted">{{ number_format($selectedGiftCard->usage_percentage, 1) }}% used</small>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Valid Until</small>
                                        <div class="fw-semibold">{{ $selectedGiftCard->valid_until->format('M j, Y') }}</div>
                                        <small class="text-muted">{{ $selectedGiftCard->days_until_expiry }} days left</small>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Created</small>
                                        <div class="fw-semibold">{{ $selectedGiftCard->created_at->format('M j, Y') }}</div>
                                        <small class="text-muted">{{ $selectedGiftCard->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recipient Information -->
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header">
                                <h6 class="card-title mb-0"><i class="fas fa-user me-2"></i>Recipient & Purchase Info</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <small class="text-muted">Recipient Name</small>
                                        <div class="fw-semibold">{{ $selectedGiftCard->recipient_name }}</div>
                                    </div>
                                    <div class="col-12">
                                        <small class="text-muted">Recipient Email</small>
                                        <div class="fw-semibold">{{ $selectedGiftCard->recipient_email }}</div>
                                    </div>
                                    <div class="col-12">
                                        <small class="text-muted">Purchased By</small>
                                        <div class="fw-semibold">
                                            @if($selectedGiftCard->purchaser)
                                                {{ $selectedGiftCard->purchaser->name }}
                                                <br><small class="text-muted">{{ $selectedGiftCard->purchaser->email }}</small>
                                            @else
                                                <span class="text-muted">System Created</span>
                                            @endif
                                        </div>
                                    </div>
                                    @if($selectedGiftCard->message)
                                    <div class="col-12">
                                        <small class="text-muted">Personal Message</small>
                                        <div class="bg-light p-3 rounded">
                                            <i class="fas fa-quote-left text-muted me-2"></i>
                                            {{ $selectedGiftCard->message }}
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Transaction History -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title mb-0">
                                    <i class="fas fa-history me-2"></i>
                                    Transaction History ({{ $selectedGiftCard->transactions->count() }})
                                </h6>
                            </div>
                            <div class="card-body p-0">
                                @if($selectedGiftCard->transactions->isNotEmpty())
                                <div class="table-responsive">
                                    <table class="table table-sm mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Type</th>
                                                <th>Amount</th>
                                                <th>Description</th>
                                                <th>User</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($selectedGiftCard->transactions->sortByDesc('transaction_date') as $transaction)
                                            <tr>
                                                <td>
                                                    <span class="badge bg-{{ $transaction->type_color }} bg-opacity-10 text-{{ $transaction->type_color }}">
                                                        {{ $transaction->type_display }}
                                                    </span>
                                                </td>
                                                <td class="fw-semibold">CHF {{ number_format($transaction->amount, 2) }}</td>
                                                <td>{{ $transaction->description }}</td>
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
                                @else
                                <div class="text-center py-4 text-muted">
                                    <i class="fas fa-history fa-2x mb-3"></i>
                                    <p class="mb-0">No transactions recorded yet</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" wire:click="closeModals">Close</button>
                <button type="button" class="btn btn-outline-primary" wire:click="showEditGiftCard({{ $selectedGiftCard->id }})">
                    <i class="fas fa-edit me-2"></i>Edit Gift Card
                </button>
            </div>
        </div>
    </div>
</div>
@endif