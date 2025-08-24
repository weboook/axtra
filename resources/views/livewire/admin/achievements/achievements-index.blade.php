<div class="container-fluid p-4">
    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="border-radius: 12px; border: none;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="border-radius: 12px; border: none;">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1" style="color: #1a1a1a; font-weight: 700;">Achievement Management</h1>
            <p class="text-muted mb-0">Create, manage, and track user achievements and rewards</p>
        </div>
        <button wire:click="showCreateAchievement" class="btn btn-primary d-flex align-items-center" 
                style="background: #c02425; border-color: #c02425; padding: 12px 24px; border-radius: 12px; font-weight: 600;">
            <i class="fas fa-plus me-2"></i>
            Create New Achievement
        </button>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-2">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1 fw-bold">{{ $stats['total'] }}</h4>
                            <small class="opacity-75">Total Achievements</small>
                        </div>
                        <i class="fas fa-trophy fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                <div class="card-body text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1 fw-bold">{{ $stats['active'] }}</h4>
                            <small class="opacity-75">Active</small>
                        </div>
                        <i class="fas fa-check-circle fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);">
                <div class="card-body text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1 fw-bold">{{ $stats['inactive'] }}</h4>
                            <small class="opacity-75">Inactive</small>
                        </div>
                        <i class="fas fa-pause-circle fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #6f42c1 0%, #e83e8c 100%);">
                <div class="card-body text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1 fw-bold">{{ $stats['hidden'] }}</h4>
                            <small class="opacity-75">Hidden</small>
                        </div>
                        <i class="fas fa-eye-slash fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%);">
                <div class="card-body text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1 fw-bold">{{ $stats['earned_total'] }}</h4>
                            <small class="opacity-75">Total Earned</small>
                        </div>
                        <i class="fas fa-medal fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);">
                <div class="card-body text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1 fw-bold">{{ $stats['unique_earners'] }}</h4>
                            <small class="opacity-75">Unique Earners</small>
                        </div>
                        <i class="fas fa-users fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="card" style="border: none; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);">
        <div class="card-header" style="background: white; border-bottom: 1px solid #f1f5f9; border-radius: 16px 16px 0 0; padding: 24px;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1" style="color: #1a1a1a; font-weight: 700; font-size: 1.25rem;">
                        <i class="fas fa-trophy me-2" style="color: #c02425;"></i>All Achievements
                    </h5>
                    <p class="text-muted mb-0" style="font-size: 0.9rem;">Manage achievement types, rewards, and user progress</p>
                </div>
                <div class="d-flex gap-2">
                    <button wire:click="showCreateAchievement" class="btn btn-primary d-flex align-items-center"
                            style="background: #c02425; border-color: #c02425; padding: 10px 20px; border-radius: 10px; font-weight: 600;">
                        <i class="fas fa-plus me-2"></i>
                        New Achievement
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body" style="padding: 24px;">
            <!-- Filters -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="input-group" style="border-radius: 12px; overflow: hidden;">
                        <span class="input-group-text" style="background: #f8f9fa; border: 1px solid #e9ecef; border-right: none;">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" wire:model.debounce.300ms="search" 
                               class="form-control" 
                               style="border-left: none; border-radius: 0 12px 12px 0;"
                               placeholder="Search achievements...">
                    </div>
                </div>
                <div class="col-md-2">
                    <select wire:model="typeFilter" class="form-select" style="border-radius: 12px;">
                        <option value="">All Types</option>
                        <option value="milestone">Milestone</option>
                        <option value="streak">Streak</option>
                        <option value="total">Total</option>
                        <option value="special">Special</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select wire:model="statusFilter" class="form-select" style="border-radius: 12px;">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="hidden">Hidden</option>
                        <option value="visible">Visible</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select wire:model="perPage" class="form-select" style="border-radius: 12px;">
                        <option value="15">15 per page</option>
                        <option value="25">25 per page</option>
                        <option value="50">50 per page</option>
                        <option value="100">100 per page</option>
                    </select>
                </div>
                <div class="col-md-3">
                    @if(!empty($selectedAchievements))
                    <div class="d-flex gap-2">
                        <select wire:model="bulkAction" class="form-select" style="border-radius: 12px;">
                            <option value="">Bulk Actions</option>
                            <option value="activate">Activate</option>
                            <option value="deactivate">Deactivate</option>
                            <option value="show">Make Visible</option>
                            <option value="hide">Hide</option>
                            <option value="delete">Delete</option>
                        </select>
                        <button type="button" wire:click="bulkAction" 
                                class="btn btn-outline-primary"
                                style="border-radius: 10px; font-weight: 500;">
                            Apply
                        </button>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Achievements Table -->
            <div class="table-responsive" style="border-radius: 12px; overflow: hidden;">
                <table class="table table-hover mb-0">
                    <thead style="background: #f8f9fa;">
                        <tr>
                            <th width="30" style="border: none; font-weight: 600; color: #374151; padding: 16px 8px;">
                                <input type="checkbox" class="form-check-input" 
                                       wire:model="selectAll" 
                                       @if(count($selectedAchievements) === $achievements->count() && $achievements->count() > 0) checked @endif>
                            </th>
                            <th width="50" style="border: none; font-weight: 600; color: #374151; padding: 16px 8px;">Preview</th>
                            <th wire:click="sortBy('name')" class="cursor-pointer" style="border: none; font-weight: 600; color: #374151; padding: 16px 8px;">
                                Name
                                @if($sortBy === 'name')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1 text-primary"></i>
                                @endif
                            </th>
                            <th wire:click="sortBy('type')" class="cursor-pointer" style="border: none; font-weight: 600; color: #374151; padding: 16px 8px;">
                                Type
                                @if($sortBy === 'type')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1 text-primary"></i>
                                @endif
                            </th>
                            <th wire:click="sortBy('points_reward')" class="cursor-pointer text-center" style="border: none; font-weight: 600; color: #374151; padding: 16px 8px;">
                                Points
                                @if($sortBy === 'points_reward')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1 text-primary"></i>
                                @endif
                            </th>
                            <th class="text-center" style="border: none; font-weight: 600; color: #374151; padding: 16px 8px;">Earned</th>
                            <th wire:click="sortBy('order')" class="cursor-pointer text-center" style="border: none; font-weight: 600; color: #374151; padding: 16px 8px;">
                                Order
                                @if($sortBy === 'order')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1 text-primary"></i>
                                @endif
                            </th>
                            <th class="text-center" style="border: none; font-weight: 600; color: #374151; padding: 16px 8px;">Status</th>
                            <th class="text-center" style="border: none; font-weight: 600; color: #374151; padding: 16px 8px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($achievements as $achievement)
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 16px 8px; vertical-align: middle;">
                                <input type="checkbox" class="form-check-input" 
                                       wire:model="selectedAchievements" 
                                       value="{{ $achievement->id }}">
                            </td>
                            <td style="padding: 16px 8px; vertical-align: middle;">
                                <div class="d-flex align-items-center justify-content-center" 
                                     style="width: 36px; height: 36px; background: {{ $achievement->color }}15; border: 2px solid {{ $achievement->color }}; border-radius: 10px;">
                                    <i class="{{ $achievement->icon }}" style="color: {{ $achievement->color }}; font-size: 1rem;"></i>
                                </div>
                            </td>
                            <td style="padding: 16px 8px; vertical-align: middle;">
                                <div>
                                    <div class="fw-semibold" style="color: #1f2937; font-size: 0.95rem;">{{ $achievement->name }}</div>
                                    @if($achievement->description)
                                    <small class="text-muted" style="font-size: 0.8rem;">{{ Str::limit($achievement->description, 50) }}</small>
                                    @endif
                                </div>
                            </td>
                            <td style="padding: 16px 8px; vertical-align: middle;">
                                <span class="badge" style="background: {{ $achievement->type === 'milestone' ? '#3b82f6' : ($achievement->type === 'streak' ? '#10b981' : ($achievement->type === 'total' ? '#06b6d4' : '#f59e0b')) }}; color: white; padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 500;">
                                    {{ ucfirst($achievement->type) }}
                                </span>
                            </td>
                            <td class="text-center" style="padding: 16px 8px; vertical-align: middle;">
                                <span class="badge" style="background: #1f2937; color: white; padding: 6px 10px; border-radius: 8px; font-weight: 600;">{{ $achievement->points_reward }}</span>
                            </td>
                            <td class="text-center" style="padding: 16px 8px; vertical-align: middle;">
                                <span class="badge" style="background: #6b7280; color: white; padding: 6px 10px; border-radius: 8px; font-weight: 600;">{{ $achievement->user_achievements_count }}</span>
                            </td>
                            <td class="text-center" style="padding: 16px 8px; vertical-align: middle;">
                                <span class="badge" style="background: #f3f4f6; color: #374151; padding: 6px 10px; border-radius: 8px; font-weight: 600;">{{ $achievement->order }}</span>
                            </td>
                            <td class="text-center" style="padding: 16px 8px; vertical-align: middle;">
                                <div class="d-flex gap-1 justify-content-center flex-wrap">
                                    <span class="badge" style="background: {{ $achievement->is_active ? '#10b981' : '#ef4444' }}; color: white; padding: 4px 8px; border-radius: 12px; font-size: 0.7rem; font-weight: 500;">
                                        {{ $achievement->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                    @if($achievement->is_hidden)
                                    <span class="badge" style="background: #f59e0b; color: white; padding: 4px 8px; border-radius: 12px; font-size: 0.7rem; font-weight: 500;">Hidden</span>
                                    @endif
                                </div>
                            </td>
                            <td class="text-center" style="padding: 16px 8px; vertical-align: middle;">
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown" 
                                            style="border-radius: 8px; border: 1px solid #e5e7eb; padding: 6px 10px;">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" style="border-radius: 12px; border: none; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);">
                                        <li><a class="dropdown-item" href="#" wire:click="showAchievementDetail({{ $achievement->id }})"><i class="fas fa-eye me-2"></i>View Details</a></li>
                                        <li><a class="dropdown-item" href="#" wire:click="showEditAchievement({{ $achievement->id }})"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="#" wire:click="toggleAchievementStatus({{ $achievement->id }})"><i class="fas fa-{{ $achievement->is_active ? 'pause' : 'play' }} me-2"></i>{{ $achievement->is_active ? 'Deactivate' : 'Activate' }}</a></li>
                                        <li><a class="dropdown-item" href="#" wire:click="toggleAchievementVisibility({{ $achievement->id }})"><i class="fas fa-{{ $achievement->is_hidden ? 'eye' : 'eye-slash' }} me-2"></i>{{ $achievement->is_hidden ? 'Show' : 'Hide' }}</a></li>
                                        <li><a class="dropdown-item" href="#" wire:click="duplicateAchievement({{ $achievement->id }})"><i class="fas fa-copy me-2"></i>Duplicate</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#" wire:click="deleteAchievement({{ $achievement->id }})" onclick="return confirm('Are you sure you want to delete this achievement?')"><i class="fas fa-trash me-2"></i>Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5" style="border: none;">
                                <div class="py-4">
                                    <i class="fas fa-trophy fa-3x text-muted mb-3" style="opacity: 0.3;"></i>
                                    <h6 class="text-muted mb-2">No achievements found</h6>
                                    <p class="text-muted mb-3">{{ $search || $typeFilter || $statusFilter ? 'Try adjusting your search or filters' : 'Create your first achievement to get started' }}</p>
                                    @if($search || $typeFilter || $statusFilter)
                                    <button type="button" wire:click="$set('search', '')" 
                                            class="btn btn-outline-primary"
                                            style="border-radius: 10px; font-weight: 500;">
                                        <i class="fas fa-filter me-2"></i>Clear Filters
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($achievements->hasPages())
            <div class="mt-4 d-flex justify-content-center">
                <div style="border-radius: 12px; overflow: hidden;">
                    {{ $achievements->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Include Modals -->
    @include('livewire.admin.achievements.partials.create-modal')
    @include('livewire.admin.achievements.partials.edit-modal')
    @include('livewire.admin.achievements.partials.detail-modal')

    @push('scripts')
    <script>
        // Auto-hide flash messages
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                var alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    var bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });

        // Handle select all checkbox
        document.addEventListener('livewire:load', function() {
            Livewire.on('achievements-updated', function() {
                // Refresh the page data
                @this.call('render');
            });
        });
    </script>
    @endpush
</div>