<div class="modal fade show" style="display: block; background: rgba(0,0,0,0.5);">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 16px;">
            <div class="modal-header border-0 p-4">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-plus me-2"></i>Add History Entry - {{ $lane->name }}
                </h5>
                <button type="button" class="btn-close" wire:click="cancel"></button>
            </div>
            <form wire:submit.prevent="save">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <!-- Event Type and Severity -->
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Event Type *</label>
                            <select class="form-select" wire:model="event_type" style="border-radius: 8px;">
                                <option value="">Select Event Type</option>
                                @foreach($eventTypes as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('event_type') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Severity</label>
                            <select class="form-select" wire:model="severity" style="border-radius: 8px;">
                                <option value="">Select Severity</option>
                                @foreach($severityLevels as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('severity') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <!-- Title -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">Title *</label>
                            <input type="text" class="form-control" wire:model="title" 
                                   placeholder="Brief description of what happened"
                                   style="border-radius: 8px;">
                            @error('title') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <!-- Description -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">Detailed Description</label>
                            <textarea class="form-control" rows="4" wire:model="description" 
                                      placeholder="Detailed description of the event, actions taken, parts used, etc..."
                                      style="border-radius: 8px; resize: none;"></textarea>
                            @error('description') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <!-- Date/Time and Performed By -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Date & Time *</label>
                            <input type="datetime-local" class="form-control" wire:model="occurred_at" 
                                   style="border-radius: 8px;">
                            @error('occurred_at') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Performed By</label>
                            <input type="text" class="form-control" wire:model="performed_by" 
                                   placeholder="Person who performed this work"
                                   style="border-radius: 8px;">
                            @error('performed_by') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <!-- Cost and Downtime -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Cost (CHF)</label>
                            <div class="input-group">
                                <span class="input-group-text">CHF</span>
                                <input type="number" class="form-control" wire:model="cost" 
                                       step="0.01" min="0" placeholder="0.00"
                                       style="border-radius: 0 8px 8px 0;">
                            </div>
                            <small class="text-muted">Leave empty if no cost involved</small>
                            @error('cost') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Downtime (Minutes) *</label>
                            <input type="number" class="form-control" wire:model="downtime_minutes" 
                                   min="0" placeholder="0"
                                   style="border-radius: 8px;">
                            <small class="text-muted">How long was the lane out of service</small>
                            @error('downtime_minutes') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <!-- Photo Uploads -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Before Photos</label>
                            <input type="file" class="form-control" wire:model="before_photos" 
                                   multiple accept="image/*"
                                   style="border-radius: 8px;">
                            <small class="text-muted">Photos showing the issue/condition before work</small>
                            @error('before_photos.*') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            
                            @if($before_photos)
                                <div class="mt-2">
                                    <div class="row g-2">
                                        @foreach($before_photos as $index => $photo)
                                            <div class="col-4">
                                                <img src="{{ $photo->temporaryUrl() }}" alt="Before {{ $index + 1 }}" 
                                                     class="img-thumbnail" style="max-height: 80px; width: 100%; object-fit: cover;">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">After Photos</label>
                            <input type="file" class="form-control" wire:model="after_photos" 
                                   multiple accept="image/*"
                                   style="border-radius: 8px;">
                            <small class="text-muted">Photos showing the result after work completed</small>
                            @error('after_photos.*') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            
                            @if($after_photos)
                                <div class="mt-2">
                                    <div class="row g-2">
                                        @foreach($after_photos as $index => $photo)
                                            <div class="col-4">
                                                <img src="{{ $photo->temporaryUrl() }}" alt="After {{ $index + 1 }}" 
                                                     class="img-thumbnail" style="max-height: 80px; width: 100%; object-fit: cover;">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Preview -->
                        @if($event_type && $title)
                            <div class="col-12">
                                <label class="form-label fw-semibold">Preview</label>
                                <div class="card" style="border: 1px solid #e9ecef; border-radius: 12px;">
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <span class="badge bg-{{ match($event_type) {
                                                    'axe_break' => 'danger',
                                                    'block_replacement' => 'warning', 
                                                    'maintenance' => 'info',
                                                    'damage_report' => 'danger',
                                                    'repair' => 'success',
                                                    default => 'secondary'
                                                } }} me-2">{{ $eventTypes[$event_type] ?? '' }}</span>
                                                @if($severity)
                                                    <span class="badge bg-{{ match($severity) {
                                                        'minor' => 'success',
                                                        'major' => 'warning', 
                                                        'critical' => 'danger',
                                                        default => 'secondary'
                                                    } }}">{{ ucfirst($severity) }}</span>
                                                @endif
                                            </div>
                                            <small class="text-muted">{{ date('M j, Y H:i', strtotime($occurred_at)) }}</small>
                                        </div>
                                        
                                        <h6 class="fw-bold mb-2">{{ $title }}</h6>
                                        
                                        @if($description)
                                            <p class="text-muted small mb-2">{{ $description }}</p>
                                        @endif
                                        
                                        <div class="row g-2 small">
                                            @if($cost)
                                                <div class="col-md-4">
                                                    <strong>Cost:</strong> CHF {{ number_format($cost, 2) }}
                                                </div>
                                            @endif
                                            @if($downtime_minutes > 0)
                                                <div class="col-md-4">
                                                    <strong>Downtime:</strong> {{ $downtime_minutes }} min
                                                </div>
                                            @endif
                                            @if($performed_by)
                                                <div class="col-md-4">
                                                    <strong>By:</strong> {{ $performed_by }}
                                                </div>
                                            @endif
                                        </div>
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
                        <i class="fas fa-save me-2"></i>Add History Entry
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>