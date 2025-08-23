<div>
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0" style="background: linear-gradient(135deg, #c02425 0%, #d63031 100%); color: white; border-radius: 1.5rem; box-shadow: 0 20px 60px rgba(192, 36, 37, 0.3);">
                <div class="card-body py-4 px-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h2 class="mb-2 fw-bold">Gift Cards</h2>
                            <p class="mb-3 opacity-90" style="font-size: 1.1rem;">Purchase and manage gift cards for Axtra activities</p>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-gift me-2"></i>
                                <span>Perfect for gifting memorable experiences</span>
                            </div>
                        </div>
                        <div class="d-none d-md-block">
                            <i class="fas fa-gift" style="font-size: 4rem; opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 text-center" 
                 style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); transition: transform 0.3s ease, box-shadow 0.3s ease;"
                 onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 20px 40px rgba(0, 0, 0, 0.12)';"
                 onmouseout="this.style.transform='translateY(0px)'; this.style.boxShadow='0 10px 30px rgba(0, 0, 0, 0.08)';">
                <div class="card-body p-4">
                    <div class="mb-3">
                        <i class="fas fa-shopping-cart" style="font-size: 2.5rem; color: #c02425;"></i>
                    </div>
                    <h5 class="mb-2 fw-bold" style="color: #1b1b1b;">{{ $purchasedGiftCards->total() }}</h5>
                    <p class="text-muted mb-0">Purchased Cards</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 text-center" 
                 style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); transition: transform 0.3s ease, box-shadow 0.3s ease;"
                 onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 20px 40px rgba(0, 0, 0, 0.12)';"
                 onmouseout="this.style.transform='translateY(0px)'; this.style.boxShadow='0 10px 30px rgba(0, 0, 0, 0.08)';">
                <div class="card-body p-4">
                    <div class="mb-3">
                        <i class="fas fa-dollar-sign" style="font-size: 2.5rem; color: #28a745;"></i>
                    </div>
                    <h5 class="mb-2 fw-bold" style="color: #1b1b1b;">${{ number_format($purchasedGiftCards->sum('original_amount'), 2) }}</h5>
                    <p class="text-muted mb-0">Total Value</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 text-center" 
                 style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); transition: transform 0.3s ease, box-shadow 0.3s ease;"
                 onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 20px 40px rgba(0, 0, 0, 0.12)';"
                 onmouseout="this.style.transform='translateY(0px)'; this.style.boxShadow='0 10px 30px rgba(0, 0, 0, 0.08)';">
                <div class="card-body p-4">
                    <div class="mb-3">
                        <i class="fas fa-check-circle" style="font-size: 2.5rem; color: #17a2b8;"></i>
                    </div>
                    <h5 class="mb-2 fw-bold" style="color: #1b1b1b;">{{ $purchasedGiftCards->where('is_active', true)->count() }}</h5>
                    <p class="text-muted mb-0">Active Cards</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if (session()->has('giftCardPurchased'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" style="border-radius: 1rem; border: none;">
            <i class="fas fa-check-circle me-3"></i>
            <div>
                <h6 class="fw-semibold mb-1">Gift Card Purchased!</h6>
                <p class="mb-0">{{ session('giftCardPurchased') }}</p>
                @if($giftCardCode)
                    <p class="mb-0 mt-1"><strong>Gift Card Code:</strong> <code>{{ $giftCardCode }}</code></p>
                @endif
            </div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Main Content -->
    <div class="row">
        <div class="col-12">
            <!-- Purchase New Gift Card -->
            <div class="card border-0 mb-4" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                <div class="card-header" style="background: transparent; border-bottom: 1px solid rgba(0, 0, 0, 0.05); padding: 1.5rem 1.5rem 0; border-radius: 1.25rem 1.25rem 0 0;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="mb-0 fw-bold d-flex align-items-center" style="color: #1b1b1b;">
                                <i class="fas fa-plus-circle me-2" style="color: #c02425;"></i>
                                Purchase Gift Card
                            </h5>
                            <p class="text-muted mb-0 mt-1" style="font-size: 0.9rem;">Buy a gift card for friends and family</p>
                        </div>
                        <button type="button" class="btn px-4 py-2" 
                                style="background: linear-gradient(135deg, #c02425 0%, #d63031 100%); color: white; border-radius: 1rem; border: none;"
                                wire:click="showPurchaseModal">
                            <i class="fas fa-gift me-2"></i>Purchase Gift Card
                        </button>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-3">
                            <div class="text-center p-3 bg-light rounded-3" style="border: 1px solid #e0e6ed;">
                                <i class="fas fa-dollar-sign text-success mb-2" style="font-size: 1.5rem;"></i>
                                <h6 class="fw-semibold mb-1" style="color: #1b1b1b; font-size: 0.9rem;">Any Amount</h6>
                                <p class="mb-0 text-muted" style="font-size: 0.8rem;">$10 - $1,000</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3 bg-light rounded-3" style="border: 1px solid #e0e6ed;">
                                <i class="fas fa-calendar-alt text-info mb-2" style="font-size: 1.5rem;"></i>
                                <h6 class="fw-semibold mb-1" style="color: #1b1b1b; font-size: 0.9rem;">1 Year Valid</h6>
                                <p class="mb-0 text-muted" style="font-size: 0.8rem;">From purchase date</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3 bg-light rounded-3" style="border: 1px solid #e0e6ed;">
                                <i class="fas fa-envelope text-warning mb-2" style="font-size: 1.5rem;"></i>
                                <h6 class="fw-semibold mb-1" style="color: #1b1b1b; font-size: 0.9rem;">Email Delivery</h6>
                                <p class="mb-0 text-muted" style="font-size: 0.8rem;">Sent instantly</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3 bg-light rounded-3" style="border: 1px solid #e0e6ed;">
                                <i class="fas fa-redo text-primary mb-2" style="font-size: 1.5rem;"></i>
                                <h6 class="fw-semibold mb-1" style="color: #1b1b1b; font-size: 0.9rem;">Reusable</h6>
                                <p class="mb-0 text-muted" style="font-size: 0.8rem;">Until depleted</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Purchased Gift Cards -->
            <div class="card border-0" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                <div class="card-header" style="background: transparent; border-bottom: 1px solid rgba(0, 0, 0, 0.05); padding: 1.5rem 1.5rem 0; border-radius: 1.25rem 1.25rem 0 0;">
                    <h5 class="mb-0 fw-bold d-flex align-items-center" style="color: #1b1b1b;">
                        <i class="fas fa-history me-2" style="color: #c02425;"></i>
                        Your Gift Cards
                    </h5>
                    <p class="text-muted mb-0 mt-1" style="font-size: 0.9rem;">Manage your purchased gift cards</p>
                </div>
                <div class="card-body p-4">
                    @if($purchasedGiftCards->count() > 0)
                        <div class="row g-3">
                            @foreach($purchasedGiftCards as $giftCard)
                                <div class="col-md-6">
                                    <div class="card border" style="border-radius: 1rem; border-color: {{ $giftCard->isValid() ? '#28a745' : '#6c757d' }} !important; background: {{ $giftCard->isValid() ? 'rgba(40, 167, 69, 0.05)' : 'rgba(108, 117, 125, 0.05)' }};">
                                        <div class="card-body p-3">
                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-gift me-2" style="color: {{ $giftCard->isValid() ? '#28a745' : '#6c757d' }};"></i>
                                                    <code class="fw-bold" style="color: #1b1b1b;">{{ $giftCard->code }}</code>
                                                </div>
                                                <span class="badge rounded-pill" style="background: {{ $giftCard->isValid() ? '#28a745' : '#6c757d' }};">
                                                    {{ $giftCard->isValid() ? 'Active' : 'Inactive' }}
                                                </span>
                                            </div>
                                            
                                            <div class="row g-2 mb-3">
                                                <div class="col-6">
                                                    <small class="text-muted d-block">Recipient</small>
                                                    <p class="mb-0 fw-semibold" style="font-size: 0.9rem;">{{ $giftCard->recipient_name }}</p>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-muted d-block">Amount</small>
                                                    <p class="mb-0 fw-semibold" style="font-size: 0.9rem;">${{ number_format($giftCard->original_amount, 2) }}</p>
                                                </div>
                                            </div>
                                            
                                            <div class="row g-2 mb-3">
                                                <div class="col-6">
                                                    <small class="text-muted d-block">Remaining</small>
                                                    <p class="mb-0 fw-semibold" style="font-size: 0.9rem; color: {{ $giftCard->remaining_amount > 0 ? '#28a745' : '#dc3545' }};">
                                                        ${{ number_format($giftCard->remaining_amount, 2) }}
                                                    </p>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-muted d-block">Expires</small>
                                                    <p class="mb-0 fw-semibold" style="font-size: 0.9rem;">{{ $giftCard->valid_until->format('M j, Y') }}</p>
                                                </div>
                                            </div>
                                            
                                            @if($giftCard->message)
                                                <div class="mb-2">
                                                    <small class="text-muted d-block">Message</small>
                                                    <p class="mb-0" style="font-size: 0.85rem; font-style: italic;">"{{ $giftCard->message }}"</p>
                                                </div>
                                            @endif
                                            
                                            <div class="d-flex align-items-center justify-content-between">
                                                <small class="text-muted">Purchased {{ $giftCard->created_at->diffForHumans() }}</small>
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" class="btn btn-outline-primary" style="border-radius: 0.5rem;">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-secondary" style="border-radius: 0.5rem;">
                                                        <i class="fas fa-envelope"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="d-flex justify-content-center mt-4">
                            {{ $purchasedGiftCards->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-gift text-muted mb-3" style="font-size: 3rem; opacity: 0.5;"></i>
                            <h6 class="text-muted">No gift cards purchased yet</h6>
                            <p class="text-muted mb-4">Purchase your first gift card to get started</p>
                            <button type="button" class="btn px-4 py-2" 
                                    style="background: linear-gradient(135deg, #c02425 0%, #d63031 100%); color: white; border-radius: 1rem; border: none;"
                                    wire:click="showPurchaseModal">
                                <i class="fas fa-gift me-2"></i>Purchase Gift Card
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Purchase Modal -->
    <div class="modal fade" tabindex="-1" 
         x-data="{ show: @entangle('showPurchaseForm') }" 
         x-show="show" 
         x-on:keydown.escape.window="show = false"
         style="display: none;"
         x-transition>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0" style="border-radius: 1.25rem; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);">
                <div class="modal-header" style="background: transparent; border-bottom: 1px solid rgba(0, 0, 0, 0.05); padding: 1.5rem 1.5rem 0; border-radius: 1.25rem 1.25rem 0 0;">
                    <h5 class="modal-title fw-bold d-flex align-items-center" style="color: #1b1b1b;">
                        <i class="fas fa-gift me-2" style="color: #c02425;"></i>
                        Purchase Gift Card
                    </h5>
                    <button type="button" class="btn-close" wire:click="closePurchaseModal"></button>
                </div>
                <div class="modal-body p-4">
                    <form wire:submit="purchaseGiftCard">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="recipientName" class="form-label fw-semibold" style="color: #1b1b1b;">Recipient Name</label>
                                <input type="text" id="recipientName" 
                                       class="form-control @error('recipientName') is-invalid @enderror" 
                                       style="border-radius: 1rem; padding: 0.75rem 1rem; border: 1px solid #e0e6ed; font-size: 0.95rem;"
                                       wire:model="recipientName" 
                                       placeholder="Enter recipient's name">
                                @error('recipientName')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="recipientEmail" class="form-label fw-semibold" style="color: #1b1b1b;">Recipient Email</label>
                                <input type="email" id="recipientEmail" 
                                       class="form-control @error('recipientEmail') is-invalid @enderror" 
                                       style="border-radius: 1rem; padding: 0.75rem 1rem; border: 1px solid #e0e6ed; font-size: 0.95rem;"
                                       wire:model="recipientEmail" 
                                       placeholder="Enter recipient's email">
                                @error('recipientEmail')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="amount" class="form-label fw-semibold" style="color: #1b1b1b;">Amount ($10 - $1,000)</label>
                                <div class="input-group">
                                    <span class="input-group-text" style="border-radius: 1rem 0 0 1rem; border: 1px solid #e0e6ed; background: #f8f9fa;">$</span>
                                    <input type="number" id="amount" 
                                           class="form-control @error('amount') is-invalid @enderror" 
                                           style="border-radius: 0 1rem 1rem 0; padding: 0.75rem 1rem; border: 1px solid #e0e6ed; font-size: 0.95rem;"
                                           wire:model="amount" 
                                           min="10" max="1000" step="5">
                                    @error('amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="message" class="form-label fw-semibold" style="color: #1b1b1b;">Personal Message (Optional)</label>
                                <textarea id="message" rows="3" 
                                          class="form-control @error('message') is-invalid @enderror" 
                                          style="border-radius: 1rem; padding: 0.75rem 1rem; border: 1px solid #e0e6ed; font-size: 0.95rem;"
                                          wire:model="message" 
                                          placeholder="Add a personal message to your gift card"></textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" style="background: transparent; border-top: 1px solid rgba(0, 0, 0, 0.05); padding: 0 1.5rem 1.5rem; border-radius: 0 0 1.25rem 1.25rem;">
                    <button type="button" class="btn btn-outline-secondary px-4 py-2 me-2" 
                            style="border-radius: 1rem;" 
                            wire:click="closePurchaseModal">
                        Cancel
                    </button>
                    <button type="button" class="btn px-4 py-2" 
                            style="background: linear-gradient(135deg, #c02425 0%, #d63031 100%); color: white; border-radius: 1rem; border: none;"
                            wire:click="purchaseGiftCard" wire:loading.attr="disabled">
                        <span wire:loading.remove>
                            <i class="fas fa-gift me-2"></i>Purchase Gift Card
                        </span>
                        <span wire:loading>
                            <i class="fas fa-spinner fa-spin me-2"></i>Processing...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
