<!-- Edit Gift Card Modal -->
@if($showEditModal && $selectedGiftCard)
<div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Gift Card - {{ $selectedGiftCard->code }}</h5>
                <button type="button" class="btn-close" wire:click="closeModals"></button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="updateGiftCard">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Recipient Name <span class="text-danger">*</span></label>
                            <input type="text" wire:model="form.recipient_name" class="form-control @error('form.recipient_name') is-invalid @enderror">
                            @error('form.recipient_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Recipient Email <span class="text-danger">*</span></label>
                            <input type="email" wire:model="form.recipient_email" class="form-control @error('form.recipient_email') is-invalid @enderror">
                            @error('form.recipient_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Original Amount (CHF) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" wire:model="form.original_amount" class="form-control @error('form.original_amount') is-invalid @enderror">
                            @error('form.original_amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Valid Until <span class="text-danger">*</span></label>
                            <input type="date" wire:model="form.valid_until" class="form-control @error('form.valid_until') is-invalid @enderror">
                            @error('form.valid_until') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label">Personal Message</label>
                            <textarea wire:model="form.message" class="form-control @error('form.message') is-invalid @enderror" rows="3"></textarea>
                            @error('form.message') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model="form.is_active" id="editActive">
                                <label class="form-check-label" for="editActive">
                                    Active
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" wire:click="closeModals">Cancel</button>
                <button type="button" wire:click="updateGiftCard" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Update Gift Card
                </button>
            </div>
        </div>
    </div>
</div>
@endif