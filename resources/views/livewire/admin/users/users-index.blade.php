<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1" style="color: #1a1a1a; font-weight: 700;">User Management</h1>
            <p class="text-muted mb-0">Manage user accounts, roles, and permissions</p>
        </div>
        <button wire:click="showCreateUser" class="btn btn-primary d-flex align-items-center" 
                style="background: #c02425; border-color: #c02425; padding: 12px 24px; border-radius: 12px; font-weight: 600;">
            <i class="fas fa-plus me-2"></i>
            Add New User
        </button>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-2">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1 fw-bold">{{ $stats['total'] }}</h3>
                            <small class="opacity-75">Total Users</small>
                        </div>
                        <div style="background: rgba(255,255,255,0.2); width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #c02425 0%, #e74c3c 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1 fw-bold">{{ $stats['admins'] }}</h3>
                            <small class="opacity-75">Admins</small>
                        </div>
                        <div style="background: rgba(255,255,255,0.2); width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-crown"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1 fw-bold">{{ $stats['employees'] }}</h3>
                            <small class="opacity-75">Employees</small>
                        </div>
                        <div style="background: rgba(255,255,255,0.2); width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-user-tie"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1 fw-bold">{{ $stats['customers'] }}</h3>
                            <small class="opacity-75">Customers</small>
                        </div>
                        <div style="background: rgba(255,255,255,0.2); width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1 fw-bold">{{ $stats['banned'] }}</h3>
                            <small class="opacity-75">Banned</small>
                        </div>
                        <div style="background: rgba(255,255,255,0.2); width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-ban"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #6c757d 0%, #495057 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1 fw-bold">{{ $stats['hidden_from_leaderboard'] }}</h3>
                            <small class="opacity-75">Hidden</small>
                        </div>
                        <div style="background: rgba(255,255,255,0.2); width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-eye-slash"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="card mb-4" style="border: none; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-muted small">Search Users</label>
                    <div class="input-group">
                        <span class="input-group-text border-0" style="background: #f8f9fa;"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" wire:model.live.debounce.300ms="search" class="form-control border-start-0" 
                               placeholder="Name, email, or phone..." style="background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 0 8px 8px 0;">
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold text-muted small">Role</label>
                    <select wire:model.live="roleFilter" class="form-select" style="border-radius: 8px;">
                        <option value="">All Roles</option>
                        <option value="admin">Admin</option>
                        <option value="employee">Employee</option>
                        <option value="customer">Customer</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold text-muted small">Status</label>
                    <select wire:model.live="statusFilter" class="form-select" style="border-radius: 8px;">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="banned">Banned</option>
                        <option value="hidden_leaderboard">Hidden from Leaderboard</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold text-muted small">Per Page</label>
                    <select wire:model.live="perPage" class="form-select" style="border-radius: 8px;">
                        <option value="15">15</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold text-muted small">Bulk Actions</label>
                    <div class="input-group">
                        <select wire:model="bulkAction" class="form-select" style="border-radius: 8px 0 0 8px;">
                            <option value="">Choose action...</option>
                            <option value="ban">Ban Users</option>
                            <option value="unban">Unban Users</option>
                            <option value="hide_leaderboard">Hide from Leaderboard</option>
                            <option value="show_leaderboard">Show on Leaderboard</option>
                            <option value="delete">Delete Users</option>
                        </select>
                        <button wire:click="bulkAction" class="btn btn-outline-primary" 
                                style="border-radius: 0 8px 8px 0;" @if(empty($selectedUsers) || !$bulkAction) disabled @endif>
                            Apply
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card" style="border: none; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
        <div class="card-header bg-transparent border-0 p-4">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-semibold">Users ({{ $users->total() }})</h5>
                @if(count($selectedUsers) > 0)
                    <span class="badge bg-primary">{{ count($selectedUsers) }} selected</span>
                @endif
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background: #f8f9fa;">
                        <tr>
                            <th class="border-0 ps-4">
                                <input type="checkbox" class="form-check-input" 
                                       id="selectAll"
                                       @if(count($selectedUsers) === $users->count() && $users->count() > 0) checked @endif
                                       onclick="toggleSelectAll(this)">
                            </th>
                            <th class="border-0 fw-semibold" style="color: #6c757d;">
                                <button wire:click="sortBy('name')" class="btn btn-sm btn-link text-decoration-none p-0" style="color: #6c757d;">
                                    User @if($sortBy === 'name') <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i> @endif
                                </button>
                            </th>
                            <th class="border-0 fw-semibold" style="color: #6c757d;">Role</th>
                            <th class="border-0 fw-semibold" style="color: #6c757d;">Status</th>
                            <th class="border-0 fw-semibold" style="color: #6c757d;">
                                <button wire:click="sortBy('skill_points')" class="btn btn-sm btn-link text-decoration-none p-0" style="color: #6c757d;">
                                    Points @if($sortBy === 'skill_points') <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i> @endif
                                </button>
                            </th>
                            <th class="border-0 fw-semibold" style="color: #6c757d;">
                                <button wire:click="sortBy('total_bookings')" class="btn btn-sm btn-link text-decoration-none p-0" style="color: #6c757d;">
                                    Bookings @if($sortBy === 'total_bookings') <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i> @endif
                                </button>
                            </th>
                            <th class="border-0 fw-semibold" style="color: #6c757d;">
                                <button wire:click="sortBy('created_at')" class="btn btn-sm btn-link text-decoration-none p-0" style="color: #6c757d;">
                                    Joined @if($sortBy === 'created_at') <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i> @endif
                                </button>
                            </th>
                            <th class="border-0 pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr style="border-bottom: 1px solid #f0f0f0;">
                                <td class="ps-4">
                                    <input type="checkbox" class="form-check-input" 
                                           wire:model="selectedUsers" 
                                           value="{{ $user->id }}"
                                           @if($user->id === auth()->id()) disabled @endif>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <img src="{{ $user->profile_photo_url }}" 
                                                 class="rounded-circle" 
                                                 width="40" height="40"
                                                 alt="{{ $user->name }}"
                                                 style="object-fit: cover;">
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-dark">{{ $user->name }}</div>
                                            <small class="text-muted">{{ $user->email }}</small>
                                            @if($user->phone)
                                                <br><small class="text-muted">{{ $user->phone }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <span class="badge dropdown-toggle" 
                                              data-bs-toggle="dropdown" 
                                              data-bs-boundary="viewport"
                                              style="background: {{ $user->role === 'admin' ? '#c02425' : ($user->role === 'employee' ? '#17a2b8' : '#28a745') }}; cursor: pointer;">
                                            @if($user->role === 'admin') 
                                                <i class="fas fa-crown me-1"></i>
                                            @elseif($user->role === 'employee')
                                                <i class="fas fa-user-tie me-1"></i>
                                            @else
                                                <i class="fas fa-user me-1"></i>
                                            @endif
                                            {{ ucfirst($user->role) }}
                                        </span>
                                        @if($user->id !== auth()->id())
                                            <ul class="dropdown-menu" style="z-index: 1050;">
                                                <li><a class="dropdown-item" href="#" wire:click="updateUserRole({{ $user->id }}, 'admin')">
                                                    <i class="fas fa-crown me-2"></i>Admin
                                                </a></li>
                                                <li><a class="dropdown-item" href="#" wire:click="updateUserRole({{ $user->id }}, 'employee')">
                                                    <i class="fas fa-user-tie me-2"></i>Employee
                                                </a></li>
                                                <li><a class="dropdown-item" href="#" wire:click="updateUserRole({{ $user->id }}, 'customer')">
                                                    <i class="fas fa-user me-2"></i>Customer
                                                </a></li>
                                            </ul>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column gap-1">
                                        @if($user->is_banned)
                                            <span class="badge bg-danger">
                                                <i class="fas fa-ban me-1"></i>Banned
                                            </span>
                                        @else
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle me-1"></i>Active
                                            </span>
                                        @endif
                                        @if($user->hidden_from_leaderboard)
                                            <span class="badge bg-secondary">
                                                <i class="fas fa-eye-slash me-1"></i>Hidden
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <strong class="text-primary">{{ number_format($user->skill_points ?? 0) }}</strong>
                                        <button wire:click="showPointsModal({{ $user->id }})" 
                                                class="btn btn-sm btn-outline-primary ms-2"
                                                style="padding: 2px 8px; font-size: 0.75rem;">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                    @if($user->skill_level)
                                        <small class="text-muted">{{ ucfirst($user->skill_level) }}</small>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ number_format($user->total_bookings ?? 0) }}</strong>
                                    @if($user->total_spent)
                                        <br><small class="text-muted">CHF {{ number_format($user->total_spent, 2) }}</small>
                                    @endif
                                </td>
                                <td>
                                    <div>{{ $user->created_at->format('M d, Y') }}</div>
                                    <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                                </td>
                                <td class="pe-4">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                                type="button" data-bs-toggle="dropdown"
                                                data-bs-boundary="viewport">
                                            <i class="fas fa-cog"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" style="z-index: 1050;">
                                            <li><a class="dropdown-item" href="#" wire:click="showUserDetail({{ $user->id }})">
                                                <i class="fas fa-eye me-2"></i>View Details
                                            </a></li>
                                            <li><a class="dropdown-item" href="#" wire:click="showEditUser({{ $user->id }})">
                                                <i class="fas fa-edit me-2"></i>Edit User
                                            </a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item" href="#" wire:click="toggleUserBan({{ $user->id }})">
                                                <i class="fas fa-{{ $user->is_banned ? 'check' : 'ban' }} me-2"></i>
                                                {{ $user->is_banned ? 'Unban User' : 'Ban User' }}
                                            </a></li>
                                            <li><a class="dropdown-item" href="#" wire:click="toggleLeaderboardVisibility({{ $user->id }})">
                                                <i class="fas fa-{{ $user->hidden_from_leaderboard ? 'eye' : 'eye-slash' }} me-2"></i>
                                                {{ $user->hidden_from_leaderboard ? 'Show on' : 'Hide from' }} Leaderboard
                                            </a></li>
                                            <li><a class="dropdown-item" href="#" wire:click="showPointsModal({{ $user->id }})">
                                                <i class="fas fa-star me-2"></i>Manage Points
                                            </a></li>
                                            @if($user->id !== auth()->id())
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger" href="#" 
                                                       wire:click="deleteUser({{ $user->id }})"
                                                       onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                                    <i class="fas fa-trash me-2"></i>Delete User
                                                </a></li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center p-5">
                                    <div class="text-muted">
                                        <i class="fas fa-users fa-3x mb-3"></i>
                                        <h5>No users found</h5>
                                        <p>Try adjusting your search criteria or filters</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($users->hasPages())
                <div class="card-footer bg-transparent border-0 p-4">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Create User Modal -->
    @if($showCreateModal)
        @livewire('admin.users.user-create')
    @endif

    <!-- Edit User Modal -->
    @if($showEditModal && $selectedUser)
        @livewire('admin.users.user-edit', ['userId' => $selectedUser->id])
    @endif

    <!-- User Detail Modal -->
    @if($showDetailModal && $selectedUser)
        <div class="modal fade show" style="display: block; background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" style="border-radius: 16px;">
                    <div class="modal-header border-0 p-4">
                        <h5 class="modal-title fw-bold">User Details</h5>
                        <button type="button" class="btn-close" wire:click="closeModals"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row">
                            <div class="col-md-4 text-center mb-4">
                                <img src="{{ $selectedUser->profile_photo_url }}" 
                                     class="rounded-circle mb-3" 
                                     width="120" height="120"
                                     style="object-fit: cover;">
                                <h5>{{ $selectedUser->name }}</h5>
                                <span class="badge" style="background: {{ $selectedUser->role === 'admin' ? '#c02425' : ($selectedUser->role === 'employee' ? '#17a2b8' : '#28a745') }};">
                                    {{ ucfirst($selectedUser->role) }}
                                </span>
                            </div>
                            <div class="col-md-8">
                                <div class="row g-3">
                                    <div class="col-6">
                                        <label class="text-muted small">Email</label>
                                        <div class="fw-semibold">{{ $selectedUser->email }}</div>
                                    </div>
                                    <div class="col-6">
                                        <label class="text-muted small">Phone</label>
                                        <div class="fw-semibold">{{ $selectedUser->phone ?? 'N/A' }}</div>
                                    </div>
                                    <div class="col-6">
                                        <label class="text-muted small">Skill Points</label>
                                        <div class="fw-semibold">{{ number_format($selectedUser->skill_points ?? 0) }}</div>
                                    </div>
                                    <div class="col-6">
                                        <label class="text-muted small">Skill Level</label>
                                        <div class="fw-semibold">{{ ucfirst($selectedUser->skill_level ?? 'Beginner') }}</div>
                                    </div>
                                    <div class="col-6">
                                        <label class="text-muted small">Total Bookings</label>
                                        <div class="fw-semibold">{{ number_format($selectedUser->total_bookings ?? 0) }}</div>
                                    </div>
                                    <div class="col-6">
                                        <label class="text-muted small">Total Spent</label>
                                        <div class="fw-semibold">CHF {{ number_format($selectedUser->total_spent ?? 0, 2) }}</div>
                                    </div>
                                    <div class="col-6">
                                        <label class="text-muted small">Member Since</label>
                                        <div class="fw-semibold">{{ $selectedUser->created_at->format('M d, Y') }}</div>
                                    </div>
                                    <div class="col-6">
                                        <label class="text-muted small">Last Activity</label>
                                        <div class="fw-semibold">{{ $selectedUser->last_activity ? $selectedUser->last_activity->diffForHumans() : 'N/A' }}</div>
                                    </div>
                                    @if($selectedUser->is_banned)
                                        <div class="col-12">
                                            <div class="alert alert-danger">
                                                <strong>User is Banned</strong><br>
                                                Reason: {{ $selectedUser->ban_reason ?? 'No reason provided' }}<br>
                                                Banned on: {{ $selectedUser->banned_at?->format('M d, Y g:i A') }}<br>
                                                Banned by: {{ $selectedUser->bannedBy?->name ?? 'System' }}
                                            </div>
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

    <!-- Ban User Modal -->
    @if($showBanModal && $selectedUser)
        <div class="modal fade show" style="display: block; background: rgba(0,0,0,0.5);">
            <div class="modal-dialog">
                <div class="modal-content" style="border-radius: 16px;">
                    <div class="modal-header border-0 p-4">
                        <h5 class="modal-title fw-bold text-danger">Ban User</h5>
                        <button type="button" class="btn-close" wire:click="closeModals"></button>
                    </div>
                    <div class="modal-body p-4">
                        <p>Are you sure you want to ban <strong>{{ $selectedUser->name }}</strong>?</p>
                        <div class="mb-3">
                            <label class="form-label">Reason for Ban</label>
                            <textarea wire:model="banReason" class="form-control" rows="3" 
                                      placeholder="Enter reason for banning this user..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4">
                        <button type="button" class="btn btn-secondary" wire:click="closeModals">Cancel</button>
                        <button type="button" class="btn btn-danger" wire:click="banUser">Ban User</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Points Management Modal -->
    @if($showPointsModal && $selectedUser)
        <div class="modal fade show" style="display: block; background: rgba(0,0,0,0.5);">
            <div class="modal-dialog">
                <div class="modal-content" style="border-radius: 16px;">
                    <div class="modal-header border-0 p-4">
                        <h5 class="modal-title fw-bold">Manage Points</h5>
                        <button type="button" class="btn-close" wire:click="closeModals"></button>
                    </div>
                    <div class="modal-body p-4">
                        <p>Manage skill points for <strong>{{ $selectedUser->name }}</strong></p>
                        <p class="text-muted">Current Points: <strong>{{ number_format($selectedUser->skill_points ?? 0) }}</strong></p>
                        
                        <div class="mb-3">
                            <label class="form-label">Points to Add/Remove</label>
                            <input type="number" wire:model="pointsToAdd" class="form-control" 
                                   placeholder="Enter positive number to add, negative to remove">
                            <small class="text-muted">Use negative numbers to remove points</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Reason (Optional)</label>
                            <input type="text" wire:model="pointsReason" class="form-control" 
                                   placeholder="Admin adjustment, bonus points, etc.">
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4">
                        <button type="button" class="btn btn-secondary" wire:click="closeModals">Cancel</button>
                        <button type="button" class="btn btn-primary" wire:click="addPoints" 
                                @if($pointsToAdd == 0) disabled @endif>
                            Update Points
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('styles')
<style>
    /* Ensure dropdowns appear above the table container */
    .table-responsive {
        overflow-x: auto;
        overflow-y: visible;
    }
    
    .dropdown-menu {
        z-index: 1050 !important;
    }
    
    /* Prevent dropdown from being clipped */
    .table-responsive .dropdown {
        position: static;
    }
    
    .table-responsive .dropdown-menu {
        position: absolute !important;
        z-index: 1050 !important;
    }

    /* Mobile optimizations for admin users page */
    @media (max-width: 768px) {
        /* Header section mobile fixes */
        .d-flex.justify-content-between.align-items-center.mb-4 {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 15px;
        }
        
        .btn.btn-primary {
            width: 100%;
            justify-content: center;
            font-size: 0.9rem !important;
            padding: 12px 20px !important;
        }
        
        /* Stats cards mobile layout */
        .row.mb-4 .col-md-2 {
            flex: 0 0 50% !important;
            max-width: 50% !important;
            margin-bottom: 15px;
        }
        
        .row.mb-4 .col-md-2:nth-child(odd) {
            padding-right: 8px;
        }
        
        .row.mb-4 .col-md-2:nth-child(even) {
            padding-left: 8px;
        }
        
        .card-body h3 {
            font-size: 1.3rem !important;
        }
        
        .card-body small {
            font-size: 0.75rem !important;
        }
        
        /* Filters section mobile layout */
        .card-body.p-4 {
            padding: 16px !important;
        }
        
        .col-md-4,
        .col-md-2 {
            margin-bottom: 15px !important;
        }
        
        .form-label {
            font-size: 0.85rem !important;
            margin-bottom: 6px !important;
        }
        
        .input-group .btn {
            font-size: 0.85rem !important;
        }
        
        /* Table mobile responsiveness */
        .table-responsive {
            border-radius: 12px;
            margin: 0 -8px;
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
        
        /* User info mobile layout */
        .table .d-flex.align-items-center {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 8px;
        }
        
        .table .d-flex.align-items-center .me-3 {
            margin-right: 0 !important;
            margin-bottom: 8px !important;
        }
        
        .table .d-flex.align-items-center img {
            width: 35px !important;
            height: 35px !important;
        }
        
        /* Badge adjustments */
        .badge {
            font-size: 0.7rem !important;
            padding: 4px 8px !important;
        }
        
        .dropdown-toggle {
            font-size: 0.75rem !important;
        }
        
        /* Status column mobile */
        .d-flex.flex-column.gap-1 {
            gap: 4px !important;
        }
        
        /* Points column mobile */
        .d-flex.align-items-center {
            flex-wrap: wrap;
            gap: 4px;
        }
        
        .btn.btn-sm {
            padding: 4px 6px !important;
            font-size: 0.7rem !important;
        }
        
        /* Actions dropdown mobile */
        .dropdown-menu {
            min-width: 200px !important;
        }
        
        .dropdown-item {
            font-size: 0.85rem !important;
            padding: 8px 16px !important;
        }
        
        /* Modal mobile adjustments */
        .modal-dialog {
            margin: 10px !important;
            max-width: calc(100vw - 20px) !important;
        }
        
        .modal-header,
        .modal-body,
        .modal-footer {
            padding: 16px !important;
        }
        
        .modal-title {
            font-size: 1.1rem !important;
        }
        
        /* User detail modal mobile */
        .modal-dialog.modal-lg {
            max-width: calc(100vw - 20px) !important;
        }
        
        .modal-body .row {
            flex-direction: column !important;
        }
        
        .modal-body .col-md-4,
        .modal-body .col-md-8 {
            flex: none !important;
            max-width: 100% !important;
        }
        
        .modal-body .col-md-4 {
            margin-bottom: 20px;
        }
        
        .modal-body .col-6 {
            flex: 0 0 100% !important;
            max-width: 100% !important;
            margin-bottom: 15px;
        }
        
        /* Card footer pagination mobile */
        .card-footer {
            padding: 12px !important;
        }
        
        /* Hide some less important columns on mobile */
        .table th:nth-child(6),
        .table td:nth-child(6),
        .table th:nth-child(7),
        .table td:nth-child(7) {
            display: none;
        }
    }

    /* Small mobile screens */
    @media (max-width: 576px) {
        .container-fluid {
            padding-left: 10px !important;
            padding-right: 10px !important;
        }
        
        /* Full width stats cards on small screens */
        .row.mb-4 .col-md-2 {
            flex: 0 0 100% !important;
            max-width: 100% !important;
            padding: 0 !important;
        }
        
        /* Smaller table text */
        .table th,
        .table td {
            padding: 8px 4px !important;
            font-size: 0.8rem !important;
        }
        
        .table {
            min-width: 600px;
        }
        
        /* Hide more columns on very small screens */
        .table th:nth-child(5),
        .table td:nth-child(5) {
            display: none;
        }
        
        /* Filters stacked vertically */
        .col-md-4,
        .col-md-2 {
            flex: 0 0 100% !important;
            max-width: 100% !important;
        }
        
        /* Modal full screen on small screens */
        .modal-dialog {
            margin: 0 !important;
            max-width: 100vw !important;
            height: 100vh !important;
        }
        
        .modal-content {
            height: 100vh !important;
            border-radius: 0 !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function toggleSelectAll(selectAllCheckbox) {
        const checkboxes = document.querySelectorAll('input[type="checkbox"][wire\\:model="selectedUsers"]');
        
        checkboxes.forEach(checkbox => {
            if (!checkbox.disabled) {
                checkbox.checked = selectAllCheckbox.checked;
                checkbox.dispatchEvent(new Event('change'));
            }
        });
    }

    // Update select all checkbox based on individual selections
    document.addEventListener('livewire:init', () => {
        // Check if all checkboxes are selected
        function updateSelectAllState() {
            const checkboxes = document.querySelectorAll('input[type="checkbox"][wire\\:model="selectedUsers"]:not([disabled])');
            const selectAllCheckbox = document.getElementById('selectAll');
            
            if (checkboxes.length > 0) {
                const checkedCount = Array.from(checkboxes).filter(cb => cb.checked).length;
                selectAllCheckbox.checked = checkedCount === checkboxes.length;
                selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < checkboxes.length;
            }
        }

        // Listen for individual checkbox changes
        document.addEventListener('change', function(e) {
            if (e.target.matches('input[type="checkbox"][wire\\:model="selectedUsers"]')) {
                updateSelectAllState();
            }
        });

        // Update on Livewire updates
        Livewire.hook('morph.updated', () => {
            updateSelectAllState();
        });
    });
</script>
@endpush