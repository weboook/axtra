<div class="modal fade show" style="display: block; background: rgba(0,0,0,0.5);">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 16px;">
            <div class="modal-header border-0 p-4">
                <h5 class="modal-title fw-bold">Create New Event Type</h5>
                <button type="button" class="btn-close" wire:click="cancel"></button>
            </div>
            <form wire:submit.prevent="save">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <!-- Event Type Name -->
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Event Type Name *</label>
                            <input type="text" class="form-control" wire:model="name" 
                                   placeholder="Enter event type name"
                                   style="border-radius: 8px;">
                            @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Sort Order *</label>
                            <input type="number" class="form-control" wire:model="sort_order" 
                                   min="0"
                                   style="border-radius: 8px;">
                            @error('sort_order') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <!-- Slug -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">Slug *</label>
                            <input type="text" class="form-control" wire:model="slug" 
                                   placeholder="event-type-slug"
                                   style="border-radius: 8px;">
                            <small class="text-muted">URL-friendly identifier (auto-generated from name)</small>
                            @error('slug') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <!-- Description -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea class="form-control" rows="3" wire:model="description" 
                                      placeholder="Describe this event type..."
                                      style="border-radius: 8px; resize: none;"></textarea>
                            @error('description') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <!-- Icon Selection -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Icon *</label>
                            <select class="form-select" wire:model="icon" style="border-radius: 8px;">
                                <option value="">Select Icon</option>
                                @foreach($commonIcons as $iconClass => $iconLabel)
                                    <option value="{{ $iconClass }}">{{ $iconLabel }} ({{ $iconClass }})</option>
                                @endforeach
                            </select>
                            @error('icon') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            
                            @if($icon)
                                <div class="mt-2">
                                    <small class="text-muted">Preview:</small>
                                    <div class="d-inline-flex align-items-center ms-2">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                             style="width: 32px; height: 32px; background: {{ $color }}; color: white;">
                                            <i class="{{ $icon }} fa-sm"></i>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Color Selection -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Color *</label>
                            <select class="form-select" wire:model="color" style="border-radius: 8px;">
                                <option value="">Select Color</option>
                                @foreach($commonColors as $colorCode => $colorLabel)
                                    <option value="{{ $colorCode }}">{{ $colorLabel }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Or enter custom hex code below</small>
                            @error('color') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            
                            <div class="mt-2">
                                <input type="color" class="form-control form-control-color" wire:model="color" 
                                       style="width: 50px; height: 35px; border-radius: 8px;">
                            </div>
                        </div>

                        <!-- Settings -->
                        <div class="col-12">
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" wire:model="allows_custom_input" id="allows_custom_input">
                                        <label class="form-check-label fw-semibold" for="allows_custom_input">
                                            Allow Custom Input
                                        </label>
                                        <div class="small text-muted">Users can specify their own event type</div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" wire:model="is_active" id="is_active">
                                        <label class="form-check-label fw-semibold" for="is_active">
                                            Active
                                        </label>
                                        <div class="small text-muted">Available for selection</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Preview Card -->
                        @if($name && $icon && $color)
                            <div class="col-12">
                                <label class="form-label fw-semibold">Preview</label>
                                <div class="border rounded p-3" style="background: #f8f9fa;">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle me-3 d-flex align-items-center justify-content-center" 
                                             style="width: 40px; height: 40px; background: {{ $color }}; color: white;">
                                            <i class="{{ $icon }}"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $name }}</div>
                                            @if($description)
                                                <small class="text-muted">{{ $description }}</small>
                                            @endif
                                        </div>
                                        @if($allows_custom_input)
                                            <span class="badge bg-info ms-auto">Custom Input</span>
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
                        <i class="fas fa-save me-2"></i>Create Event Type
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>