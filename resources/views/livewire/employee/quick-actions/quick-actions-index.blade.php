{{-- Employee Quick Actions Page --}}
<div>
    <!-- Quick Actions Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0" style="background: linear-gradient(135deg, #c02425 0%, #d63031 100%); color: white; border-radius: 1.5rem; box-shadow: 0 20px 60px rgba(192, 36, 37, 0.3);">
                <div class="card-body py-4 px-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h2 class="mb-2 fw-bold">Quick Actions</h2>
                            <p class="mb-3 opacity-90" style="font-size: 1.1rem;">Manage lane maintenance and report issues quickly</p>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-tools me-2"></i>
                                <span>Keep operations running smoothly with immediate action tools</span>
                            </div>
                        </div>
                        <div class="d-none d-md-block">
                            <i class="fas fa-cogs" style="font-size: 4rem; opacity: 0.3;"></i>
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

    <div class="row g-4">
        {{-- Lane Status Overview --}}
        <div class="col-12 col-lg-4">
            <div class="card border-0 h-100" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); transition: transform 0.3s ease, box-shadow 0.3s ease;"
                 onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 20px 40px rgba(0, 0, 0, 0.12)';"
                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(0, 0, 0, 0.08)';">
                <div class="card-header" style="background: transparent; border-bottom: 1px solid rgba(0, 0, 0, 0.05); padding: 1.5rem 1.5rem 0; border-radius: 1.25rem 1.25rem 0 0;">
                    <h5 class="mb-0 fw-bold d-flex align-items-center" style="color: #1b1b1b;">
                        <i class="fas fa-bowling-ball me-2" style="color: #28a745;"></i>
                        Lane Status
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        @foreach($lanes->groupBy('maintenance_status') as $status => $statusLanes)
                            <div class="col-6">
                                <div class="card border-0 text-center p-3" style="background: rgba(40, 167, 69, 0.05); border-radius: 1rem; border: 1px solid rgba(40, 167, 69, 0.1) !important;">
                                    <div class="mb-2" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto; color: white;">
                                        <i class="fas fa-{{ $status === 'operational' ? 'check' : ($status === 'maintenance' ? 'wrench' : 'exclamation-triangle') }}"></i>
                                    </div>
                                    <h4 class="fw-bold mb-1" style="color: #1b1b1b;">{{ $statusLanes->count() }}</h4>
                                    <small class="text-muted fw-medium">{{ ucfirst(str_replace('_', ' ', $status)) }}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick Action Cards --}}
        <div class="col-12 col-lg-8">
            <div class="row g-3">
                {{-- Block Break --}}
                <div class="col-md-4">
                    <div class="card border-0 text-center h-100" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); cursor: pointer; transition: all 0.3s ease;"
                         wire:click="showMaintenanceDialog('block_break')"
                         onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 25px 50px rgba(220, 53, 69, 0.25)';"
                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(0, 0, 0, 0.08)';">
                        <div class="card-body d-flex flex-column justify-content-center p-4">
                            <div class="mb-3" style="background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%); width: 80px; height: 80px; border-radius: 25px; display: flex; align-items: center; justify-content: center; margin: 0 auto; color: white;">
                                <i class="fas fa-exclamation-triangle" style="font-size: 2rem;"></i>
                            </div>
                            <h5 class="card-title fw-bold mb-2" style="color: #1b1b1b;">Block Break</h5>
                            <p class="card-text text-muted mb-0">Report block/pin issues</p>
                            <small class="text-muted mt-1">Critical maintenance</small>
                        </div>
                    </div>
                </div>

                {{-- Axe Break --}}
                <div class="col-md-4">
                    <div class="card border-0 text-center h-100" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); cursor: pointer; transition: all 0.3s ease;"
                         wire:click="showMaintenanceDialog('axe_break')"
                         onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 25px 50px rgba(253, 126, 20, 0.25)';"
                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(0, 0, 0, 0.08)';">
                        <div class="card-body d-flex flex-column justify-content-center p-4">
                            <div class="mb-3" style="background: linear-gradient(135deg, #fd7e14 0%, #ffc107 100%); width: 80px; height: 80px; border-radius: 25px; display: flex; align-items: center; justify-content: center; margin: 0 auto; color: white;">
                                <i class="fas fa-tools" style="font-size: 2rem;"></i>
                            </div>
                            <h5 class="card-title fw-bold mb-2" style="color: #1b1b1b;">Axe Break</h5>
                            <p class="card-text text-muted mb-0">Report axe/machinery issues</p>
                            <small class="text-muted mt-1">Equipment repair</small>
                        </div>
                    </div>
                </div>

                {{-- General Maintenance --}}
                <div class="col-md-4">
                    <div class="card border-0 text-center h-100" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); cursor: pointer; transition: all 0.3s ease;"
                         wire:click="showMaintenanceDialog('routine_maintenance')"
                         onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 25px 50px rgba(23, 162, 184, 0.25)';"
                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(0, 0, 0, 0.08)';">
                        <div class="card-body d-flex flex-column justify-content-center p-4">
                            <div class="mb-3" style="background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%); width: 80px; height: 80px; border-radius: 25px; display: flex; align-items: center; justify-content: center; margin: 0 auto; color: white;">
                                <i class="fas fa-wrench" style="font-size: 2rem;"></i>
                            </div>
                            <h5 class="card-title fw-bold mb-2" style="color: #1b1b1b;">Maintenance</h5>
                            <p class="card-text text-muted mb-0">Routine maintenance tasks</p>
                            <small class="text-muted mt-1">Preventive care</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Reports --}}
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                <div class="card-header" style="background: transparent; border-bottom: 1px solid rgba(0, 0, 0, 0.05); padding: 1.5rem 1.5rem 0; border-radius: 1.25rem 1.25rem 0 0;">
                    <h5 class="mb-0 fw-bold d-flex align-items-center" style="color: #1b1b1b;">
                        <i class="fas fa-history me-2" style="color: #fd7e14;"></i>
                        Recent Reports
                    </h5>
                </div>
                <div class="card-body p-4">
                    @if($recentReports->count() > 0)
                        <div class="table-responsive" style="border-radius: 1rem; overflow: hidden;">
                            <table class="table mb-0" style="border-collapse: separate; border-spacing: 0;">
                                <thead style="background: rgba(248, 249, 250, 0.8);">
                                    <tr>
                                        <th class="fw-bold py-3" style="color: #1b1b1b; border: none;">Lane</th>
                                        <th class="fw-bold py-3" style="color: #1b1b1b; border: none;">Type</th>
                                        <th class="fw-bold py-3" style="color: #1b1b1b; border: none;">Description</th>
                                        <th class="fw-bold py-3" style="color: #1b1b1b; border: none;">Severity</th>
                                        <th class="fw-bold py-3" style="color: #1b1b1b; border: none;">Date</th>
                                        <th class="fw-bold py-3" style="color: #1b1b1b; border: none;">Cost</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentReports as $report)
                                        <tr style="transition: background-color 0.2s ease;" onmouseover="this.style.backgroundColor='rgba(248, 249, 250, 0.5)'" onmouseout="this.style.backgroundColor='transparent'">
                                            <td class="py-3" style="border: none;">
                                                <span class="badge px-3 py-2" style="background: rgba(192, 36, 37, 0.1); color: #c02425; font-size: 0.75rem; border-radius: 1rem;">{{ $report->lane->name }}</span>
                                            </td>
                                            <td class="py-3" style="border: none;">
                                                <span class="text-capitalize fw-medium" style="color: #1b1b1b;">{{ str_replace('_', ' ', $report->event_type) }}</span>
                                            </td>
                                            <td class="py-3" style="border: none;">
                                                <span class="text-truncate text-muted" style="max-width: 200px; display: inline-block;">
                                                    {{ $report->description }}
                                                </span>
                                            </td>
                                            <td class="py-3" style="border: none;">
                                                <span class="badge px-3 py-2" style="font-size: 0.75rem; border-radius: 1rem;
                                                    @if($report->severity === 'critical') background: rgba(220, 53, 69, 0.2); color: #dc3545;
                                                    @elseif($report->severity === 'high') background: rgba(255, 193, 7, 0.2); color: #ffc107;
                                                    @elseif($report->severity === 'medium') background: rgba(23, 162, 184, 0.2); color: #17a2b8;
                                                    @else background: rgba(40, 167, 69, 0.2); color: #28a745;
                                                    @endif
                                                ">
                                                    {{ ucfirst($report->severity) }}
                                                </span>
                                            </td>
                                            <td class="py-3 text-muted" style="border: none;">{{ $report->created_at->format('M j, Y H:i') }}</td>
                                            <td class="py-3 fw-medium" style="border: none; color: #1b1b1b;">
                                                @if($report->cost)
                                                    CHF {{ number_format($report->cost, 2) }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-clipboard-list mb-3" style="font-size: 3rem; color: rgba(253, 126, 20, 0.3);"></i>
                            <h5 class="fw-bold mb-2" style="color: #1b1b1b;">No maintenance reports yet</h5>
                            <p class="text-muted mb-0">Start reporting maintenance issues to see them here</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Maintenance Modal --}}
    <div class="modal fade @if($showMaintenanceModal) show @endif" @if($showMaintenanceModal) style="display: block;" @endif tabindex="-1" wire:ignore.self>
        <div class="modal-backdrop fade @if($showMaintenanceModal) show @endif"></div>
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="border-radius: 1.5rem; border: none; box-shadow: 0 25px 80px rgba(0, 0, 0, 0.15);">
                <div class="modal-header" style="background: linear-gradient(135deg, #c02425 0%, #d63031 100%); border-radius: 1.5rem 1.5rem 0 0; padding: 2rem;">
                    <h5 class="modal-title text-white fw-bold d-flex align-items-center">
                        <div class="me-3" style="background: rgba(255, 255, 255, 0.2); width: 50px; height: 50px; border-radius: 15px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-wrench" style="font-size: 1.2rem;"></i>
                        </div>
                        Report Maintenance Issue
                    </h5>
                    <button type="button" class="btn-close btn-close-white" wire:click="closeModals" style="filter: brightness(0) invert(1);"></button>
                </div>
                <div class="modal-body" style="padding: 2rem;">
                    <form wire:submit.prevent="submitMaintenance">
                        <div class="row g-4">
                            {{-- Lane Selection --}}
                            <div class="col-12">
                                <label class="form-label fw-bold mb-3" style="color: #1b1b1b; font-size: 1.1rem;">Select Lanes <span class="text-danger">*</span></label>
                                <div class="row g-2">
                                    @foreach($lanes as $lane)
                                        <div class="col-4 col-md-3">
                                            <div class="form-check p-3 rounded-3" style="background: rgba(248, 249, 250, 0.5); border: 2px solid transparent; transition: all 0.3s ease;" 
                                                 onmouseover="this.style.backgroundColor='rgba(192, 36, 37, 0.05)'; this.style.borderColor='rgba(192, 36, 37, 0.2)'" 
                                                 onmouseout="this.style.backgroundColor='rgba(248, 249, 250, 0.5)'; this.style.borderColor='transparent'">
                                                <input class="form-check-input" type="checkbox" wire:model="selectedLanes" value="{{ $lane->id }}" id="lane{{ $lane->id }}" style="margin-top: 0.2rem;">
                                                <label class="form-check-label fw-medium ms-2" for="lane{{ $lane->id }}" style="color: #1b1b1b; cursor: pointer;">
                                                    {{ $lane->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @error('selectedLanes') <div class="text-danger small mt-2 fw-medium">{{ $message }}</div> @enderror
                            </div>

                            {{-- Description --}}
                            <div class="col-12">
                                <label class="form-label fw-bold mb-2" style="color: #1b1b1b; font-size: 1.1rem;">Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" wire:model="description" rows="4" placeholder="Describe the maintenance issue..." 
                                          style="border: 2px solid rgba(0, 0, 0, 0.1); border-radius: 1rem; padding: 1rem; font-size: 1rem; resize: vertical;" 
                                          onfocus="this.style.borderColor='rgba(192, 36, 37, 0.5)'; this.style.boxShadow='0 0 0 0.2rem rgba(192, 36, 37, 0.1)'" 
                                          onblur="this.style.borderColor='rgba(0, 0, 0, 0.1)'; this.style.boxShadow='none'"></textarea>
                                @error('description') <div class="text-danger small mt-2 fw-medium">{{ $message }}</div> @enderror
                            </div>

                            {{-- Severity and Downtime --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold mb-2" style="color: #1b1b1b;">Severity</label>
                                <select class="form-select" wire:model="severity" 
                                        style="border: 2px solid rgba(0, 0, 0, 0.1); border-radius: 1rem; padding: 0.75rem 1rem; font-size: 1rem;"
                                        onfocus="this.style.borderColor='rgba(192, 36, 37, 0.5)'; this.style.boxShadow='0 0 0 0.2rem rgba(192, 36, 37, 0.1)'"
                                        onblur="this.style.borderColor='rgba(0, 0, 0, 0.1)'; this.style.boxShadow='none'">
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                    <option value="critical">Critical</option>
                                </select>
                                @error('severity') <div class="text-danger small mt-2 fw-medium">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold mb-2" style="color: #1b1b1b;">Estimated Downtime (minutes)</label>
                                <input type="number" class="form-control" wire:model="estimatedDowntime" placeholder="0" 
                                       style="border: 2px solid rgba(0, 0, 0, 0.1); border-radius: 1rem; padding: 0.75rem 1rem; font-size: 1rem;"
                                       onfocus="this.style.borderColor='rgba(192, 36, 37, 0.5)'; this.style.boxShadow='0 0 0 0.2rem rgba(192, 36, 37, 0.1)'"
                                       onblur="this.style.borderColor='rgba(0, 0, 0, 0.1)'; this.style.boxShadow='none'">
                                @error('estimatedDowntime') <div class="text-danger small mt-2 fw-medium">{{ $message }}</div> @enderror
                            </div>

                            {{-- Cost --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold mb-2" style="color: #1b1b1b;">Estimated Cost (CHF)</label>
                                <input type="number" step="0.01" class="form-control" wire:model="cost" placeholder="0.00" 
                                       style="border: 2px solid rgba(0, 0, 0, 0.1); border-radius: 1rem; padding: 0.75rem 1rem; font-size: 1rem;"
                                       onfocus="this.style.borderColor='rgba(192, 36, 37, 0.5)'; this.style.boxShadow='0 0 0 0.2rem rgba(192, 36, 37, 0.1)'"
                                       onblur="this.style.borderColor='rgba(0, 0, 0, 0.1)'; this.style.boxShadow='none'">
                                @error('cost') <div class="text-danger small mt-2 fw-medium">{{ $message }}</div> @enderror
                            </div>

                            {{-- Photos --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold mb-2" style="color: #1b1b1b;">Before Photo</label>
                                <input type="file" class="form-control" wire:model="beforePhoto" accept="image/*" 
                                       style="border: 2px solid rgba(0, 0, 0, 0.1); border-radius: 1rem; padding: 0.75rem 1rem; font-size: 1rem;"
                                       onfocus="this.style.borderColor='rgba(192, 36, 37, 0.5)'; this.style.boxShadow='0 0 0 0.2rem rgba(192, 36, 37, 0.1)'"
                                       onblur="this.style.borderColor='rgba(0, 0, 0, 0.1)'; this.style.boxShadow='none'">
                                @error('beforePhoto') <div class="text-danger small mt-2 fw-medium">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold mb-2" style="color: #1b1b1b;">After Photo</label>
                                <input type="file" class="form-control" wire:model="afterPhoto" accept="image/*" 
                                       style="border: 2px solid rgba(0, 0, 0, 0.1); border-radius: 1rem; padding: 0.75rem 1rem; font-size: 1rem;"
                                       onfocus="this.style.borderColor='rgba(192, 36, 37, 0.5)'; this.style.boxShadow='0 0 0 0.2rem rgba(192, 36, 37, 0.1)'"
                                       onblur="this.style.borderColor='rgba(0, 0, 0, 0.1)'; this.style.boxShadow='none'">
                                @error('afterPhoto') <div class="text-danger small mt-2 fw-medium">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-3 mt-4 pt-3" style="border-top: 1px solid rgba(0, 0, 0, 0.05);">
                            <button type="button" class="btn px-4 py-2" wire:click="closeModals" 
                                    style="background: rgba(108, 117, 125, 0.1); color: #6c757d; border: 2px solid rgba(108, 117, 125, 0.2); border-radius: 1rem; font-weight: 600; transition: all 0.3s ease;"
                                    onmouseover="this.style.backgroundColor='rgba(108, 117, 125, 0.2)'; this.style.borderColor='rgba(108, 117, 125, 0.3)'"
                                    onmouseout="this.style.backgroundColor='rgba(108, 117, 125, 0.1)'; this.style.borderColor='rgba(108, 117, 125, 0.2)'">Cancel</button>
                            <button type="submit" class="btn px-4 py-2" 
                                    style="background: linear-gradient(135deg, #c02425 0%, #d63031 100%); color: white; border: none; border-radius: 1rem; font-weight: 600; transition: all 0.3s ease;"
                                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(192, 36, 37, 0.3)'"
                                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                <i class="fas fa-save me-2"></i>
                                Submit Report
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Block Break Modal --}}
    <div class="modal fade @if($showBlockBreakModal) show @endif" @if($showBlockBreakModal) style="display: block;" @endif tabindex="-1" wire:ignore.self>
        <div class="modal-backdrop fade @if($showBlockBreakModal) show @endif"></div>
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="border-radius: 16px; border: none;">
                <div class="modal-header" style="background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%); border-radius: 16px 16px 0 0;">
                    <h5 class="modal-title text-white">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Report Block Break
                    </h5>
                    <button type="button" class="btn-close btn-close-white" wire:click="closeModals"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="submitMaintenance">
                        <div class="row g-3">
                            {{-- Lane Selection --}}
                            <div class="col-12">
                                <label class="form-label fw-semibold">Select Affected Lanes <span class="text-danger">*</span></label>
                                <div class="row g-2">
                                    @foreach($lanes as $lane)
                                        <div class="col-4 col-md-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" wire:model="selectedLanes" value="{{ $lane->id }}" id="blockLane{{ $lane->id }}">
                                                <label class="form-check-label" for="blockLane{{ $lane->id }}">
                                                    {{ $lane->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @error('selectedLanes') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            {{-- Description --}}
                            <div class="col-12">
                                <label class="form-label fw-semibold">Block Issue Details <span class="text-danger">*</span></label>
                                <textarea class="form-control" wire:model="description" rows="3" placeholder="Describe the block/pin problem..."></textarea>
                                @error('description') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            {{-- Severity and Downtime --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Severity</label>
                                <select class="form-select" wire:model="severity">
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                    <option value="critical">Critical</option>
                                </select>
                                @error('severity') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Estimated Downtime (minutes)</label>
                                <input type="number" class="form-control" wire:model="estimatedDowntime" placeholder="0">
                                @error('estimatedDowntime') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            {{-- Cost and Photos --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Estimated Repair Cost (CHF)</label>
                                <input type="number" step="0.01" class="form-control" wire:model="cost" placeholder="0.00">
                                @error('cost') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Before Photo</label>
                                <input type="file" class="form-control" wire:model="beforePhoto" accept="image/*">
                                @error('beforePhoto') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">After Photo (if repair attempted)</label>
                                <input type="file" class="form-control" wire:model="afterPhoto" accept="image/*">
                                @error('afterPhoto') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="button" class="btn btn-secondary" wire:click="closeModals">Cancel</button>
                            <button type="submit" class="btn" style="background-color: #dc3545; color: white;">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                Report Block Break
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Axe Break Modal --}}
    <div class="modal fade @if($showAxeBreakModal) show @endif" @if($showAxeBreakModal) style="display: block;" @endif tabindex="-1" wire:ignore.self>
        <div class="modal-backdrop fade @if($showAxeBreakModal) show @endif"></div>
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="border-radius: 16px; border: none;">
                <div class="modal-header" style="background: linear-gradient(135deg, #fd7e14 0%, #ffc107 100%); border-radius: 16px 16px 0 0;">
                    <h5 class="modal-title text-white">
                        <i class="fas fa-tools me-2"></i>
                        Report Axe Break
                    </h5>
                    <button type="button" class="btn-close btn-close-white" wire:click="closeModals"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="submitMaintenance">
                        <div class="row g-3">
                            {{-- Lane Selection --}}
                            <div class="col-12">
                                <label class="form-label fw-semibold">Select Affected Lanes <span class="text-danger">*</span></label>
                                <div class="row g-2">
                                    @foreach($lanes as $lane)
                                        <div class="col-4 col-md-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" wire:model="selectedLanes" value="{{ $lane->id }}" id="axeLane{{ $lane->id }}">
                                                <label class="form-check-label" for="axeLane{{ $lane->id }}">
                                                    {{ $lane->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @error('selectedLanes') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            {{-- Description --}}
                            <div class="col-12">
                                <label class="form-label fw-semibold">Axe/Machinery Issue Details <span class="text-danger">*</span></label>
                                <textarea class="form-control" wire:model="description" rows="3" placeholder="Describe the axe or machinery problem..."></textarea>
                                @error('description') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            {{-- Severity and Downtime --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Severity</label>
                                <select class="form-select" wire:model="severity">
                                    <option value="high">High</option>
                                    <option value="critical">Critical</option>
                                </select>
                                @error('severity') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Estimated Downtime (minutes)</label>
                                <input type="number" class="form-control" wire:model="estimatedDowntime" placeholder="0">
                                @error('estimatedDowntime') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            {{-- Cost and Photos --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Estimated Repair Cost (CHF)</label>
                                <input type="number" step="0.01" class="form-control" wire:model="cost" placeholder="0.00">
                                @error('cost') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Before Photo</label>
                                <input type="file" class="form-control" wire:model="beforePhoto" accept="image/*">
                                @error('beforePhoto') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">After Photo (if repair attempted)</label>
                                <input type="file" class="form-control" wire:model="afterPhoto" accept="image/*">
                                @error('afterPhoto') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="button" class="btn btn-secondary" wire:click="closeModals">Cancel</button>
                            <button type="submit" class="btn" style="background-color: #fd7e14; color: white;">
                                <i class="fas fa-tools me-1"></i>
                                Report Axe Break
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
    .card {
        transition: all 0.3s ease;
        border: none !important;
    }

    .card:hover {
        transform: translateY(-5px) !important;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15) !important;
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

    .table-responsive {
        border-radius: 1rem;
        overflow: hidden;
    }

    .table th,
    .table td {
        border: none !important;
        vertical-align: middle;
    }

    .table thead th {
        background: rgba(248, 249, 250, 0.8) !important;
        font-weight: 700 !important;
        color: #1b1b1b !important;
    }

    .badge {
        font-size: 0.75rem;
        padding: 0.5rem 0.75rem;
        border-radius: 1rem !important;
        font-weight: 600;
    }

    .form-control,
    .form-select {
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: rgba(192, 36, 37, 0.5) !important;
        box-shadow: 0 0 0 0.2rem rgba(192, 36, 37, 0.1) !important;
    }

    .form-check-input:checked {
        background-color: #c02425;
        border-color: #c02425;
    }

    .form-check-input:focus {
        border-color: rgba(192, 36, 37, 0.5);
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(192, 36, 37, 0.1);
    }

    .alert {
        border: none;
        border-radius: 1rem;
        padding: 1rem 1.5rem;
        font-weight: 500;
    }

    .alert-success {
        background: rgba(40, 167, 69, 0.1);
        color: #28a745;
        border: 1px solid rgba(40, 167, 69, 0.2);
    }

    /* Mobile optimizations for employee quick-actions page */
    @media (max-width: 768px) {
        /* Header section mobile */
        .card-body.py-4.px-4 {
            padding: 1.5rem !important;
        }
        
        .card-body h2 {
            font-size: 1.5rem !important;
        }
        
        .card-body p {
            font-size: 1rem !important;
        }
        
        /* Disable hover effects on mobile */
        .card:hover,
        button:hover,
        div[onmouseover]:hover {
            transform: none !important;
            box-shadow: none !important;
        }
        
        /* Success alert mobile */
        .alert {
            margin: 0 8px 16px 8px !important;
            font-size: 0.9rem !important;
        }
        
        /* Lane status and quick actions layout */
        .row.g-4 .col-12.col-lg-4,
        .row.g-4 .col-12.col-lg-8 {
            flex: 0 0 100% !important;
            max-width: 100% !important;
            margin-bottom: 1rem;
        }
        
        .card-body.p-4 {
            padding: 1rem !important;
        }
        
        .card-header {
            padding: 1rem !important;
        }
        
        /* Lane status cards mobile */
        .row.g-3 .col-6 {
            margin-bottom: 1rem;
        }
        
        .card.p-3 {
            padding: 1rem !important;
        }
        
        .card .mb-2 {
            width: 35px !important;
            height: 35px !important;
        }
        
        .card h4 {
            font-size: 1.3rem !important;
        }
        
        /* Quick action cards mobile */
        .col-md-4 {
            flex: 0 0 100% !important;
            max-width: 100% !important;
            margin-bottom: 1rem;
        }
        
        .card-body.d-flex.flex-column {
            padding: 1.5rem !important;
        }
        
        .card .mb-3 {
            width: 70px !important;
            height: 70px !important;
        }
        
        .card .mb-3 i {
            font-size: 1.8rem !important;
        }
        
        .card-title {
            font-size: 1.1rem !important;
        }
        
        .card-text {
            font-size: 0.9rem !important;
        }
        
        /* Recent reports table mobile */
        .table-responsive {
            margin: 0 -8px;
            border-radius: 1rem;
        }
        
        .table {
            min-width: 800px;
        }
        
        .table th,
        .table td {
            padding: 12px 8px !important;
            font-size: 0.85rem !important;
        }
        
        .table th {
            font-size: 0.8rem !important;
        }
        
        .badge {
            font-size: 0.7rem !important;
            padding: 4px 8px !important;
        }
        
        /* Empty state mobile */
        .text-center.py-5 {
            padding: 30px 15px !important;
        }
        
        .text-center .fa-3x,
        .text-center [style*="font-size: 3rem"] {
            font-size: 2rem !important;
        }
        
        .text-center h5 {
            font-size: 1.1rem !important;
        }
        
        /* Modal mobile */
        .modal-dialog {
            margin: 10px !important;
            max-width: calc(100vw - 20px) !important;
        }
        
        .modal-content {
            border-radius: 1rem !important;
        }
        
        .modal-header {
            padding: 1rem !important;
            border-radius: 1rem 1rem 0 0 !important;
        }
        
        .modal-body {
            padding: 1rem !important;
        }
        
        .modal-title {
            font-size: 1.1rem !important;
        }
        
        .modal-header .me-3 {
            width: 40px !important;
            height: 40px !important;
        }
        
        .modal-header .me-3 i {
            font-size: 1rem !important;
        }
        
        /* Form elements mobile */
        .col-4.col-md-3 {
            flex: 0 0 50% !important;
            max-width: 50% !important;
        }
        
        .form-check.p-3 {
            padding: 12px !important;
        }
        
        .form-control,
        .form-select {
            font-size: 0.9rem !important;
            padding: 12px 16px !important;
        }
        
        textarea.form-control {
            min-height: 80px !important;
        }
        
        .col-md-6 {
            margin-bottom: 1rem;
        }
        
        /* Button spacing mobile */
        .d-flex.justify-content-end.gap-3 {
            flex-direction: column !important;
            gap: 0.5rem !important;
        }
        
        .d-flex.justify-content-end.gap-3 .btn {
            width: 100%;
            justify-content: center;
        }
        
        /* Block/Axe modals mobile */
        .d-flex.justify-content-end.gap-2 {
            flex-direction: column !important;
            gap: 0.5rem !important;
        }
        
        .d-flex.justify-content-end.gap-2 .btn {
            width: 100%;
            justify-content: center;
        }
    }

    /* Small mobile screens */
    @media (max-width: 576px) {
        .container-fluid {
            padding-left: 10px !important;
            padding-right: 10px !important;
        }
        
        /* Header more compact */
        .card-body h2 {
            font-size: 1.25rem !important;
        }
        
        .card-body p {
            font-size: 0.9rem !important;
        }
        
        /* Lane status single column */
        .row.g-3 .col-6 {
            flex: 0 0 100% !important;
            max-width: 100% !important;
        }
        
        /* Action cards more compact */
        .card .mb-3 {
            width: 60px !important;
            height: 60px !important;
        }
        
        .card .mb-3 i {
            font-size: 1.5rem !important;
        }
        
        .card-title {
            font-size: 1rem !important;
        }
        
        /* Table more compact */
        .table {
            min-width: 600px;
        }
        
        .table th,
        .table td {
            padding: 8px 4px !important;
            font-size: 0.8rem !important;
        }
        
        /* Form elements single column */
        .col-4.col-md-3 {
            flex: 0 0 100% !important;
            max-width: 100% !important;
        }
        
        /* Modal full screen */
        .modal-dialog {
            margin: 0 !important;
            max-width: 100vw !important;
            height: 100vh !important;
        }
        
        .modal-content {
            height: 100vh !important;
            border-radius: 0 !important;
        }
        
        .modal-header {
            border-radius: 0 !important;
        }
    }

    /* Extra small mobile screens */
    @media (max-width: 480px) {
        /* Most compact layout */
        .card-body h2 {
            font-size: 1.1rem !important;
        }
        
        /* Action cards smallest */
        .card .mb-3 {
            width: 50px !important;
            height: 50px !important;
        }
        
        .card .mb-3 i {
            font-size: 1.25rem !important;
        }
        
        .card-title {
            font-size: 0.9rem !important;
        }
        
        .card-text {
            font-size: 0.8rem !important;
        }
        
        /* Table most compact */
        .table {
            min-width: 500px;
        }
        
        /* Forms most compact */
        .form-control,
        .form-select {
            font-size: 0.85rem !important;
            padding: 10px 12px !important;
        }
    }

    /* Quick-actions specific mobile optimizations */
    @media (max-width: 768px) {
        /* Better touch targets */
        .card[wire\:click] {
            min-height: 120px;
            touch-action: manipulation;
        }
        
        /* Maintenance type colors maintained */
        .bg-danger { background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%) !important; }
        .bg-warning { background: linear-gradient(135deg, #fd7e14 0%, #ffc107 100%) !important; }
        .bg-info { background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%) !important; }
        .bg-success { background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important; }
        
        /* Modal backdrop mobile */
        .modal-backdrop {
            backdrop-filter: blur(2px);
        }
        
        /* Form validation mobile */
        .text-danger.small {
            font-size: 0.75rem !important;
        }
        
        /* File inputs mobile */
        input[type="file"] {
            padding: 8px 12px !important;
        }
        
        /* Severity badges preserved */
        .badge[style*="background: rgba(220, 53, 69"] { background: rgba(220, 53, 69, 0.2) !important; }
        .badge[style*="background: rgba(255, 193, 7"] { background: rgba(255, 193, 7, 0.2) !important; }
        .badge[style*="background: rgba(23, 162, 184"] { background: rgba(23, 162, 184, 0.2) !important; }
        .badge[style*="background: rgba(40, 167, 69"] { background: rgba(40, 167, 69, 0.2) !important; }
    }
    </style>
</div>