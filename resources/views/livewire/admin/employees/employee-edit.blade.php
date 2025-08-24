<div class="modal fade show" style="display: block; background: rgba(0,0,0,0.5);">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" style="border-radius: 16px;">
            <div class="modal-header border-0 p-4">
                <h5 class="modal-title fw-bold">Edit Employee: {{ $employee->user->name }}</h5>
                <button type="button" class="btn-close" wire:click="$dispatch('closeModals')"></button>
            </div>
            <form wire:submit="updateEmployee">
                <div class="modal-body p-4">
                    <div class="row g-4">
                        <!-- Employee Profile Section -->
                        <div class="col-md-3">
                            <div class="text-center mb-4">
                                <img src="{{ $employee->user->profile_photo_url }}" 
                                     class="rounded-circle mb-3" 
                                     width="120" height="120"
                                     style="object-fit: cover;">
                                <h6>{{ $employee->user->name }}</h6>
                                <small class="text-muted">{{ $employee->user->email }}</small>
                                <div class="mt-2">
                                    <span class="badge bg-primary">{{ $employee->employee_id }}</span>
                                </div>
                                <small class="text-muted d-block mt-1">Employee since {{ $employee->hire_date->format('M Y') }}</small>
                            </div>
                        </div>

                        <div class="col-md-9">
                            <div class="row g-3">
                                <!-- Employee Details -->
                                <div class="col-12">
                                    <h6 class="fw-semibold text-primary mb-3">Employee Details</h6>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Employee ID *</label>
                                    <input type="text" wire:model="employee_id" class="form-control @error('employee_id') is-invalid @enderror" 
                                           placeholder="Employee ID" style="border-radius: 8px;">
                                    @error('employee_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                                </div>

                                <!-- Status -->
                                <div class="col-12 mt-4">
                                    <h6 class="fw-semibold text-primary mb-3">Status</h6>
                                </div>

                                <div class="col-12">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" wire:model="is_active" id="is_active_edit">
                                        <label class="form-check-label fw-semibold" for="is_active_edit">
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
                                                           id="edit_permission_{{ $key }}">
                                                    <label class="form-check-label" for="edit_permission_{{ $key }}">
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

                                <!-- Current Employment Stats -->
                                <div class="col-12 mt-4">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="card border-0" style="background: #f8f9fa;">
                                                <div class="card-body p-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="me-3">
                                                            <i class="fas fa-calendar-alt text-primary"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0">Employment Duration</h6>
                                                            <small class="text-muted">{{ $employee->hire_date->diffForHumans(null, true) }}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card border-0" style="background: #f8f9fa;">
                                                <div class="card-body p-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="me-3">
                                                            <i class="fas fa-user-check text-success"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0">Account Status</h6>
                                                            <small class="text-muted">{{ $employee->user->role === 'employee' ? 'Employee' : ucfirst($employee->user->role) }}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4">
                    <button type="button" class="btn btn-secondary" wire:click="$dispatch('closeModals')">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="background: #c02425; border-color: #c02425;">
                        <i class="fas fa-save me-2"></i>Update Employee
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('employee-updated', () => {
            window.dispatchEvent(new CustomEvent('closeModals'));
        });
    });

    window.addEventListener('closeModals', () => {
        @this.dispatch('closeModals');
    });
</script>
@endpush