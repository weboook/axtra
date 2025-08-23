@section('page-title', 'My Bookings')

<div>
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0" style="background: linear-gradient(135deg, #1b1b1b 0%, #343a40 100%); color: white; border-radius: 1.5rem; box-shadow: 0 20px 60px rgba(27, 27, 27, 0.3);">
                <div class="card-body py-4 px-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h2 class="mb-2 fw-bold">My Bookings</h2>
                            <p class="mb-3 opacity-90" style="font-size: 1.1rem;">Manage your axe throwing sessions</p>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-calendar-check me-2"></i>
                                <span>{{ $stats['total'] }} total booking{{ $stats['total'] != 1 ? 's' : '' }}</span>
                                @if($stats['upcoming'] > 0)
                                    <span class="mx-2">•</span>
                                    <span class="text-warning">{{ $stats['upcoming'] }} upcoming</span>
                                @endif
                            </div>
                        </div>
                        <div class="d-none d-md-block">
                            <i class="fas fa-calendar-alt" style="font-size: 4rem; opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-0 h-100" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); transition: transform 0.3s ease;"
                 onmouseover="this.style.transform='translateY(-3px)'"
                 onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body p-4 text-center">
                    <div class="mb-3" style="background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%); width: 60px; height: 60px; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                        <i class="fas fa-list-alt" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                    <h3 class="fw-bold mb-2" style="color: #1b1b1b;">{{ $stats['total'] }}</h3>
                    <p class="mb-0 text-muted fw-medium">Total Bookings</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-0 h-100" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); transition: transform 0.3s ease;"
                 onmouseover="this.style.transform='translateY(-3px)'"
                 onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body p-4 text-center">
                    <div class="mb-3" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); width: 60px; height: 60px; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                        <i class="fas fa-clock" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                    <h3 class="fw-bold mb-2" style="color: #1b1b1b;">{{ $stats['upcoming'] }}</h3>
                    <p class="mb-0 text-muted fw-medium">Upcoming</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-0 h-100" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); transition: transform 0.3s ease;"
                 onmouseover="this.style.transform='translateY(-3px)'"
                 onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body p-4 text-center">
                    <div class="mb-3" style="background: linear-gradient(135deg, #6f42c1 0%, #e83e8c 100%); width: 60px; height: 60px; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                        <i class="fas fa-check-circle" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                    <h3 class="fw-bold mb-2" style="color: #1b1b1b;">{{ $stats['completed'] }}</h3>
                    <p class="mb-0 text-muted fw-medium">Completed</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-0 h-100" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); transition: transform 0.3s ease;"
                 onmouseover="this.style.transform='translateY(-3px)'"
                 onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body p-4 text-center">
                    <div class="mb-3" style="background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%); width: 60px; height: 60px; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                        <i class="fas fa-times-circle" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                    <h3 class="fw-bold mb-2" style="color: #1b1b1b;">{{ $stats['cancelled'] }}</h3>
                    <p class="mb-0 text-muted fw-medium">Cancelled</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <!-- Filter Buttons -->
                            <div class="btn-group" role="group">
                                <button type="button" wire:click="$set('filter', 'all')" 
                                        class="btn {{ $filter === 'all' ? 'btn-primary' : 'btn-outline-secondary' }}" 
                                        style="border-radius: 1rem 0 0 1rem; {{ $filter === 'all' ? 'background: #c02425; border-color: #c02425;' : '' }}">
                                    All ({{ $stats['total'] }})
                                </button>
                                <button type="button" wire:click="$set('filter', 'upcoming')" 
                                        class="btn {{ $filter === 'upcoming' ? 'btn-primary' : 'btn-outline-secondary' }}"
                                        style="{{ $filter === 'upcoming' ? 'background: #c02425; border-color: #c02425;' : '' }}">
                                    Upcoming ({{ $stats['upcoming'] }})
                                </button>
                                <button type="button" wire:click="$set('filter', 'past')" 
                                        class="btn {{ $filter === 'past' ? 'btn-primary' : 'btn-outline-secondary' }}"
                                        style="{{ $filter === 'past' ? 'background: #c02425; border-color: #c02425;' : '' }}">
                                    Past ({{ $stats['completed'] }})
                                </button>
                                <button type="button" wire:click="$set('filter', 'cancelled')" 
                                        class="btn {{ $filter === 'cancelled' ? 'btn-primary' : 'btn-outline-secondary' }}" 
                                        style="border-radius: 0 1rem 1rem 0; {{ $filter === 'cancelled' ? 'background: #c02425; border-color: #c02425;' : '' }}">
                                    Cancelled ({{ $stats['cancelled'] }})
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6 mt-3 mt-md-0">
                            <!-- Search -->
                            <div class="input-group">
                                <span class="input-group-text" style="background: rgba(192, 36, 37, 0.1); border: 1px solid rgba(192, 36, 37, 0.2); color: #c02425;">
                                    <i class="fas fa-search"></i>
                                </span>
                                <input type="text" wire:model.live="search" class="form-control" 
                                       placeholder="Search by booking reference or session type..."
                                       style="border: 1px solid rgba(192, 36, 37, 0.2); border-left: none;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bookings List -->
    @if($bookings->count() > 0)
        <div class="row">
            @foreach($bookings as $booking)
            <div class="col-12 mb-3">
                <div class="card border-0" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); transition: transform 0.3s ease;"
                     onmouseover="this.style.transform='translateY(-2px)'"
                     onmouseout="this.style.transform='translateY(0)'">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-2 text-center mb-3 mb-md-0">
                                <div class="mb-2" style="background: 
                                    @if($booking->status == 'confirmed') linear-gradient(135deg, #28a745 0%, #20c997 100%);
                                    @elseif($booking->status == 'pending') linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
                                    @elseif($booking->status == 'cancelled') linear-gradient(135deg, #dc3545 0%, #e83e8c 100%);
                                    @else linear-gradient(135deg, #6f42c1 0%, #e83e8c 100%); @endif
                                    width: 60px; height: 60px; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                    <i class="fas 
                                        @if($booking->status == 'confirmed') fa-check-circle
                                        @elseif($booking->status == 'pending') fa-clock
                                        @elseif($booking->status == 'cancelled') fa-times-circle
                                        @else fa-calendar @endif" 
                                       style="font-size: 1.5rem; color: white;"></i>
                                </div>
                                <span class="badge px-3 py-2" style="background: 
                                    @if($booking->status == 'confirmed') rgba(40, 167, 69, 0.2); color: #28a745;
                                    @elseif($booking->status == 'pending') rgba(255, 193, 7, 0.2); color: #ffc107;
                                    @elseif($booking->status == 'cancelled') rgba(220, 53, 69, 0.2); color: #dc3545;
                                    @else rgba(111, 66, 193, 0.2); color: #6f42c1; @endif
                                    font-size: 0.8rem; border-radius: 1rem;">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </div>
                            <div class="col-md-4 mb-3 mb-md-0">
                                <h5 class="fw-bold mb-2" style="color: #1b1b1b;">{{ $booking->booking_reference }}</h5>
                                <p class="mb-1 text-muted">{{ $booking->product->name ?? 'Axe Throwing Session' }}</p>
                                <small class="text-muted">
                                    <i class="fas fa-users me-1"></i>
                                    {{ $booking->participants }} participant{{ $booking->participants > 1 ? 's' : '' }}
                                </small>
                            </div>
                            <div class="col-md-3 mb-3 mb-md-0">
                                <h6 class="fw-semibold mb-1" style="color: #1b1b1b;">
                                    <i class="fas fa-calendar me-2" style="color: #c02425;"></i>
                                    {{ \Carbon\Carbon::parse($booking->booking_date)->format('l, M j, Y') }}
                                </h6>
                                <p class="mb-1">
                                    <i class="fas fa-clock me-2" style="color: #28a745;"></i>
                                    {{ \Carbon\Carbon::parse($booking->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('g:i A') }}
                                </p>
                                <small class="text-muted">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    Lane #{{ $booking->lane_id ?? 'TBD' }}
                                </small>
                            </div>
                            <div class="col-md-2 text-center mb-3 mb-md-0">
                                <h4 class="fw-bold mb-1" style="color: #c02425;">CHF {{ number_format($booking->total_price, 2) }}</h4>
                                @if($booking->discount_amount > 0)
                                    <small class="text-success">-CHF {{ number_format($booking->discount_amount, 2) }}</small>
                                @endif
                            </div>
                            <div class="col-md-1 text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary rounded-circle" type="button" data-bs-toggle="dropdown" style="width: 40px; height: 40px;">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" style="border-radius: 1rem; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);">
                                        <li>
                                            <button class="dropdown-item" wire:click="showBookingDetails({{ $booking->id }})">
                                                <i class="fas fa-eye me-2"></i>View Details
                                            </button>
                                        </li>
                                        @if($booking->status === 'confirmed' || $booking->status === 'pending')
                                            @php
                                                $bookingDateTime = \Carbon\Carbon::parse($booking->booking_date . ' ' . $booking->start_time);
                                                $canCancel = $bookingDateTime->isAfter(now()->addHours(24));
                                            @endphp
                                            @if($canCancel)
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <button class="dropdown-item text-danger" 
                                                            onclick="if(confirm('Are you sure you want to cancel this booking?')) { @this.call('cancelBooking', {{ $booking->id }}) }">
                                                        <i class="fas fa-times me-2"></i>Cancel Booking
                                                    </button>
                                                </li>
                                            @else
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <span class="dropdown-item-text text-muted small">
                                                        <i class="fas fa-info-circle me-2"></i>Cannot cancel (< 24h)
                                                    </span>
                                                </li>
                                            @endif
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        @if($booking->notes)
                            <hr style="border-color: rgba(0, 0, 0, 0.1);">
                            <div class="row">
                                <div class="col-12">
                                    <h6 class="fw-semibold mb-2" style="color: #1b1b1b;">Notes:</h6>
                                    <p class="text-muted mb-0" style="font-style: italic;">{{ $booking->notes }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $bookings->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0" style="background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                    <div class="card-body p-5 text-center">
                        <i class="fas fa-calendar-times mb-4" style="font-size: 4rem; color: rgba(192, 36, 37, 0.3);"></i>
                        <h3 class="fw-bold mb-3" style="color: #1b1b1b;">
                            @if($filter === 'all')
                                No Bookings Yet
                            @elseif($filter === 'upcoming')
                                No Upcoming Bookings
                            @elseif($filter === 'past')
                                No Past Bookings
                            @else
                                No Cancelled Bookings
                            @endif
                        </h3>
                        <p class="text-muted mb-4" style="font-size: 1.1rem;">
                            @if($filter === 'all')
                                Ready to book your first axe throwing adventure?
                            @elseif($filter === 'upcoming')
                                Book your next session to see it here!
                            @elseif($filter === 'past')
                                Your completed sessions will appear here.
                            @else
                                Any cancelled bookings will be shown here.
                            @endif
                        </p>
                        @if($filter === 'all' || $filter === 'upcoming')
                            <a href="{{ route('user.book') }}" class="btn btn-lg px-5 py-3" 
                               style="background: linear-gradient(135deg, #c02425 0%, #d63031 100%); color: white; border-radius: 2rem; border: none;">
                                <i class="fas fa-plus-circle me-2"></i>Book Your First Session
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Quick Actions -->
    @if($bookings->count() > 0)
        <div class="row mt-5">
            <div class="col-12">
                <div class="card border-0" style="background: rgba(192, 36, 37, 0.05); border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                    <div class="card-body p-4 text-center">
                        <h5 class="fw-bold mb-3" style="color: #1b1b1b;">Ready for More Action?</h5>
                        <a href="{{ route('user.book') }}" class="btn btn-lg px-4 py-2 me-3" 
                           style="background: linear-gradient(135deg, #c02425 0%, #d63031 100%); color: white; border-radius: 2rem; border: none;">
                            <i class="fas fa-plus-circle me-2"></i>Book Another Session
                        </a>
                        <a href="{{ route('leaderboard.public') }}" class="btn btn-lg btn-outline-secondary px-4 py-2" 
                           style="border-radius: 2rem; border-color: #c02425; color: #c02425;">
                            <i class="fas fa-trophy me-2"></i>View Leaderboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Booking Details Modal -->
@if($showBookingId)
    @php
        $selectedBooking = $bookings->firstWhere('id', $showBookingId);
    @endphp
    @if($selectedBooking)
        <div class="modal fade show" style="display: block; background: rgba(0, 0, 0, 0.5);" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" style="border-radius: 1.5rem; border: none; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);">
                    <div class="modal-header" style="border-bottom: 1px solid rgba(0, 0, 0, 0.1); padding: 2rem 2rem 1rem;">
                        <h4 class="modal-title fw-bold" style="color: #1b1b1b;">Booking Details</h4>
                        <button type="button" class="btn-close" wire:click="hideBookingDetails"></button>
                    </div>
                    <div class="modal-body" style="padding: 1rem 2rem 2rem;">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="fw-bold mb-3" style="color: #c02425;">Booking Information</h6>
                                <p><strong>Reference:</strong> {{ $selectedBooking->booking_reference }}</p>
                                <p><strong>Status:</strong> 
                                    <span class="badge" style="background: 
                                        @if($selectedBooking->status == 'confirmed') rgba(40, 167, 69, 0.2); color: #28a745;
                                        @elseif($selectedBooking->status == 'pending') rgba(255, 193, 7, 0.2); color: #ffc107;
                                        @elseif($selectedBooking->status == 'cancelled') rgba(220, 53, 69, 0.2); color: #dc3545;
                                        @else rgba(111, 66, 193, 0.2); color: #6f42c1; @endif">
                                        {{ ucfirst($selectedBooking->status) }}
                                    </span>
                                </p>
                                <p><strong>Session Type:</strong> {{ $selectedBooking->product->name ?? 'Axe Throwing Session' }}</p>
                                <p><strong>Participants:</strong> {{ $selectedBooking->participants }}</p>
                                <p><strong>Equipment:</strong> {{ $selectedBooking->equipment_needed ? 'Included' : 'Not needed' }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold mb-3" style="color: #c02425;">Session Details</h6>
                                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($selectedBooking->booking_date)->format('l, F j, Y') }}</p>
                                <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($selectedBooking->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($selectedBooking->end_time)->format('g:i A') }}</p>
                                <p><strong>Lane:</strong> Lane #{{ $selectedBooking->lane_id ?? 'TBD' }}</p>
                                <p><strong>Total Price:</strong> CHF {{ number_format($selectedBooking->total_price, 2) }}</p>
                                @if($selectedBooking->discount_amount > 0)
                                    <p><strong>Discount:</strong> <span class="text-success">-CHF {{ number_format($selectedBooking->discount_amount, 2) }}</span></p>
                                @endif
                            </div>
                        </div>
                        
                        @if($selectedBooking->notes)
                            <hr>
                            <h6 class="fw-bold mb-2" style="color: #c02425;">Notes</h6>
                            <p class="text-muted" style="font-style: italic;">{{ $selectedBooking->notes }}</p>
                        @endif
                        
                        @if($selectedBooking->participant_details)
                            <hr>
                            <h6 class="fw-bold mb-2" style="color: #c02425;">Participant Details</h6>
                            <div class="p-3 rounded" style="background: rgba(248, 249, 250, 0.8);">
                                {{ $selectedBooking->participant_details }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif

@push('scripts')
<script>
    // Listen for Livewire events
    document.addEventListener('livewire:init', () => {
        Livewire.on('booking-cancelled', (event) => {
            showSuccess(event[0].title, event[0].text);
        });
    });
</script>
@endpush