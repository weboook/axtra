<div class="modal fade show" style="display: block; background: rgba(0,0,0,0.5);">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 16px;">
            <div class="modal-header border-0 p-4">
                <h5 class="modal-title fw-bold">Create New Service</h5>
                <button type="button" class="btn-close" wire:click="cancel"></button>
            </div>
            <form wire:submit.prevent="save">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <!-- Service Name -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">Service Name *</label>
                            <input type="text" class="form-control" wire:model="name" 
                                   placeholder="Enter service name"
                                   style="border-radius: 8px;">
                            @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <!-- Description -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea class="form-control" rows="3" wire:model="description" 
                                      placeholder="Describe your service..."
                                      style="border-radius: 8px; resize: none;"></textarea>
                            @error('description') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <!-- Category and Duration -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Category *</label>
                            <select class="form-select" wire:model="category" style="border-radius: 8px;">
                                <option value="">Select Category</option>
                                <option value="axe_throwing">Axe Throwing</option>
                                <option value="axe_throwing_making">Axe Throwing & Making</option>
                                <option value="axe_making">Axe Making</option>
                                <option value="private_events">Private Events</option>
                            </select>
                            @error('category') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Duration (Hours) *</label>
                            <input type="number" class="form-control" wire:model="duration_hours" 
                                   step="0.5" min="0.5" max="24"
                                   style="border-radius: 8px;">
                            @error('duration_hours') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <!-- Player Range -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Minimum Players *</label>
                            <input type="number" class="form-control" wire:model="min_players" 
                                   min="1" max="100"
                                   style="border-radius: 8px;">
                            @error('min_players') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Maximum Players *</label>
                            <input type="number" class="form-control" wire:model="max_players" 
                                   min="1" max="100"
                                   style="border-radius: 8px;">
                            @error('max_players') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <!-- Price and Capacity -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Price (CHF per person) *</label>
                            <div class="input-group">
                                <span class="input-group-text">CHF</span>
                                <input type="number" class="form-control" wire:model="price" 
                                       step="0.01" min="0"
                                       style="border-radius: 0 8px 8px 0;">
                            </div>
                            @error('price') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Capacity per Slot *</label>
                            <input type="number" class="form-control" wire:model="capacity_per_slot" 
                                   min="1" max="200"
                                   style="border-radius: 8px;">
                            <small class="text-muted">Total players allowed per time slot</small>
                            @error('capacity_per_slot') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <!-- Image Upload -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">Service Image</label>
                            <input type="file" class="form-control" wire:model="image" 
                                   accept="image/*"
                                   style="border-radius: 8px;">
                            <small class="text-muted">Maximum file size: 2MB. Supported formats: JPG, PNG, GIF</small>
                            @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            
                            @if ($image)
                                <div class="mt-2">
                                    <img src="{{ $image->temporaryUrl() }}" alt="Preview" 
                                         class="img-thumbnail" style="max-width: 200px; max-height: 150px;">
                                </div>
                            @endif
                        </div>

                        <!-- Active Status -->
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model="is_active" id="is_active">
                                <label class="form-check-label fw-semibold" for="is_active">
                                    Active (Available for booking)
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 p-4">
                    <button type="button" class="btn btn-outline-secondary" wire:click="cancel"
                            style="border-radius: 8px;">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary"
                            style="background: #c02425; border-color: #c02425; border-radius: 8px;">
                        <i class="fas fa-save me-2"></i>Create Service
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>