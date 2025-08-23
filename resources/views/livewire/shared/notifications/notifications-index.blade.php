<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 fw-bold mb-0">Notifications</h2>
        @if($unreadCount > 0)
            <button type="button" class="btn btn-outline-primary btn-sm" wire:click="markAllAsRead">
                <i class="bi bi-check-all me-1"></i>
                Mark All as Read
            </button>
        @endif
    </div>

    <!-- Filter Tabs -->
    <div class="card mb-4">
        <div class="card-body p-3">
            <div class="btn-group w-100" role="group">
                <input type="radio" class="btn-check" name="filter" id="filter-all" wire:model.live="filter" value="all">
                <label class="btn btn-outline-secondary" for="filter-all">
                    All ({{ $totalCount }})
                </label>

                <input type="radio" class="btn-check" name="filter" id="filter-unread" wire:model.live="filter" value="unread">
                <label class="btn btn-outline-secondary" for="filter-unread">
                    Unread ({{ $unreadCount }})
                </label>

                <input type="radio" class="btn-check" name="filter" id="filter-read" wire:model.live="filter" value="read">
                <label class="btn btn-outline-secondary" for="filter-read">
                    Read ({{ $readCount }})
                </label>
            </div>
        </div>
    </div>

    <!-- Notifications List -->
    @if($notifications->count() > 0)
        <div class="space-y-3">
            @foreach($notifications as $notification)
                <div class="card {{ is_null($notification->read_at) ? 'border-primary' : '' }}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    @if(is_null($notification->read_at))
                                        <span class="badge bg-primary">New</span>
                                    @endif
                                    <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                </div>
                                
                                @if(isset($notification->data['title']))
                                    <h6 class="fw-bold mb-1">{{ $notification->data['title'] }}</h6>
                                @endif
                                
                                @if(isset($notification->data['message']))
                                    <p class="mb-2 text-muted">{{ $notification->data['message'] }}</p>
                                @endif
                                
                                @if(isset($notification->data['action_url']))
                                    <a href="{{ $notification->data['action_url'] }}" class="btn btn-sm btn-outline-primary">
                                        View Details
                                    </a>
                                @endif
                            </div>
                            
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    @if(is_null($notification->read_at))
                                        <li>
                                            <button class="dropdown-item" wire:click="markAsRead('{{ $notification->id }}')">
                                                <i class="bi bi-check me-2"></i>Mark as Read
                                            </button>
                                        </li>
                                    @endif
                                    <li>
                                        <button class="dropdown-item text-danger" wire:click="deleteNotification('{{ $notification->id }}')">
                                            <i class="bi bi-trash me-2"></i>Delete
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $notifications->links() }}
        </div>

        @if($readCount > 0)
            <div class="text-center mt-4">
                <button type="button" class="btn btn-outline-danger btn-sm" wire:click="deleteAllRead" 
                        onclick="return confirm('Are you sure you want to delete all read notifications?')">
                    <i class="bi bi-trash me-1"></i>
                    Delete All Read
                </button>
            </div>
        @endif
    @else
        <div class="text-center py-5">
            <i class="bi bi-bell display-1 text-muted mb-3"></i>
            <h5 class="text-muted">No notifications found</h5>
            <p class="text-muted">
                @if($filter === 'unread')
                    You have no unread notifications.
                @elseif($filter === 'read')
                    You have no read notifications.
                @else
                    You don't have any notifications yet.
                @endif
            </p>
        </div>
    @endif
</div>