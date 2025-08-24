<!-- Gift Card Transactions Modal -->
@if($showTransactionsModal && $selectedGiftCard)
<div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Transaction History - {{ $selectedGiftCard->code }}</h5>
                <button type="button" class="btn-close" wire:click="closeModals"></button>
            </div>
            <div class="modal-body">
                <!-- Summary Card -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-3">
                                <div class="text-muted small">Original Amount</div>
                                <div class="fw-bold h5 mb-0">CHF {{ number_format($selectedGiftCard->original_amount, 2) }}</div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-muted small">Remaining</div>
                                <div class="fw-bold h5 mb-0 text-success">CHF {{ number_format($selectedGiftCard->remaining_amount, 2) }}</div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-muted small">Used Amount</div>
                                <div class="fw-bold h5 mb-0 text-info">CHF {{ number_format($selectedGiftCard->original_amount - $selectedGiftCard->remaining_amount, 2) }}</div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-muted small">Transactions</div>
                                <div class="fw-bold h5 mb-0">{{ $selectedGiftCard->transactions->count() }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Transactions List -->
                @if($selectedGiftCard->transactions->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Description</th>
                                <th>User/Customer</th>
                                <th>Booking</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($selectedGiftCard->transactions->sortByDesc('transaction_date') as $transaction)
                            <tr>
                                <td>
                                    <span class="badge bg-{{ $transaction->type_color }} bg-opacity-10 text-{{ $transaction->type_color }} border border-{{ $transaction->type_color }}">
                                        {{ $transaction->type_display }}
                                    </span>
                                </td>
                                <td class="fw-semibold">
                                    @if($transaction->transaction_type === 'redemption')
                                        <span class="text-danger">-CHF {{ number_format($transaction->amount, 2) }}</span>
                                    @elseif($transaction->transaction_type === 'purchase')
                                        <span class="text-success">+CHF {{ number_format($transaction->amount, 2) }}</span>
                                    @else
                                        CHF {{ number_format($transaction->amount, 2) }}
                                    @endif
                                </td>
                                <td>{{ $transaction->description ?: 'No description' }}</td>
                                <td>
                                    @if($transaction->user)
                                        <div>
                                            <div class="fw-medium">{{ $transaction->user->name }}</div>
                                            <small class="text-muted">{{ $transaction->user->email }}</small>
                                        </div>
                                    @else
                                        <span class="text-muted">System</span>
                                    @endif
                                </td>
                                <td>
                                    @if($transaction->booking)
                                        <a href="#" class="text-decoration-none">
                                            <small class="text-primary">#{{ $transaction->booking->id }}</small>
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div>
                                        <div class="fw-medium">{{ $transaction->transaction_date->format('M j, Y') }}</div>
                                        <small class="text-muted">{{ $transaction->transaction_date->format('g:i A') }}</small>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-receipt fa-3x mb-3"></i>
                    <h6>No Transactions Found</h6>
                    <p class="mb-0">This gift card hasn't been used yet.</p>
                </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" wire:click="closeModals">Close</button>
                <button type="button" class="btn btn-outline-primary" wire:click="showGiftCardDetail({{ $selectedGiftCard->id }})">
                    <i class="fas fa-info-circle me-2"></i>View Full Details
                </button>
            </div>
        </div>
    </div>
</div>
@endif