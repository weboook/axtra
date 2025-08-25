{{-- Employee Equipment Status Page --}}
<div class="container-fluid p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 fw-bold">Equipment Status</h1>
            <p class="text-muted mb-0">Monitor lane status and maintenance history</p>
        </div>
    </div>

    {{-- Success Message --}}
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Statistics Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-2 col-6">
            <div class="card text-center h-100" style="border: none; border-radius: 12px; background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%);">
                <div class="card-body">
                    <h3 class="text-white mb-1">{{ $stats['total_lanes'] }}</h3>
                    <small class="text-white opacity-75">Total Lanes</small>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-6">
            <div class="card text-center h-100" style="border: none; border-radius: 12px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                <div class="card-body">
                    <h3 class="text-white mb-1">{{ $stats['operational'] }}</h3>
                    <small class="text-white opacity-75">Operational</small>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-6">
            <div class="card text-center h-100" style="border: none; border-radius: 12px; background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);">
                <div class="card-body">
                    <h3 class="text-white mb-1">{{ $stats['maintenance'] }}</h3>
                    <small class="text-white opacity-75">Maintenance</small>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-6">
            <div class="card text-center h-100" style="border: none; border-radius: 12px; background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);">
                <div class="card-body">
                    <h3 class="text-white mb-1">{{ $stats['out_of_order'] }}</h3>
                    <small class="text-white opacity-75">Out of Order</small>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-6">
            <div class="card text-center h-100" style="border: none; border-radius: 12px; background: linear-gradient(135deg, #6610f2 0%, #6f42c1 100%);">
                <div class="card-body">
                    <h3 class="text-white mb-1">{{ $stats['recent_issues'] }}</h3>
                    <small class="text-white opacity-75">Today's Issues</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card" style="border: none; border-radius: 16px; box-shadow: 0 8px 32px rgba(0,0,0,0.1);">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Search Lanes</label>
                            <input type="text" class="form-control" wire:model.live="searchTerm" placeholder="Search by lane name...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Status Filter</label>
                            <select class="form-select" wire:model.live="statusFilter">
                                <option value="all">All Statuses</option>
                                <option value="operational">Operational</option>
                                <option value="maintenance">Maintenance</option>
                                <option value="out_of_order">Out of Order</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Lanes Grid --}}
        <div class="col-lg-8">
            <div class="card" style="border: none; border-radius: 16px; box-shadow: 0 8px 32px rgba(0,0,0,0.1);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%); border-radius: 16px 16px 0 0;">
                    <h5 class="mb-0 text-white">
                        <i class="fas fa-bowling-ball me-2"></i>
                        Lanes Overview ({{ count($lanes) }})
                    </h5>
                </div>
                <div class="card-body">
                    @if(count($lanes) > 0)
                        <div class="row g-3">
                            @foreach($lanes as $lane)
                                <div class="col-md-6 col-lg-4">
                                    <div class="card h-100" style="border: none; border-radius: 12px; box-shadow: 0 4px 16px rgba(0,0,0,0.1); cursor: pointer;" wire:click="viewLaneDetails({{ $lane->id }})">
                                        <div class="card-body text-center">
                                            <div class="mb-3">
                                                <i class="fas fa-bowling-ball" style="font-size: 2rem; color: 
                                                    @if($lane->maintenance_status === 'operational') #28a745
                                                    @elseif($lane->maintenance_status === 'maintenance') #ffc107
                                                    @else #dc3545
                                                    @endif
                                                "></i>
                                            </div>
                                            <h5 class="mb-2">{{ $lane->name }}</h5>
                                            <span class="badge 
                                                @if($lane->maintenance_status === 'operational') bg-success
                                                @elseif($lane->maintenance_status === 'maintenance') bg-warning
                                                @else bg-danger
                                                @endif
                                            ">
                                                {{ ucfirst(str_replace('_', ' ', $lane->maintenance_status)) }}
                                            </span>
                                            
                                            @if(count($lane->history) > 0)
                                                <div class="mt-2 text-muted small">
                                                    Last issue: {{ $lane->history->first()->created_at->diffForHumans() }}
                                                </div>
                                            @endif
                                            
                                            {{-- Quick Status Change --}}
                                            <div class="mt-3" onclick="event.stopPropagation();">
                                                <div class="btn-group btn-group-sm w-100" role="group">
                                                    <button class="btn {{ $lane->maintenance_status === 'operational' ? 'btn-success' : 'btn-outline-success' }} btn-sm" 
                                                            wire:click="updateLaneStatus({{ $lane->id }}, 'operational')">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                    <button class="btn {{ $lane->maintenance_status === 'maintenance' ? 'btn-warning' : 'btn-outline-warning' }} btn-sm" 
                                                            wire:click="updateLaneStatus({{ $lane->id }}, 'maintenance')">
                                                        <i class="fas fa-wrench"></i>
                                                    </button>
                                                    <button class="btn {{ $lane->maintenance_status === 'out_of_order' ? 'btn-danger' : 'btn-outline-danger' }} btn-sm" 
                                                            wire:click="updateLaneStatus({{ $lane->id }}, 'out_of_order')">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3" style="font-size: 3rem; color: #dee2e6;">
                                <i class="fas fa-bowling-ball"></i>
                            </div>
                            <p class="text-muted mb-0">No lanes found matching your filters</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Recent Maintenance History --}}
        <div class="col-lg-4">
            <div class="card h-100" style="border: none; border-radius: 16px; box-shadow: 0 8px 32px rgba(0,0,0,0.1);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); border-radius: 16px 16px 0 0;">
                    <h5 class="mb-0 text-white">
                        <i class="fas fa-history me-2"></i>
                        Recent Activity
                    </h5>
                </div>
                <div class="card-body" style="max-height: 500px; overflow-y: auto;">
                    @if(count($recentMaintenanceHistory) > 0)
                        @foreach($recentMaintenanceHistory as $history)
                            <div class="d-flex align-items-start p-3 mb-3 rounded-3" style="background-color: rgba(255, 193, 7, 0.1);">
                                <div class="me-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: 
                                        @if($history->severity === 'critical') #dc3545
                                        @elseif($history->severity === 'high') #fd7e14
                                        @elseif($history->severity === 'medium') #ffc107
                                        @else #28a745
                                        @endif
                                    ;">
                                        <i class="fas fa-
                                            @if($history->event_type === 'block_break') exclamation-triangle
                                            @elseif($history->event_type === 'axe_break') tools
                                            @elseif($history->event_type === 'status_change') exchange-alt
                                            @else wrench
                                            @endif
                                         text-white" style="font-size: 0.8rem;"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 small">{{ $history->lane->name ?? 'Unknown Lane' }}</h6>
                                    <p class="mb-1 text-muted small">{{ Str::limit($history->description, 60) }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge 
                                            @if($history->severity === 'critical') bg-danger
                                            @elseif($history->severity === 'high') bg-warning
                                            @elseif($history->severity === 'medium') bg-info
                                            @else bg-success
                                            @endif
                                        " style="font-size: 0.65rem;">
                                            {{ ucfirst($history->severity) }}
                                        </span>
                                        <small class="text-muted">{{ $history->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-clipboard-list text-muted" style="font-size: 2rem;"></i>
                            <p class="text-muted mt-2 mb-0">No recent activity</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Lane Details Modal --}}
    @if($selectedLane)
        <div class="modal fade show" style="display: block;" tabindex="-1" wire:ignore.self>
            <div class="modal-backdrop fade show"></div>
            <div class="modal-dialog modal-lg">
                <div class="modal-content" style="border-radius: 16px; border: none;">
                    <div class="modal-header" style="background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%); border-radius: 16px 16px 0 0;">
                        <h5 class="modal-title text-white">
                            <i class="fas fa-bowling-ball me-2"></i>
                            {{ $selectedLane->name }} - Details
                        </h5>
                        <button type="button" class="btn-close btn-close-white" wire:click="closeLaneDetails"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <h6>Current Status</h6>
                                <span class="badge fs-6 
                                    @if($selectedLane->maintenance_status === 'operational') bg-success
                                    @elseif($selectedLane->maintenance_status === 'maintenance') bg-warning
                                    @else bg-danger
                                    @endif
                                ">
                                    {{ ucfirst(str_replace('_', ' ', $selectedLane->maintenance_status)) }}
                                </span>
                            </div>
                            <div class="col-md-6">
                                <h6>Last Updated</h6>
                                <span class="text-muted">{{ $selectedLane->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        <h6 class="mb-3">Recent History</h6>
                        @if(count($selectedLane->history) > 0)
                            <div class="timeline">
                                @foreach($selectedLane->history as $history)
                                    <div class="timeline-item mb-3 p-3 rounded-3" style="background-color: rgba(23, 162, 184, 0.05); border-left: 4px solid #17a2b8;">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h6 class="mb-0">{{ ucfirst(str_replace('_', ' ', $history->event_type)) }}</h6>
                                            <span class="badge 
                                                @if($history->severity === 'critical') bg-danger
                                                @elseif($history->severity === 'high') bg-warning
                                                @elseif($history->severity === 'medium') bg-info
                                                @else bg-success
                                                @endif
                                            ">
                                                {{ ucfirst($history->severity) }}
                                            </span>
                                        </div>
                                        <p class="text-muted mb-2">{{ $history->description }}</p>
                                        <div class="d-flex justify-content-between">
                                            <small class="text-muted">
                                                @if($history->performer)
                                                    By: {{ $history->performer->name }}
                                                @endif
                                            </small>
                                            <small class="text-muted">{{ $history->created_at->format('M j, Y H:i') }}</small>
                                        </div>
                                        @if($history->cost)
                                            <div class="mt-2">
                                                <span class="badge bg-info">Cost: CHF {{ number_format($history->cost, 2) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-history text-muted" style="font-size: 2rem;"></i>
                                <p class="text-muted mt-2 mb-0">No maintenance history available</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <style>
    .btn-group-sm .btn {
        padding: 0.25rem 0.5rem;
    }

    .timeline-item {
        position: relative;
    }

    .modal-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1040;
        width: 100vw;
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal.show {
        z-index: 1050;
    }

    ::-webkit-scrollbar {
        width: 6px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }

    ::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
    </style>
</div>