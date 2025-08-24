<div class="modal fade show" style="display: block; background: rgba(0,0,0,0.5);">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 16px;">
            <div class="modal-header border-0 p-4">
                <h5 class="modal-title fw-bold">Create New Lane</h5>
                <button type="button" class="btn-close" wire:click="cancel"></button>
            </div>
            <form wire:submit.prevent="save">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <!-- Lane Name -->
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Lane Name *</label>
                            <input type="text" class="form-control" wire:model="name" 
                                   placeholder="Enter lane name (e.g., Lane 1, Premium Lane A)"
                                   style="border-radius: 8px;">
                            @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Capacity *</label>
                            <input type="number" class="form-control" wire:model="capacity" 
                                   min="1" max="10"
                                   style="border-radius: 8px;">
                            <small class="text-muted">Max players</small>
                            @error('capacity') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <!-- Description -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea class="form-control" rows="2" wire:model="description" 
                                      placeholder="Optional description of the lane..."
                                      style="border-radius: 8px; resize: none;"></textarea>
                            @error('description') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <!-- Status and Pricing -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Maintenance Status *</label>
                            <select class="form-select" wire:model="maintenance_status" style="border-radius: 8px;">
                                <option value="operational">Operational</option>
                                <option value="maintenance">Under Maintenance</option>
                                <option value="damaged">Damaged</option>
                            </select>
                            @error('maintenance_status') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Hourly Rate (CHF) *</label>
                            <div class="input-group">
                                <span class="input-group-text">CHF</span>
                                <input type="number" class="form-control" wire:model="hourly_rate" 
                                       step="0.01" min="0"
                                       style="border-radius: 0 8px 8px 0;">
                            </div>
                            @error('hourly_rate') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <!-- Equipment Included -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">Equipment Included</label>
                            <div class="row g-2">
                                @foreach($availableEquipment as $key => $label)
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" 
                                                   wire:model="equipment_included" 
                                                   value="{{ $key }}" 
                                                   id="equipment_{{ $key }}">
                                            <label class="form-check-label" for="equipment_{{ $key }}">
                                                {{ $label }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('equipment_included') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <!-- Active Status -->
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model="is_active" id="is_active">
                                <label class="form-check-label fw-semibold" for="is_active">
                                    Active (Available for bookings)
                                </label>
                            </div>
                        </div>

                        <!-- Preview Card -->
                        @if($name)
                            <div class="col-12">
                                <label class="form-label fw-semibold">Preview</label>
                                <div class="card" style="border: 1px solid #e9ecef; border-radius: 12px;">
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h6 class="fw-bold mb-1">{{ $name }}</h6>
                                            <div>
                                                <span class="badge bg-{{ $is_active ? 'success' : 'secondary' }} me-1">
                                                    {{ $is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                                <span class="badge bg-{{ $maintenance_status === 'operational' ? 'success' : ($maintenance_status === 'maintenance' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst($maintenance_status) }}
                                                </span>
                                            </div>
                                        </div>
                                        
                                        @if($description)
                                            <p class="text-muted small mb-2">{{ $description }}</p>
                                        @endif
                                        
                                        <div class="row g-2 small">
                                            <div class="col-6">
                                                <strong>Capacity:</strong> {{ $capacity }} players
                                            </div>
                                            <div class="col-6">
                                                <strong>Rate:</strong> CHF {{ number_format($hourly_rate, 2) }}/hour
                                            </div>
                                        </div>
                                        
                                        @if(count($equipment_included) > 0)
                                            <div class="mt-2">
                                                <small class="text-muted">Equipment: 
                                                    @foreach($equipment_included as $equipment)
                                                        <span class="badge bg-light text-dark me-1">{{ $availableEquipment[$equipment] }}</span>
                                                    @endforeach
                                                </small>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="modal-footer border-0 p-4">
                    <button type="button" class="btn btn-outline-secondary" wire:click="cancel"
                            style="border-radius: 8px;">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary"
                            style="background: #c02425; border-color: #c02425; border-radius: 8px;">
                        <i class="fas fa-save me-2"></i>Create Lane
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
