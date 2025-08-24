<div class="row g-4">
    <!-- Product Image and Basic Info -->
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
                    <i class="fas fa-shopping-cart fa-3x text-muted"></i>
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

    <!-- Product Details -->
    <div class="col-md-8">
        <div class="row g-3">
            <!-- Basic Information -->
            <div class="col-12">
                <h5 class="fw-bold text-dark mb-3">Product Information</h5>
            </div>
            
            <div class="col-md-8">
                <label class="form-label fw-semibold text-muted small">Product Name</label>
                <div class="fw-semibold">{{ $selectedItem->name }}</div>
            </div>
            
            <div class="col-md-4">
                <label class="form-label fw-semibold text-muted small">Price</label>
                <div class="fw-bold text-success fs-5">CHF {{ number_format($selectedItem->price, 2) }}</div>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-semibold text-muted small">Category</label>
                <span class="badge" style="background: #c02425; color: white;">
                    {{ ucwords(str_replace('_', ' ', $selectedItem->category)) }}
                </span>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-semibold text-muted small">Product Type</label>
                <span class="badge {{ $selectedItem->product_type === 'upsell' ? 'bg-info' : 'bg-secondary' }}">
                    <i class="fas fa-{{ $selectedItem->product_type === 'upsell' ? 'arrow-up' : 'plus-circle' }} me-1"></i>
                    {{ ucwords($selectedItem->product_type) }}
                </span>
            </div>
            
            <div class="col-12">
                <label class="form-label fw-semibold text-muted small">Description</label>
                <div>{{ $selectedItem->description ?: 'No description provided' }}</div>
            </div>

            <!-- Stock Management -->
            <div class="col-12 mt-4">
                <h5 class="fw-bold text-dark mb-3">Stock Management</h5>
            </div>
            
            @if($selectedItem->manage_stock)
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-muted small">Current Stock</label>
                    <div class="fw-bold fs-4 {{ $selectedItem->stock_quantity <= $selectedItem->low_stock_threshold ? 'text-warning' : 'text-success' }}">
                        {{ $selectedItem->stock_quantity }}
                        @if($selectedItem->stock_quantity <= $selectedItem->low_stock_threshold)
                            <i class="fas fa-exclamation-triangle ms-1"></i>
                        @endif
                    </div>
                </div>
                
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-muted small">Low Stock Alert</label>
                    <div class="fw-semibold">{{ $selectedItem->low_stock_threshold }} items</div>
                </div>
                
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-muted small">Stock Status</label>
                    <div>
                        @if($selectedItem->stock_quantity <= 0)
                            <span class="badge bg-danger">Out of Stock</span>
                        @elseif($selectedItem->stock_quantity <= $selectedItem->low_stock_threshold)
                            <span class="badge bg-warning">Low Stock</span>
                        @else
                            <span class="badge bg-success">In Stock</span>
                        @endif
                    </div>
                </div>
            @else
                <div class="col-12">
                    <div class="alert alert-info border-0" style="background: rgba(13, 202, 240, 0.1);">
                        <i class="fas fa-infinity me-2"></i>
                        <strong>Unlimited Stock</strong> - This product doesn't track inventory
                    </div>
                </div>
            @endif

            <!-- Sales Performance -->
            @php
                $recentSales = \DB::table('booking_products')
                    ->where('product_id', $selectedItem->id)
                    ->where('created_at', '>=', now()->subDays(30))
                    ->sum('quantity');
                $totalSales = \DB::table('booking_products')
                    ->where('product_id', $selectedItem->id)
                    ->sum('quantity');
                $totalRevenue = \DB::table('booking_products')
                    ->where('product_id', $selectedItem->id)
                    ->sum('price');
            @endphp
            
            @if($totalSales > 0)
                <div class="col-12 mt-4">
                    <h5 class="fw-bold text-dark mb-3">Sales Performance</h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="card border-0" style="background: rgba(40, 167, 69, 0.1);">
                                <div class="card-body p-3 text-center">
                                    <div class="fw-bold fs-4 text-success">{{ $totalSales }}</div>
                                    <small class="text-muted">Total Units Sold</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0" style="background: rgba(0, 123, 255, 0.1);">
                                <div class="card-body p-3 text-center">
                                    <div class="fw-bold fs-4 text-primary">{{ $recentSales }}</div>
                                    <small class="text-muted">Last 30 Days</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0" style="background: rgba(255, 193, 7, 0.1);">
                                <div class="card-body p-3 text-center">
                                    <div class="fw-bold fs-4 text-warning">CHF {{ number_format($totalRevenue, 2) }}</div>
                                    <small class="text-muted">Total Revenue</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-12 mt-4">
                    <div class="alert alert-light border">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>No sales data yet</strong> - This product hasn't been purchased yet
                    </div>
                </div>
            @endif

            <!-- Recent Bookings (if any) -->
            @php
                $recentBookings = \DB::table('booking_products')
                    ->join('bookings', 'booking_products.booking_id', '=', 'bookings.id')
                    ->join('services', 'bookings.service_id', '=', 'services.id')
                    ->where('booking_products.product_id', $selectedItem->id)
                    ->select('bookings.booking_date', 'services.name as service_name', 'booking_products.quantity')
                    ->orderBy('bookings.booking_date', 'desc')
                    ->limit(5)
                    ->get();
            @endphp

            @if($recentBookings->count() > 0)
                <div class="col-12 mt-4">
                    <h5 class="fw-bold text-dark mb-3">Recent Orders</h5>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Service</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentBookings as $booking)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('M j, Y') }}</td>
                                        <td>{{ $booking->service_name }}</td>
                                        <td>{{ $booking->quantity }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>