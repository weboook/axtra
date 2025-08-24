<!-- Lane Summary Stats -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card h-100" style="border: none; border-radius: 12px; background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);">
            <div class="card-body text-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1 fw-bold">{{ $selectedLane->axe_break_count }}</h4>
                        <small class="opacity-75">Axe Breaks</small>
                    </div>
                    <i class="fas fa-hammer fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100" style="border: none; border-radius: 12px; background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);">
            <div class="card-body text-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1 fw-bold">{{ $selectedLane->block_replacement_count }}</h4>
                        <small class="opacity-75">Block Replacements</small>
                    </div>
                    <i class="fas fa-cube fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100" style="border: none; border-radius: 12px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
            <div class="card-body text-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1 fw-bold">CHF {{ number_format($selectedLane->total_maintenance_cost, 2) }}</h4>
                        <small class="opacity-75">Total Costs</small>
                    </div>
                    <i class="fas fa-dollar-sign fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100" style="border: none; border-radius: 12px; background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);">
            <div class="card-body text-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1 fw-bold">{{ floor($selectedLane->total_downtime / 60) }}h {{ $selectedLane->total_downtime % 60 }}m</h4>
                        <small class="opacity-75">Total Downtime</small>
                    </div>
                    <i class="fas fa-clock fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- History Filters -->
