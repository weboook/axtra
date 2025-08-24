<div class="row g-4">
    <!-- Event Type Preview -->
    <div class="col-md-4">
        <div class="text-center">
            <div class="card border-0" style="background: {{ $selectedItem->color }}; color: white; border-radius: 1rem;">
                <div class="card-body p-4">
                    <div class="mb-3">
                        <i class="{{ $selectedItem->icon }} fa-3x"></i>
                    </div>
                    <h5 class="fw-bold mb-0">{{ $selectedItem->name }}</h5>
                    @if($selectedItem->description)
                        <small class="opacity-75">{{ $selectedItem->description }}</small>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="mt-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <small class="text-muted">Status</small>
                @if($selectedItem->is_active)
                    <span class="badge bg-success">
                        <i class="fas fa-check-circle me-1"></i>Active
                    </span>
                @else
                    <span class="badge bg-warning">
                        <i class="fas fa-pause-circle me-1"></i>Inactive
                    </span>
                @endif
            </div>
            
            <div class="d-flex justify-content-between align-items-center mb-2">
                <small class="text-muted">Created</small>
                <small>{{ $selectedItem->created_at->format('M j, Y') }}</small>
            </div>
            
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">Updated</small>
                <small>{{ $selectedItem->updated_at->format('M j, Y') }}</small>
            </div>
        </div>
    </div>

    <!-- Event Type Details -->
    <div class="col-md-8">
        <div class="row g-3">
            <!-- Basic Information -->
            <div class="col-12">
                <h5 class="fw-bold text-dark mb-3">Event Type Information</h5>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-semibold text-muted small">Event Type Name</label>
                <div class="fw-semibold">{{ $selectedItem->name }}</div>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-semibold text-muted small">Slug</label>
                <div><code>{{ $selectedItem->slug }}</code></div>
            </div>
            
            <div class="col-12">
                <label class="form-label fw-semibold text-muted small">Description</label>
                <div>{{ $selectedItem->description ?: 'No description provided' }}</div>
            </div>

            <!-- Display Settings -->
            <div class="col-12 mt-4">
                <h5 class="fw-bold text-dark mb-3">Display Settings</h5>
            </div>
            
            <div class="col-md-4">
                <label class="form-label fw-semibold text-muted small">Icon</label>
                <div class="d-flex align-items-center">
                    <div class="rounded-circle me-2 d-flex align-items-center justify-content-center" 
                         style="width: 32px; height: 32px; background: {{ $selectedItem->color }}; color: white;">
                        <i class="{{ $selectedItem->icon }} fa-sm"></i>
                    </div>
                    <code class="small">{{ $selectedItem->icon }}</code>
                </div>
            </div>
            
            <div class="col-md-4">
                <label class="form-label fw-semibold text-muted small">Color</label>
                <div class="d-flex align-items-center">
                    <div class="rounded-circle me-2" 
                         style="width: 24px; height: 24px; background: {{ $selectedItem->color }};"></div>
                    <code class="small">{{ $selectedItem->color }}</code>
                </div>
            </div>
            
            <div class="col-md-4">
                <label class="form-label fw-semibold text-muted small">Sort Order</label>
                <div class="fw-semibold">{{ $selectedItem->sort_order ?? 0 }}</div>
            </div>

            <!-- Settings -->
            <div class="col-12 mt-4">
                <h5 class="fw-bold text-dark mb-3">Settings</h5>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-semibold text-muted small">Custom Input</label>
                <div>
                    @if($selectedItem->allows_custom_input)
                        <span class="badge bg-success">
                            <i class="fas fa-check-circle me-1"></i>Allowed
                        </span>
                        <div class="small text-muted mt-1">Users can specify their own event type</div>
                    @else
                        <span class="badge bg-light text-dark">
                            <i class="fas fa-times-circle me-1"></i>Not Allowed
                        </span>
                        <div class="small text-muted mt-1">Users must select from predefined options</div>
                    @endif
                </div>
            </div>

            <!-- Usage Statistics -->
            @php
                $recentUsage = \App\Models\Booking::where('event_type', $selectedItem->slug)
                    ->where('created_at', '>=', now()->subDays(30))
                    ->count();
                $totalUsage = \App\Models\Booking::where('event_type', $selectedItem->slug)->count();
            @endphp
            
            <div class="col-12 mt-4">
                <h5 class="fw-bold text-dark mb-3">Usage Statistics</h5>
                @if($totalUsage > 0)
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="card border-0" style="background: rgba(40, 167, 69, 0.1);">
                                <div class="card-body p-3 text-center">
                                    <div class="fw-bold fs-4 text-success">{{ $totalUsage }}</div>
                                    <small class="text-muted">Total Bookings</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0" style="background: rgba(0, 123, 255, 0.1);">
                                <div class="card-body p-3 text-center">
                                    <div class="fw-bold fs-4 text-primary">{{ $recentUsage }}</div>
                                    <small class="text-muted">Last 30 Days</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-light border">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>No usage data yet</strong> - This event type hasn't been used in any bookings yet
                    </div>
                @endif
            </div>

            <!-- Recent Bookings -->
            @if($totalUsage > 0)
                @php
                    $recentBookings = \App\Models\Booking::where('event_type', $selectedItem->slug)
                        ->with(['service'])
                        ->orderBy('booking_date', 'desc')
                        ->limit(5)
                        ->get();
                @endphp

                @if($recentBookings->count() > 0)
                    <div class="col-12 mt-4">
                        <h5 class="fw-bold text-dark mb-3">Recent Bookings</h5>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Service</th>
                                        <th>Players</th>
                                        @if($selectedItem->allows_custom_input)
                                            <th>Custom Type</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentBookings as $booking)
                                        <tr>
                                            <td>{{ $booking->booking_date->format('M j, Y') }}</td>
                                            <td>{{ $booking->service->name }}</td>
                                            <td>{{ $booking->player_count }}</td>
                                            @if($selectedItem->allows_custom_input)
                                                <td>{{ $booking->custom_event_type ?: '-' }}</td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            @endif

            <!-- Preview in Different Contexts -->
            <div class="col-12 mt-4">
                <h5 class="fw-bold text-dark mb-3">Preview in UI</h5>
                <div class="row g-2">
                    <!-- Button Style -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted small">Button Style</label>
                        <div class="p-2 border rounded">
                            <button type="button" class="btn w-100 p-2" style="border-radius: 0.75rem; border: 1px solid #dee2e6; background: white; color: #333;">
                                <div class="d-flex align-items-center">
                                    <i class="{{ $selectedItem->icon }} me-2" style="color: {{ $selectedItem->color }};"></i>
                                    <div class="fw-semibold small">{{ $selectedItem->name }}</div>
                                </div>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Badge Style -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted small">Badge Style</label>
                        <div class="p-2 border rounded">
                            <span class="badge d-inline-flex align-items-center" style="background: {{ $selectedItem->color }}; color: white; font-size: 0.875rem;">
                                <i class="{{ $selectedItem->icon }} me-1"></i>
                                {{ $selectedItem->name }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>