<div class="modal fade show" style="display: block; background: rgba(0,0,0,0.5);">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border: none; border-radius: 16px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);">
            <div class="modal-header" style="border-bottom: 1px solid #f8f9fa; padding: 1.5rem;">
                <div class="d-flex align-items-center">
                    <div class="me-3 d-flex align-items-center justify-content-center" 
                         style="width: 48px; height: 48px; background: rgba(192, 36, 37, 0.1); border-radius: 12px;">
                        <i class="fas fa-user-plus" style="color: #c02425; font-size: 1.25rem;"></i>
                    </div>
                    <div>
                        <h5 class="modal-title mb-0" style="color: #1a1a1a; font-weight: 700;">Create New Employee</h5>
                        <small class="text-muted">Add a new employee to the system</small>
                    </div>
                </div>
                <button type="button" class="btn-close" wire:click="$dispatch('closeModals')" aria-label="Close"></button>
            </div>
            <form wire:submit="createEmployee">
                <div class="modal-body" style="padding: 1.5rem;">
                    <div class="row g-3">
                        <!-- User Selection -->
                        <div class="col-12">
                            <h6 class="fw-semibold text-primary mb-3">Employee Information</h6>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Select User *</label>
                            <select wire:model="user_id" class="form-select @error('user_id') is-invalid @enderror" 
                                    style="border-radius: 8px;">
                                <option value="">Choose a user...</option>
                                @foreach($availableUsers as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                            @error('user_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="text-muted">Only non-employee users are shown</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Employee ID *</label>
                            <div class="input-group">
                                <input type="text" wire:model="employee_id" class="form-control @error('employee_id') is-invalid @enderror" 
                                       placeholder="Auto-generated ID" style="border-radius: 8px 0 0 8px;">
                                <button type="button" class="btn btn-outline-secondary" wire:click="regenerateEmployeeId"
                                        style="border-radius: 0 8px 8px 0;">
                                    <i class="fas fa-refresh"></i>
                                </button>
                            </div>
                            @error('employee_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            <small class="text-muted">Click refresh to generate a new ID</small>
                        </div>

                        <!-- Position & Details -->
                        <div class="col-12 mt-4">
                            <h6 class="fw-semibold text-primary mb-3">Position Details</h6>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Position *</label>
                            <select wire:model="position" class="form-select @error('position') is-invalid @enderror" 
                                    style="border-radius: 8px;">
                                <option value="">Select position...</option>
                                <option value="manager">Manager</option>
                                <option value="supervisor">Supervisor</option>
                                <option value="instructor">Instructor</option>
                                <option value="cashier">Cashier</option>
                                <option value="maintenance">Maintenance</option>
                                <option value="receptionist">Receptionist</option>
                                <option value="security">Security</option>
                                <option value="cleaner">Cleaner</option>
                                <option value="bartender">Bartender</option>
                                <option value="food_service">Food Service</option>
                            </select>
                            @error('position') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Hire Date *</label>
                            <input type="date" wire:model="hire_date" class="form-control @error('hire_date') is-invalid @enderror" 
                                   style="border-radius: 8px;">
                            @error('hire_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Hourly Rate (CHF)</label>
                            <div class="input-group">
                                <span class="input-group-text" style="border-radius: 8px 0 0 8px;">CHF</span>
                                <input type="number" wire:model="hourly_rate" class="form-control @error('hourly_rate') is-invalid @enderror" 
                                       step="0.01" min="0" placeholder="0.00" style="border-radius: 0 8px 8px 0;">
                            </div>
                            @error('hourly_rate') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            <small class="text-muted">Leave empty if not applicable</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Status</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" wire:model="is_active" id="is_active">
                                <label class="form-check-label fw-semibold" for="is_active">
                                    Employee is Active
                                </label>
                                <small class="d-block text-muted">Inactive employees cannot access the system</small>
                            </div>
                        </div>

                        <!-- Permissions -->
                        <div class="col-12 mt-4">
                            <h6 class="fw-semibold text-primary mb-3">Permissions</h6>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Employee Permissions</label>
                            <div class="row g-2 mt-1">
                                @foreach($availablePermissions as $key => $label)
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" 
                                                   wire:model="permissions" 
                                                   value="{{ $key }}" 
                                                   id="permission_{{ $key }}">
                                            <label class="form-check-label" for="permission_{{ $key }}">
                                                {{ $label }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <small class="text-muted">Select permissions this employee should have</small>
                        </div>

                        <!-- Notes -->
                        <div class="col-12 mt-4">
                            <h6 class="fw-semibold text-primary mb-3">Additional Information</h6>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Notes</label>
                            <textarea wire:model="notes" class="form-control @error('notes') is-invalid @enderror" 
                                      rows="3" placeholder="Internal notes about this employee (not visible to employee)" 
                                      style="border-radius: 8px;"></textarea>
                            @error('notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="text-muted">These notes are only visible to administrators</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #f8f9fa; padding: 1.5rem;">
                    <button type="button" class="btn btn-outline-secondary" wire:click="$dispatch('closeModals')" style="border-radius: 8px; padding: 10px 20px; font-weight: 500;">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary" style="background: #c02425; border-color: #c02425; border-radius: 8px; padding: 10px 20px; font-weight: 500;">
                        <i class="fas fa-plus me-2"></i>Create Employee
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('employee-created', () => {
            window.dispatchEvent(new CustomEvent('closeModals'));
        });
    });

    window.addEventListener('closeModals', () => {
        @this.dispatch('closeModals');
    });
</script>
@endpush