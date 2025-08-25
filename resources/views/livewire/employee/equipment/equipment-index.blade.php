{{-- Employee Equipment Status Page --}}
<div>
    <!-- Equipment Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0" style="background: linear-gradient(135deg, #c02425 0%, #d63031 100%); color: white; border-radius: 1.5rem; box-shadow: 0 20px 60px rgba(192, 36, 37, 0.3);">
                <div class="card-body py-4 px-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h2 class="mb-2 fw-bold">Equipment Status</h2>
                            <p class="mb-3 opacity-90" style="font-size: 1.1rem;">Monitor lane status and maintenance history in real-time</p>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-clipboard-check me-2"></i>
                                <span>Keep track of all equipment conditions and maintenance needs</span>
                            </div>
                        </div>
                        <div class="d-none d-md-block">
                            <i class="fas fa-cog" style="font-size: 4rem; opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>
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
        <div class="col-lg-2 col-md-4 col-6">
            <div class="card border-0 text-center h-100" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); transition: transform 0.3s ease, box-shadow 0.3s ease;"
                 onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 20px 40px rgba(0, 0, 0, 0.12)';"
                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(0, 0, 0, 0.08)';">
                <div class="card-body p-4">
                    <div class="mb-3" style="background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%); width: 60px; height: 60px; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                        <i class="fas fa-bowling-ball" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                    <h3 class="fw-bold mb-2" style="color: #1b1b1b;">{{ $stats['total_lanes'] }}</h3>
                    <p class="mb-0 text-muted fw-medium">Total Lanes</p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6">
            <div class="card border-0 text-center h-100" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); transition: transform 0.3s ease, box-shadow 0.3s ease;"
                 onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 20px 40px rgba(0, 0, 0, 0.12)';"
                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(0, 0, 0, 0.08)';">
                <div class="card-body p-4">
                    <div class="mb-3" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); width: 60px; height: 60px; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                        <i class="fas fa-check-circle" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                    <h3 class="fw-bold mb-2" style="color: #1b1b1b;">{{ $stats['operational'] }}</h3>
                    <p class="mb-0 text-muted fw-medium">Operational</p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6">
            <div class="card border-0 text-center h-100" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); transition: transform 0.3s ease, box-shadow 0.3s ease;"
                 onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 20px 40px rgba(0, 0, 0, 0.12)';"
                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(0, 0, 0, 0.08)';">
                <div class="card-body p-4">
                    <div class="mb-3" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); width: 60px; height: 60px; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                        <i class="fas fa-wrench" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                    <h3 class="fw-bold mb-2" style="color: #1b1b1b;">{{ $stats['maintenance'] }}</h3>
                    <p class="mb-0 text-muted fw-medium">Maintenance</p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6">
            <div class="card border-0 text-center h-100" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); transition: transform 0.3s ease, box-shadow 0.3s ease;"
                 onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 20px 40px rgba(0, 0, 0, 0.12)';"
                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(0, 0, 0, 0.08)';">
                <div class="card-body p-4">
                    <div class="mb-3" style="background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%); width: 60px; height: 60px; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                        <i class="fas fa-times-circle" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                    <h3 class="fw-bold mb-2" style="color: #1b1b1b;">{{ $stats['out_of_order'] }}</h3>
                    <p class="mb-0 text-muted fw-medium">Out of Order</p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6">
            <div class="card border-0 text-center h-100" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); transition: transform 0.3s ease, box-shadow 0.3s ease;"
                 onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 20px 40px rgba(0, 0, 0, 0.12)';"
                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(0, 0, 0, 0.08)';">
                <div class="card-body p-4">
                    <div class="mb-3" style="background: linear-gradient(135deg, #6f42c1 0%, #e83e8c 100%); width: 60px; height: 60px; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                        <i class="fas fa-exclamation-triangle" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                    <h3 class="fw-bold mb-2" style="color: #1b1b1b;">{{ $stats['recent_issues'] }}</h3>
                    <p class="mb-0 text-muted fw-medium">Today's Issues</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                <div class="card-header" style="background: transparent; border-bottom: 1px solid rgba(0, 0, 0, 0.05); padding: 1.5rem 1.5rem 0; border-radius: 1.25rem 1.25rem 0 0;">
                    <h5 class="mb-0 fw-bold d-flex align-items-center" style="color: #1b1b1b;">
                        <i class="fas fa-search me-2" style="color: #17a2b8;"></i>
                        Filters & Search
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold mb-2" style="color: #1b1b1b;">Search Lanes</label>
                            <input type="text" class="form-control" wire:model.live="searchTerm" placeholder="Search by lane name..." 
                                   style="border: 2px solid rgba(0, 0, 0, 0.1); border-radius: 1rem; padding: 0.75rem 1rem; font-size: 1rem;"
                                   onfocus="this.style.borderColor='rgba(192, 36, 37, 0.5)'; this.style.boxShadow='0 0 0 0.2rem rgba(192, 36, 37, 0.1)'"
                                   onblur="this.style.borderColor='rgba(0, 0, 0, 0.1)'; this.style.boxShadow='none'">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold mb-2" style="color: #1b1b1b;">Status Filter</label>
                            <select class="form-select" wire:model.live="statusFilter" 
                                    style="border: 2px solid rgba(0, 0, 0, 0.1); border-radius: 1rem; padding: 0.75rem 1rem; font-size: 1rem;"
                                    onfocus="this.style.borderColor='rgba(192, 36, 37, 0.5)'; this.style.boxShadow='0 0 0 0.2rem rgba(192, 36, 37, 0.1)'"
                                    onblur="this.style.borderColor='rgba(0, 0, 0, 0.1)'; this.style.boxShadow='none'">
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
            <div class="card border-0" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                <div class="card-header" style="background: transparent; border-bottom: 1px solid rgba(0, 0, 0, 0.05); padding: 1.5rem 1.5rem 0; border-radius: 1.25rem 1.25rem 0 0;">
                    <h5 class="mb-0 fw-bold d-flex align-items-center" style="color: #1b1b1b;">
                        <i class="fas fa-bowling-ball me-2" style="color: #28a745;"></i>
                        Lanes Overview ({{ count($lanes) }})
                    </h5>
                </div>
                <div class="card-body p-4">
                    @if(count($lanes) > 0)
                        <div class="row g-3">
                            @foreach($lanes as $lane)
                                <div class="col-md-6 col-lg-4">
                                    <div class="card border-0 h-100" style="background: white; border-radius: 1rem; box-shadow: 0 8px 20px rgba(0,0,0,0.1); cursor: pointer; transition: all 0.3s ease;" 
                                         wire:click="viewLaneDetails({{ $lane->id }})"
                                         onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 15px 40px rgba(0,0,0,0.15)'"
                                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.1)'">
                                        <div class="card-body text-center p-4">
                                            <div class="mb-3" style="background: linear-gradient(135deg, 
                                                @if($lane->maintenance_status === 'operational') #28a745, #20c997
                                                @elseif($lane->maintenance_status === 'maintenance') #ffc107, #fd7e14
                                                @else #dc3545, #fd7e14
                                                @endif
                                            ); width: 60px; height: 60px; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto; color: white;">
                                                <i class="fas fa-bowling-ball" style="font-size: 1.5rem;"></i>
                                            </div>
                                            <h5 class="mb-2 fw-bold" style="color: #1b1b1b;">{{ $lane->name }}</h5>
                                            <span class="badge px-3 py-2 mb-3" style="font-size: 0.8rem; border-radius: 1rem; font-weight: 600;
                                                @if($lane->maintenance_status === 'operational') background: rgba(40, 167, 69, 0.2); color: #28a745;
                                                @elseif($lane->maintenance_status === 'maintenance') background: rgba(255, 193, 7, 0.2); color: #ffc107;
                                                @else background: rgba(220, 53, 69, 0.2); color: #dc3545;
                                                @endif
                                            ">
                                                {{ ucfirst(str_replace('_', ' ', $lane->maintenance_status)) }}
                                            </span>
                                            
                                            @if(count($lane->history) > 0)
                                                <div class="mb-3 text-muted small">
                                                    <i class="fas fa-clock me-1"></i>Last issue: {{ $lane->history->first()->created_at->diffForHumans() }}
                                                </div>
                                            @endif
                                            
                                            {{-- Quick Status Change --}}
                                            <div onclick="event.stopPropagation();">
                                                <div class="btn-group btn-group-sm w-100" role="group">
                                                    <button class="btn px-2 py-1" 
                                                            wire:click="updateLaneStatus({{ $lane->id }}, 'operational')"
                                                            style="background: {{ $lane->maintenance_status === 'operational' ? 'rgba(40, 167, 69, 0.2)' : 'rgba(40, 167, 69, 0.1)' }}; color: #28a745; border: 1px solid rgba(40, 167, 69, 0.3); border-radius: 0.5rem 0 0 0.5rem; font-size: 0.8rem; transition: all 0.3s ease;"
                                                            title="Mark as Operational">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                    <button class="btn px-2 py-1" 
                                                            wire:click="updateLaneStatus({{ $lane->id }}, 'maintenance')"
                                                            style="background: {{ $lane->maintenance_status === 'maintenance' ? 'rgba(255, 193, 7, 0.2)' : 'rgba(255, 193, 7, 0.1)' }}; color: #ffc107; border: 1px solid rgba(255, 193, 7, 0.3); font-size: 0.8rem; transition: all 0.3s ease;"
                                                            title="Mark for Maintenance">
                                                        <i class="fas fa-wrench"></i>
                                                    </button>
                                                    <button class="btn px-2 py-1" 
                                                            wire:click="updateLaneStatus({{ $lane->id }}, 'out_of_order')"
                                                            style="background: {{ $lane->maintenance_status === 'out_of_order' ? 'rgba(220, 53, 69, 0.2)' : 'rgba(220, 53, 69, 0.1)' }}; color: #dc3545; border: 1px solid rgba(220, 53, 69, 0.3); border-radius: 0 0.5rem 0.5rem 0; font-size: 0.8rem; transition: all 0.3s ease;"
                                                            title="Mark as Out of Order">
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
                            <i class="fas fa-bowling-ball mb-3" style="font-size: 3rem; color: rgba(40, 167, 69, 0.3);"></i>
                            <h5 class="fw-bold mb-2" style="color: #1b1b1b;">No lanes found</h5>
                            <p class="text-muted mb-0">No lanes found matching your current filters</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Recent Maintenance History --}}
        <div class="col-lg-4">
            <div class="card border-0 h-100" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                <div class="card-header" style="background: transparent; border-bottom: 1px solid rgba(0, 0, 0, 0.05); padding: 1.5rem 1.5rem 0; border-radius: 1.25rem 1.25rem 0 0;">
                    <h5 class="mb-0 fw-bold d-flex align-items-center" style="color: #1b1b1b;">
                        <i class="fas fa-history me-2" style="color: #fd7e14;"></i>
                        Recent Activity
                    </h5>
                </div>
                <div class="card-body p-4" style="max-height: 500px; overflow-y: auto;">
                    @if(count($recentMaintenanceHistory) > 0)
                        @foreach($recentMaintenanceHistory as $history)
                            <div class="d-flex align-items-start p-3 mb-3 rounded-3 {{ !$loop->last ? 'border-bottom' : '' }}" 
                                 style="background: rgba(253, 126, 20, 0.05); border: 1px solid rgba(253, 126, 20, 0.1) !important; transition: all 0.3s ease;"
                                 onmouseover="this.style.backgroundColor='rgba(253, 126, 20, 0.1)'; this.style.transform='translateX(3px)'"
                                 onmouseout="this.style.backgroundColor='rgba(253, 126, 20, 0.05)'; this.style.transform='translateX(0)'">
                                <div class="me-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; background: linear-gradient(135deg, 
                                        @if($history->severity === 'critical') #dc3545, #fd7e14
                                        @elseif($history->severity === 'high') #fd7e14, #ffc107
                                        @elseif($history->severity === 'medium') #ffc107, #28a745
                                        @else #28a745, #20c997
                                        @endif
                                    ); color: white;">
                                        <i class="fas fa-
                                            @if($history->event_type === 'block_break') exclamation-triangle
                                            @elseif($history->event_type === 'axe_break') tools
                                            @elseif($history->event_type === 'status_change') exchange-alt
                                            @else wrench
                                            @endif
                                        " style="font-size: 1rem;"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-semibold" style="color: #1b1b1b; font-size: 0.9rem;">{{ $history->lane->name ?? 'Unknown Lane' }}</h6>
                                    <p class="mb-2 text-muted small">{{ Str::limit($history->description, 60) }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge px-2 py-1" style="font-size: 0.7rem; border-radius: 0.8rem; font-weight: 600;
                                            @if($history->severity === 'critical') background: rgba(220, 53, 69, 0.2); color: #dc3545;
                                            @elseif($history->severity === 'high') background: rgba(253, 126, 20, 0.2); color: #fd7e14;
                                            @elseif($history->severity === 'medium') background: rgba(255, 193, 7, 0.2); color: #ffc107;
                                            @else background: rgba(40, 167, 69, 0.2); color: #28a745;
                                            @endif
                                        ">
                                            {{ ucfirst($history->severity) }}
                                        </span>
                                        <small class="text-muted fw-medium">{{ $history->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-clipboard-list mb-3" style="font-size: 3rem; color: rgba(253, 126, 20, 0.3);"></i>
                            <h5 class="fw-bold mb-2" style="color: #1b1b1b;">No recent activity</h5>
                            <p class="text-muted mb-0">Maintenance activities will appear here once logged</p>
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
                <div class="modal-content" style="border-radius: 1.5rem; border: none; box-shadow: 0 25px 80px rgba(0, 0, 0, 0.15);">
                    <div class="modal-header" style="background: linear-gradient(135deg, #c02425 0%, #d63031 100%); border-radius: 1.5rem 1.5rem 0 0; padding: 2rem;">
                        <h5 class="modal-title text-white fw-bold d-flex align-items-center">
                            <div class="me-3" style="background: rgba(255, 255, 255, 0.2); width: 50px; height: 50px; border-radius: 15px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-bowling-ball" style="font-size: 1.2rem;"></i>
                            </div>
                            {{ $selectedLane->name }} - Details
                        </h5>
                        <button type="button" class="btn-close btn-close-white" wire:click="closeLaneDetails" style="filter: brightness(0) invert(1);"></button>
                    </div>
                    <div class="modal-body" style="padding: 2rem;">
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <div class="p-3 rounded-3" style="background: rgba(248, 249, 250, 0.5);">
                                    <h6 class="fw-bold mb-2" style="color: #1b1b1b;">Current Status</h6>
                                    <span class="badge px-3 py-2" style="font-size: 1rem; border-radius: 1rem; font-weight: 600;
                                        @if($selectedLane->maintenance_status === 'operational') background: rgba(40, 167, 69, 0.2); color: #28a745;
                                        @elseif($selectedLane->maintenance_status === 'maintenance') background: rgba(255, 193, 7, 0.2); color: #ffc107;
                                        @else background: rgba(220, 53, 69, 0.2); color: #dc3545;
                                        @endif
                                    ">
                                        {{ ucfirst(str_replace('_', ' ', $selectedLane->maintenance_status)) }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 rounded-3" style="background: rgba(248, 249, 250, 0.5);">
                                    <h6 class="fw-bold mb-2" style="color: #1b1b1b;">Last Updated</h6>
                                    <span class="text-muted fw-medium">{{ $selectedLane->updated_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>

                        <h6 class="fw-bold mb-3" style="color: #1b1b1b; font-size: 1.2rem;">Recent History</h6>
                        @if(count($selectedLane->history) > 0)
                            <div class="timeline" style="max-height: 400px; overflow-y: auto;">
                                @foreach($selectedLane->history as $history)
                                    <div class="timeline-item mb-3 p-4 rounded-3" style="background: rgba(192, 36, 37, 0.05); border: 1px solid rgba(192, 36, 37, 0.1); border-left: 4px solid #c02425;">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <h6 class="mb-0 fw-semibold" style="color: #1b1b1b;">{{ ucfirst(str_replace('_', ' ', $history->event_type)) }}</h6>
                                            <span class="badge px-3 py-2" style="border-radius: 1rem; font-weight: 600;
                                                @if($history->severity === 'critical') background: rgba(220, 53, 69, 0.2); color: #dc3545;
                                                @elseif($history->severity === 'high') background: rgba(253, 126, 20, 0.2); color: #fd7e14;
                                                @elseif($history->severity === 'medium') background: rgba(23, 162, 184, 0.2); color: #17a2b8;
                                                @else background: rgba(40, 167, 69, 0.2); color: #28a745;
                                                @endif
                                            ">
                                                {{ ucfirst($history->severity) }}
                                            </span>
                                        </div>
                                        <p class="text-muted mb-3">{{ $history->description }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted fw-medium">
                                                @if($history->performer)
                                                    <i class="fas fa-user me-1"></i>By: {{ $history->performer->name }}
                                                @endif
                                            </small>
                                            <small class="text-muted fw-medium">{{ $history->created_at->format('M j, Y H:i') }}</small>
                                        </div>
                                        @if($history->cost)
                                            <div class="mt-3">
                                                <span class="badge px-3 py-2" style="background: rgba(23, 162, 184, 0.2); color: #17a2b8; border-radius: 1rem; font-weight: 600;">
                                                    <i class="fas fa-money-bill me-1"></i>Cost: CHF {{ number_format($history->cost, 2) }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-history mb-3" style="font-size: 3rem; color: rgba(192, 36, 37, 0.3);"></i>
                                <h5 class="fw-bold mb-2" style="color: #1b1b1b;">No maintenance history</h5>
                                <p class="text-muted mb-0">This lane has no recorded maintenance history yet</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
    
    <style>
    .card {
        transition: all 0.3s ease;
        border: none !important;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12) !important;
    }

    .btn-group-sm .btn {
        padding: 0.25rem 0.5rem;
        border: none;
        border-radius: 0.5rem !important;
        margin: 0 1px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-group-sm .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .timeline {
        position: relative;
    }

    .timeline-item {
        position: relative;
        transition: all 0.3s ease;
    }

    .timeline-item:hover {
        transform: translateX(5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .modal-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1040;
        width: 100vw;
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(4px);
    }

    .modal.show {
        z-index: 1050;
    }

    .modal-content {
        border: none !important;
        overflow: hidden;
    }

    .form-control,
    .form-select {
        transition: all 0.3s ease;
        font-weight: 500;
        border: 2px solid rgba(0, 0, 0, 0.1);
        border-radius: 1rem;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: rgba(192, 36, 37, 0.5) !important;
        box-shadow: 0 0 0 0.2rem rgba(192, 36, 37, 0.1) !important;
    }

    .badge {
        font-size: 0.75rem;
        padding: 0.5rem 0.75rem;
        border-radius: 1rem !important;
        font-weight: 600;
        border: none;
    }

    .alert {
        border: none !important;
        border-radius: 1rem !important;
        padding: 1rem 1.5rem;
        font-weight: 500;
    }

    .alert-success {
        background: rgba(40, 167, 69, 0.1);
        color: #28a745;
        border: 1px solid rgba(40, 167, 69, 0.2) !important;
    }

    .btn-close-white {
        filter: brightness(0) invert(1);
    }

    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: rgba(248, 249, 250, 0.8);
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #c02425 0%, #d63031 100%);
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, #a01e20 0%, #b52a2b 100%);
    }

    @media (max-width: 768px) {
        .col-lg-2 {
            margin-bottom: 1rem;
        }
        
        .modal-dialog {
            margin: 1rem;
        }
        
        .modal-header,
        .modal-body {
            padding: 1rem !important;
        }
    }
    </style>
</div>