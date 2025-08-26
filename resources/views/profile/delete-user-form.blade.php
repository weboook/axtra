<div>
    <div class="card border-0" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); border: 2px solid rgba(220, 53, 69, 0.1);">
        <div class="card-header" style="background: rgba(220, 53, 69, 0.05); border-bottom: 1px solid rgba(220, 53, 69, 0.1); padding: 1.5rem 1.5rem 0; border-radius: 1.25rem 1.25rem 0 0;">
            <h5 class="mb-0 fw-bold d-flex align-items-center" style="color: #dc3545;">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Delete Account
            </h5>
            <p class="text-muted mb-0 mt-1" style="font-size: 0.9rem;">Permanently delete your account and all associated data.</p>
        </div>
        <div class="card-body p-4">
            <!-- Warning -->
            <div class="alert alert-danger d-flex align-items-start mb-4" style="border-radius: 1rem; border: none;">
                <i class="fas fa-exclamation-triangle me-3 mt-1"></i>
                <div>
                    <h6 class="fw-semibold mb-1">⚠️ This Action Cannot Be Undone</h6>
                    <p class="mb-0" style="font-size: 0.9rem;">
                        Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.
                    </p>
                </div>
            </div>

            <!-- Information Cards -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="p-3 text-center bg-light rounded-3" style="border: 1px solid #e0e6ed;">
                        <i class="fas fa-user-times text-danger mb-2" style="font-size: 1.5rem;"></i>
                        <h6 class="fw-semibold mb-1" style="color: #1b1b1b; font-size: 0.9rem;">Profile Data</h6>
                        <p class="mb-0 text-muted" style="font-size: 0.8rem;">All personal information</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 text-center bg-light rounded-3" style="border: 1px solid #e0e6ed;">
                        <i class="fas fa-calendar-times text-danger mb-2" style="font-size: 1.5rem;"></i>
                        <h6 class="fw-semibold mb-1" style="color: #1b1b1b; font-size: 0.9rem;">Booking History</h6>
                        <p class="mb-0 text-muted" style="font-size: 0.8rem;">All reservations & sessions</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 text-center bg-light rounded-3" style="border: 1px solid #e0e6ed;">
                        <i class="fas fa-trophy text-danger mb-2" style="font-size: 1.5rem;"></i>
                        <h6 class="fw-semibold mb-1" style="color: #1b1b1b; font-size: 0.9rem;">Achievements</h6>
                        <p class="mb-0 text-muted" style="font-size: 0.8rem;">Progress & rewards</p>
                    </div>
                </div>
            </div>

            <!-- Alternative Actions -->
            <div class="alert alert-info d-flex align-items-start mb-4" style="border-radius: 1rem; border: none;">
                <i class="fas fa-lightbulb me-3 mt-1"></i>
                <div>
                    <h6 class="fw-semibold mb-1">Consider Alternatives</h6>
                    <p class="mb-2" style="font-size: 0.9rem;">
                        Instead of deleting your account, you might consider:
                    </p>
                    <ul class="mb-0" style="font-size: 0.85rem;">
                        <li>Temporarily deactivating your account</li>
                        <li>Updating your privacy settings</li>
                        <li>Removing specific data while keeping your account</li>
                    </ul>
                </div>
            </div>

            <!-- Actions -->
            <div class="d-flex justify-content-end pt-3" style="border-top: 1px solid rgba(220, 53, 69, 0.1);">
                <button type="button" class="btn px-4 py-2" 
                        style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border-radius: 1rem; border: none;"
                        wire:click="confirmUserDeletion" wire:loading.attr="disabled">
                    <span wire:loading.remove>
                        <i class="fas fa-trash-alt me-2"></i>Delete Account
                    </span>
                    <span wire:loading>
                        <i class="fas fa-spinner fa-spin me-2"></i>Loading...
                    </span>
                </button>
            </div>
        </div>
    </div>

    <!-- Delete User Confirmation Modal -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true" 
         wire:ignore.self 
         x-data="{ show: @entangle('confirmingUserDeletion').live }" 
         x-show="show" 
         x-on:keydown.escape.window="show = false"
         style="display: none;"
         x-transition.duration.200ms>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border: none; border-radius: 16px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);">
                <div class="modal-header" style="border-bottom: 1px solid #f8f9fa; padding: 1.5rem;">
                    <div class="d-flex align-items-center">
                        <div class="me-3 d-flex align-items-center justify-content-center" 
                             style="width: 48px; height: 48px; background: rgba(220, 53, 69, 0.1); border-radius: 12px;">
                            <i class="fas fa-exclamation-triangle" style="color: #dc3545; font-size: 1.25rem;"></i>
                        </div>
                        <div>
                            <h5 class="modal-title mb-0" id="confirmDeleteModalLabel" style="color: #1a1a1a; font-weight: 700;">
                                Confirm Account Deletion
                            </h5>
                            <small class="text-muted">This action cannot be undone</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close" x-on:click="show = false" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 1.5rem;">
                    <div class="alert alert-danger mb-4" style="border-radius: 1rem; border: none;">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-exclamation-triangle me-3 mt-1"></i>
                            <div>
                                <h6 class="fw-semibold mb-1">⚠️ Final Warning</h6>
                                <p class="mb-0" style="font-size: 0.9rem;">
                                    Are you sure you want to delete your account? This action is <strong>permanent and irreversible</strong>. All of your data will be permanently deleted.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div x-data="{}" x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
                        <label for="deletePassword" class="form-label fw-semibold" style="color: #1b1b1b;">Confirm with Password</label>
                        <input type="password" id="deletePassword"
                               class="form-control @error('password') is-invalid @enderror" 
                               style="border-radius: 1rem; padding: 0.75rem 1rem; border: 2px solid #dc3545; font-size: 0.95rem;"
                               autocomplete="current-password"
                               placeholder="Enter your password to confirm deletion"
                               x-ref="password"
                               wire:model="password"
                               wire:keydown.enter="deleteUser">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #f8f9fa; padding: 1.5rem;">
                    <button type="button" class="btn btn-outline-secondary" 
                            style="border-radius: 8px; padding: 10px 20px; font-weight: 500;" 
                            x-on:click="show = false" wire:loading.attr="disabled">
                        Cancel
                    </button>
                    <button type="button" class="btn btn-danger" 
                            style="border-radius: 8px; padding: 10px 20px; font-weight: 500;"
                            wire:click="deleteUser" wire:loading.attr="disabled">
                        <span wire:loading.remove>
                            <i class="fas fa-trash-alt me-2"></i>Delete Account Forever
                        </span>
                        <span wire:loading>
                            <i class="fas fa-spinner fa-spin me-2"></i>Deleting...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('confirming-delete-user', () => {
            // Let Alpine handle the modal state through entangle
        });
    });
    </script>
</div>