<div class="card mb-4" style="border: none; border-radius: 12px; background: #f8f9fa;">
    <div class="card-body p-3">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label fw-semibold text-muted small">Event Type</label>
                <select wire:model.live="historyEventFilter" class="form-select form-select-sm">
                    <option value="">All Events</option>
                    <option value="axe_break">Axe Breaks</option>
                    <option value="block_replacement">Block Replacements</option>
                    <option value="maintenance">Maintenance</option>
                    <option value="damage_report">Damage Reports</option>
                    <option value="repair">Repairs</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold text-muted small">Severity</label>
                <select wire:model.live="historySeverityFilter" class="form-select form-select-sm">
                    <option value="">All Severities</option>
                    <option value="minor">Minor</option>
                    <option value="major">Major</option>
                    <option value="critical">Critical</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold text-muted small">Time Period</label>
                <select wire:model.live="historyDateRange" class="form-select form-select-sm">
                    <option value="7">Last 7 days</option>
                    <option value="30">Last 30 days</option>
                    <option value="90">Last 90 days</option>
                    <option value="365">Last year</option>
                    <option value="all">All time</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold text-muted small">Actions</label>
                <div>
                    <button class="btn btn-sm btn-outline-primary" wire:click="showAddHistory({{ $selectedLane->id }})">
                        <i class="fas fa-plus me-1"></i>Add Entry
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- History Timeline -->
<div class="row">
    <div class="col-12">
        <div class="card" style="border: none; border-radius: 12px;">
            <div class="card-header bg-transparent border-0 p-3">
                <h6 class="mb-0 fw-semibold">
                    <i class="fas fa-history me-2"></i>History Timeline 
                    <span class="badge bg-primary ms-2">{{ $this->getFilteredHistory()->count() }} entries</span>
                </h6>
            </div>
            <div class="card-body p-0">
                @php $filteredHistory = $this->getFilteredHistory(); @endphp
                
                @if($filteredHistory->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead style="background: #f8f9fa;">
                                <tr>
                                    <th class="border-0 ps-3" width="120">Date</th>
                                    <th class="border-0" width="100">Type</th>
                                    <th class="border-0">Description</th>
                                    <th class="border-0" width="80">Severity</th>
                                    <th class="border-0" width="100">Cost</th>
                                    <th class="border-0" width="100">Downtime</th>
                                    <th class="border-0" width="120">Performed By</th>
                                    <th class="border-0 pe-3" width="60">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($filteredHistory as $event)
                                    <tr>
                                        <td class="ps-3">
                                            <div class="fw-semibold small">{{ $event->occurred_at->format('M j, Y') }}</div>
                                            <small class="text-muted">{{ $event->occurred_at->format('H:i') }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $event->event_type_color }}">
                                                <i class="{{ $event->event_type_icon }} me-1"></i>
                                                {{ $event->event_type_display }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="fw-semibold">{{ $event->title }}</div>
                                            @if($event->description)
                                                <small class="text-muted">{{ Str::limit($event->description, 60) }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($event->severity)
                                                <span class="badge bg-{{ $event->severity_color }}">
                                                    {{ ucfirst($event->severity) }}
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($event->cost)
                                                <span class="fw-semibold text-danger">CHF {{ number_format($event->cost, 2) }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($event->downtime_minutes > 0)
                                                <span class="fw-semibold text-warning">{{ $event->downtime_formatted }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($event->performed_by)
                                                <small class="fw-semibold">{{ $event->performed_by }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="pe-3">
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                                        type="button" data-bs-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="#" onclick="showEventDetails({{ $event->id }})">
                                                        <i class="fas fa-eye me-2"></i>View Details
                                                    </a></li>
                                                    @if($event->before_photos || $event->after_photos)
                                                        <li><a class="dropdown-item" href="#" onclick="showEventPhotos({{ $event->id }})">
                                                            <i class="fas fa-images me-2"></i>View Photos
                                                        </a></li>
                                                    @endif
                                                    <li><a class="dropdown-item text-danger" href="#" 
                                                           onclick="if(confirm('Delete this history entry?')) @this.deleteHistoryEntry({{ $event->id }})">
                                                        <i class="fas fa-trash me-2"></i>Delete
                                                    </a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center p-5">
                        <i class="fas fa-history fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No history entries found</h5>
                        <p class="text-muted">No events match your current filters, or this lane has no recorded history yet.</p>
                        <button class="btn btn-primary mt-2" wire:click="showAddHistory({{ $selectedLane->id }})">
                            <i class="fas fa-plus me-1"></i>Add First Entry
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Statistics Section -->
@if($filteredHistory->count() > 0)
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card" style="border: none; border-radius: 12px;">
                <div class="card-header bg-transparent border-0 p-3">
                    <h6 class="mb-0 fw-semibold">
                        <i class="fas fa-chart-pie me-2"></i>Event Breakdown
                    </h6>
                </div>
                <div class="card-body p-3">
                    @php
                        $eventCounts = $filteredHistory->groupBy('event_type')->map->count()->sortDesc();
                    @endphp
                    
                    @foreach($eventCounts as $type => $count)
                        @php
                            $eventTypeDisplay = match($type) {
                                'axe_break' => ['label' => 'Axe Breaks', 'color' => 'danger', 'icon' => 'fas fa-hammer'],
                                'block_replacement' => ['label' => 'Block Replacements', 'color' => 'warning', 'icon' => 'fas fa-cube'],
                                'maintenance' => ['label' => 'Maintenance', 'color' => 'info', 'icon' => 'fas fa-tools'],
                                'damage_report' => ['label' => 'Damage Reports', 'color' => 'danger', 'icon' => 'fas fa-exclamation-triangle'],
                                'repair' => ['label' => 'Repairs', 'color' => 'success', 'icon' => 'fas fa-wrench'],
                                default => ['label' => ucfirst(str_replace('_', ' ', $type)), 'color' => 'secondary', 'icon' => 'fas fa-info-circle']
                            };
                            $percentage = ($count / $filteredHistory->count()) * 100;
                        @endphp
                        
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center">
                                <i class="{{ $eventTypeDisplay['icon'] }} text-{{ $eventTypeDisplay['color'] }} me-2"></i>
                                <span class="fw-semibold">{{ $eventTypeDisplay['label'] }}</span>
                            </div>
                            <span class="badge bg-{{ $eventTypeDisplay['color'] }}">{{ $count }}</span>
                        </div>
                        <div class="progress mb-3" style="height: 8px;">
                            <div class="progress-bar bg-{{ $eventTypeDisplay['color'] }}" 
                                 style="width: {{ $percentage }}%"></div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card" style="border: none; border-radius: 12px;">
                <div class="card-header bg-transparent border-0 p-3">
                    <h6 class="mb-0 fw-semibold">
                        <i class="fas fa-chart-line me-2"></i>Recent Trends
                    </h6>
                </div>
                <div class="card-body p-3">
                    @php
                        $recentEvents = $filteredHistory->where('occurred_at', '>=', now()->subDays(30));
                        $previousEvents = $selectedLane->history()->where('occurred_at', '>=', now()->subDays(60))
                                                                ->where('occurred_at', '<', now()->subDays(30))->get();
                        
                        $recentAxeBreaks = $recentEvents->where('event_type', 'axe_break')->count();
                        $previousAxeBreaks = $previousEvents->where('event_type', 'axe_break')->count();
                        
                        $recentBlockReplacements = $recentEvents->where('event_type', 'block_replacement')->count();
                        $previousBlockReplacements = $previousEvents->where('event_type', 'block_replacement')->count();
                        
                        $recentCosts = $recentEvents->whereNotNull('cost')->sum('cost');
                        $previousCosts = $previousEvents->whereNotNull('cost')->sum('cost');
                    @endphp
                    
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="text-center p-2 rounded" style="background: rgba(220, 53, 69, 0.1);">
                                <div class="fw-bold text-danger">{{ $recentAxeBreaks }}</div>
                                <small class="text-muted">Axe Breaks (30d)</small>
                                @if($previousAxeBreaks > 0)
                                    @php $change = (($recentAxeBreaks - $previousAxeBreaks) / $previousAxeBreaks) * 100; @endphp
                                    <div class="small {{ $change > 0 ? 'text-danger' : 'text-success' }}">
                                        <i class="fas fa-arrow-{{ $change > 0 ? 'up' : 'down' }}"></i>
                                        {{ abs(round($change)) }}%
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="col-6">
                            <div class="text-center p-2 rounded" style="background: rgba(255, 193, 7, 0.1);">
                                <div class="fw-bold text-warning">{{ $recentBlockReplacements }}</div>
                                <small class="text-muted">Block Replace (30d)</small>
                                @if($previousBlockReplacements > 0)
                                    @php $change = (($recentBlockReplacements - $previousBlockReplacements) / $previousBlockReplacements) * 100; @endphp
                                    <div class="small {{ $change > 0 ? 'text-danger' : 'text-success' }}">
                                        <i class="fas fa-arrow-{{ $change > 0 ? 'up' : 'down' }}"></i>
                                        {{ abs(round($change)) }}%
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="col-12 mt-3">
                            <div class="text-center p-2 rounded" style="background: rgba(40, 167, 69, 0.1);">
                                <div class="fw-bold text-success">CHF {{ number_format($recentCosts, 2) }}</div>
                                <small class="text-muted">Maintenance Costs (30d)</small>
                                @if($previousCosts > 0)
                                    @php $change = (($recentCosts - $previousCosts) / $previousCosts) * 100; @endphp
                                    <div class="small {{ $change > 0 ? 'text-danger' : 'text-success' }}">
                                        <i class="fas fa-arrow-{{ $change > 0 ? 'up' : 'down' }}"></i>
                                        {{ abs(round($change)) }}%
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<script>
function showEventDetails(eventId) {
    // Implementation for showing event details in a modal
    console.log('Show details for event:', eventId);
}

function showEventPhotos(eventId) {
    // Implementation for showing event photos in a gallery modal
    console.log('Show photos for event:', eventId);
}
</script>