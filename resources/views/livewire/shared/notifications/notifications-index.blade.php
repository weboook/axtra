@section('page-title', 'Notifications')

<div>
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0" style="background: linear-gradient(135deg, #6f42c1 0%, #e83e8c 100%); color: white; border-radius: 1.5rem; box-shadow: 0 20px 60px rgba(111, 66, 193, 0.3);">
                <div class="card-body py-4 px-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h2 class="mb-2 fw-bold">Notifications</h2>
                            <p class="mb-3 opacity-90" style="font-size: 1.1rem;">Stay updated with your latest activities</p>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-bell me-2"></i>
                                <span>{{ $totalCount }} total notification{{ $totalCount != 1 ? 's' : '' }}</span>
                                @if($unreadCount > 0)
                                    <span class="mx-2">•</span>
                                    <span class="text-warning">{{ $unreadCount }} unread</span>
                                @endif
                            </div>
                        </div>
                        <div class="d-none d-md-block">
                            <i class="fas fa-bell" style="font-size: 4rem; opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-4 col-sm-6 mb-3">
            <div class="card border-0 h-100" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); transition: transform 0.3s ease;"
                 onmouseover="this.style.transform='translateY(-3px)'"
                 onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body p-4 text-center">
                    <div class="mb-3" style="background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%); width: 60px; height: 60px; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                        <i class="fas fa-inbox" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                    <h3 class="fw-bold mb-2" style="color: #1b1b1b;">{{ $totalCount }}</h3>
                    <p class="mb-0 text-muted fw-medium">Total Notifications</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 mb-3">
            <div class="card border-0 h-100" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); transition: transform 0.3s ease;"
                 onmouseover="this.style.transform='translateY(-3px)'"
                 onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body p-4 text-center">
                    <div class="mb-3" style="background: linear-gradient(135deg, #c02425 0%, #d63031 100%); width: 60px; height: 60px; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                        <i class="fas fa-bell-slash" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                    <h3 class="fw-bold mb-2" style="color: #1b1b1b;">{{ $unreadCount }}</h3>
                    <p class="mb-0 text-muted fw-medium">Unread</p>
                    @if($unreadCount > 0)
                        <small class="text-danger">Needs attention</small>
                    @else
                        <small class="text-success">All caught up!</small>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 mb-3">
            <div class="card border-0 h-100" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); transition: transform 0.3s ease;"
                 onmouseover="this.style.transform='translateY(-3px)'"
                 onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body p-4 text-center">
                    <div class="mb-3" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); width: 60px; height: 60px; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                        <i class="fas fa-check-circle" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                    <h3 class="fw-bold mb-2" style="color: #1b1b1b;">{{ $readCount }}</h3>
                    <p class="mb-0 text-muted fw-medium">Read</p>
                    @if($readCount > 0)
                        <small class="text-success">Processed</small>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Actions -->
    <div class="card border-0 mb-4" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
        <div class="card-header" style="background: transparent; border-bottom: 1px solid rgba(0, 0, 0, 0.05); padding: 1.5rem 1.5rem 0; border-radius: 1.25rem 1.25rem 0 0;">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold d-flex align-items-center" style="color: #1b1b1b;">
                    <i class="fas fa-filter me-2" style="color: #6f42c1;"></i>
                    Filter Notifications
                </h5>
                @if($unreadCount > 0)
                    <button type="button" class="btn btn-sm" wire:click="markAllAsRead"
                            style="background: linear-gradient(135deg, #c02425 0%, #d63031 100%); color: white; border: none; border-radius: 0.75rem; padding: 0.5rem 1rem;">
                        <i class="fas fa-check-double me-1"></i>
                        Mark All Read
                    </button>
                @endif
            </div>
        </div>
        <div class="card-body p-4">
            <div class="btn-group w-100" role="group">
                <input type="radio" class="btn-check" name="filter" id="filter-all" wire:model.live="filter" value="all">
                <label class="btn btn-outline-secondary fw-semibold" for="filter-all" style="border-radius: 0.75rem 0 0 0.75rem; border-color: #e9ecef;">
                    <i class="fas fa-inbox me-2"></i>All ({{ $totalCount }})
                </label>

                <input type="radio" class="btn-check" name="filter" id="filter-unread" wire:model.live="filter" value="unread">
                <label class="btn btn-outline-secondary fw-semibold" for="filter-unread" style="border-radius: 0; border-color: #e9ecef;">
                    <i class="fas fa-bell me-2"></i>Unread ({{ $unreadCount }})
                </label>

                <input type="radio" class="btn-check" name="filter" id="filter-read" wire:model.live="filter" value="read">
                <label class="btn btn-outline-secondary fw-semibold" for="filter-read" style="border-radius: 0 0.75rem 0.75rem 0; border-color: #e9ecef;">
                    <i class="fas fa-check-circle me-2"></i>Read ({{ $readCount }})
                </label>
            </div>
        </div>
    </div>

    <!-- Notifications List -->
    @if($notifications->count() > 0)
        <div class="card border-0" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
            <div class="card-header" style="background: transparent; border-bottom: 1px solid rgba(0, 0, 0, 0.05); padding: 1.5rem 1.5rem 0; border-radius: 1.25rem 1.25rem 0 0;">
                <h5 class="mb-0 fw-bold d-flex align-items-center" style="color: #1b1b1b;">
                    <i class="fas fa-list me-2" style="color: #17a2b8;"></i>
                    @if($filter === 'unread')
                        Unread Notifications
                    @elseif($filter === 'read')
                        Read Notifications  
                    @else
                        All Notifications
                    @endif
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    @foreach($notifications as $notification)
                        <div class="col-12">
                            <div class="card border-0 {{ is_null($notification->read_at) ? 'border-start border-4' : '' }}" 
                                 style="background: {{ is_null($notification->read_at) ? 'rgba(192, 36, 37, 0.02)' : 'rgba(248, 249, 250, 0.5)' }}; border-radius: 1rem; {{ is_null($notification->read_at) ? 'border-start-color: #c02425 !important;' : '' }} transition: transform 0.2s ease;"
                                 onmouseover="this.style.transform='translateY(-2px)'"
                                 onmouseout="this.style.transform='translateY(0)'">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1 d-flex">
                                            <!-- Icon -->
                                            <div class="me-3">
                                                <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                                     style="width: 40px; height: 40px; {{ is_null($notification->read_at) ? 'background: rgba(192, 36, 37, 0.15); color: #c02425;' : 'background: rgba(108, 117, 125, 0.15); color: #6c757d;' }}">
                                                    <i class="fas fa-bell"></i>
                                                </div>
                                            </div>
                                            
                                            <!-- Content -->
                                            <div class="flex-grow-1">
                                                <div class="d-flex align-items-center gap-2 mb-2">
                                                    @if(is_null($notification->read_at))
                                                        <span class="badge" style="background: #c02425; color: white; font-size: 0.65rem; padding: 3px 8px; border-radius: 10px;">New</span>
                                                    @endif
                                                    <small class="text-muted fw-medium">{{ $notification->created_at->diffForHumans() }}</small>
                                                </div>
                                                
                                                @if(isset($notification->data['title']))
                                                    <h6 class="fw-bold mb-1" style="color: #1b1b1b; font-size: 0.95rem;">{{ $notification->data['title'] }}</h6>
                                                @endif
                                                
                                                @if(isset($notification->data['message']))
                                                    <p class="mb-2 text-muted" style="line-height: 1.5; font-size: 0.9rem;">{{ $notification->data['message'] }}</p>
                                                @endif
                                                
                                                @if(isset($notification->data['action_url']))
                                                    <a href="{{ $notification->data['action_url'] }}" class="btn btn-sm" 
                                                       style="background: linear-gradient(135deg, #c02425 0%, #d63031 100%); color: white; border: none; border-radius: 0.5rem; padding: 0.35rem 0.8rem; font-size: 0.8rem;">
                                                        <i class="fas fa-external-link-alt me-1"></i>View Details
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <!-- Actions -->
                                        <div class="dropdown">
                                            <button class="btn btn-sm" type="button" data-bs-toggle="dropdown" 
                                                    style="background: rgba(108, 117, 125, 0.1); border: none; color: #6c757d; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end" style="border-radius: 0.75rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);">
                                                @if(is_null($notification->read_at))
                                                    <li>
                                                        <button class="dropdown-item" wire:click="markAsRead('{{ $notification->id }}')">
                                                            <i class="fas fa-check me-2 text-success"></i>Mark as Read
                                                        </button>
                                                    </li>
                                                @endif
                                                <li>
                                                    <button class="dropdown-item text-danger" wire:click="deleteNotification('{{ $notification->id }}')">
                                                        <i class="fas fa-trash me-2"></i>Delete
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $notifications->links() }}
        </div>

        @if($readCount > 0)
            <div class="text-center mt-4">
                <button type="button" class="btn btn-outline-danger" wire:click="deleteAllRead" 
                        onclick="return confirm('Are you sure you want to delete all read notifications?')"
                        style="border-radius: 0.75rem; padding: 0.5rem 1.5rem; border-color: #dc3545;">
                    <i class="fas fa-trash me-1"></i>
                    Delete All Read
                </button>
            </div>
        @endif
    @else
        <div class="card border-0" style="border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
            <div class="card-body text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-bell-slash" style="font-size: 4rem; color: rgba(108, 117, 125, 0.3);"></i>
                </div>
                <h5 class="fw-bold mb-2" style="color: #1b1b1b;">No notifications found</h5>
                <p class="text-muted mb-0">
                    @if($filter === 'unread')
                        You have no unread notifications. You're all caught up! 🎉
                    @elseif($filter === 'read')
                        You have no read notifications yet.
                    @else
                        You don't have any notifications yet. We'll notify you when there's something new!
                    @endif
                </p>
            </div>
        </div>
    @endif
</div>