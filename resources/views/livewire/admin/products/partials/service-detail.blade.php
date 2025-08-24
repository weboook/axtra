<div class="row g-4">
    <!-- Service Image and Basic Info -->
    <div class="col-md-4">
        <div class="text-center">
            @if($selectedItem->image)
                <img src="{{ asset('storage/' . $selectedItem->image) }}" 
                     alt="{{ $selectedItem->name }}" 
                     class="img-fluid rounded" 
                     style="max-height: 200px; width: 100%; object-fit: cover;">
            @else
                <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                     style="height: 200px; width: 100%;">
                    <i class="fas fa-bullseye fa-3x text-muted"></i>
                </div>
            @endif
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

    <!-- Service Details -->
    <div class="col-md-8">
        <div class="row g-3">
            <!-- Basic Information -->
            <div class="col-12">
                <h5 class="fw-bold text-dark mb-3">Service Information</h5>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-semibold text-muted small">Service Name</label>
                <div class="fw-semibold">{{ $selectedItem->name }}</div>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-semibold text-muted small">Category</label>
                <span class="badge" style="background: #c02425; color: white;">
                    {{ $selectedItem->category_display }}
                </span>
            </div>
            
            <div class="col-12">
                <label class="form-label fw-semibold text-muted small">Description</label>
                <div>{{ $selectedItem->description ?: 'No description provided' }}</div>
            </div>

            <!-- Pricing & Capacity -->
            <div class="col-12 mt-4">
                <h5 class="fw-bold text-dark mb-3">Pricing & Capacity</h5>
            </div>
            
            <div class="col-md-4">
                <label class="form-label fw-semibold text-muted small">Price per Person</label>
                <div class="fw-bold text-success fs-5">CHF {{ number_format($selectedItem->price, 2) }}</div>
            </div>
            
            <div class="col-md-4">
                <label class="form-label fw-semibold text-muted small">Duration</label>
                <div class="fw-semibold">{{ $selectedItem->duration_hours }} hours</div>
            </div>
            
            <div class="col-md-4">
                <label class="form-label fw-semibold text-muted small">Capacity per Slot</label>
                <div class="fw-semibold">{{ $selectedItem->capacity_per_slot }} players</div>
            </div>

            <!-- Player Range -->
            <div class="col-12 mt-4">
                <h5 class="fw-bold text-dark mb-3">Player Requirements</h5>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-semibold text-muted small">Minimum Players</label>
                <div class="fw-semibold">{{ $selectedItem->min_players }} players</div>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-semibold text-muted small">Maximum Players</label>
                <div class="fw-semibold">{{ $selectedItem->max_players }} players</div>
            </div>

            <!-- Pricing Examples -->
            <div class="col-12 mt-4">
                <h5 class="fw-bold text-dark mb-3">Pricing Examples</h5>
                <div class="row g-2">
                    @for($i = $selectedItem->min_players; $i <= min($selectedItem->max_players, $selectedItem->min_players + 3); $i++)
                        <div class="col-md-3">
                            <div class="card border-0" style="background: #f8f9fa;">
                                <div class="card-body p-3 text-center">
                                    <div class="fw-semibold">{{ $i }} Player{{ $i > 1 ? 's' : '' }}</div>
                                    <div class="text-success fw-bold">CHF {{ number_format($selectedItem->getTotalPriceForPlayers($i), 2) }}</div>
                                    <small class="text-muted">Total</small>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>

            <!-- Recent Bookings Stats (if available) -->
            @php
                $recentBookings = \App\Models\Booking::where('service_id', $selectedItem->id)
                    ->where('created_at', '>=', now()->subDays(30))
                    ->count();
                $totalBookings = \App\Models\Booking::where('service_id', $selectedItem->id)->count();
                $avgRating = \App\Models\Review::whereHas('booking', function($q) {
                    $q->where('service_id', $this->selectedItem->id);
                })->avg('rating');
            @endphp
            
            @if($totalBookings > 0)
                <div class="col-12 mt-4">
                    <h5 class="fw-bold text-dark mb-3">Performance Stats</h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="card border-0" style="background: rgba(40, 167, 69, 0.1);">
                                <div class="card-body p-3 text-center">
                                    <div class="fw-bold fs-4 text-success">{{ $totalBookings }}</div>
                                    <small class="text-muted">Total Bookings</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0" style="background: rgba(0, 123, 255, 0.1);">
                                <div class="card-body p-3 text-center">
                                    <div class="fw-bold fs-4 text-primary">{{ $recentBookings }}</div>
                                    <small class="text-muted">Last 30 Days</small>
                                </div>
                            </div>
                        </div>
                        @if($avgRating)
                            <div class="col-md-4">
                                <div class="card border-0" style="background: rgba(255, 193, 7, 0.1);">
                                    <div class="card-body p-3 text-center">
                                        <div class="fw-bold fs-4 text-warning">{{ number_format($avgRating, 1) }}</div>
                                        <small class="text-muted">Avg Rating</small>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>