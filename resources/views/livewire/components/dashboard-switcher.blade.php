@if(auth()->user()->isAdmin())
<div class="dropdown">
    <button class="btn btn-outline-light btn-sm dropdown-toggle d-flex align-items-center" type="button" 
            data-bs-toggle="dropdown" aria-expanded="false"
            style="border-radius: 1rem; padding: 0.5rem 1rem; border: 1px solid rgba(255,255,255,0.3);">
        <i class="{{ $dashboards[$currentDashboard]['icon'] }} me-2" style="color: {{ $dashboards[$currentDashboard]['color'] }};"></i>
        <span class="fw-semibold">{{ $dashboards[$currentDashboard]['name'] }}</span>
        <i class="fas fa-chevron-down ms-2" style="font-size: 0.8rem;"></i>
    </button>
    
    <div class="dropdown-menu dropdown-menu-end border-0" 
         style="background: white; border-radius: 1rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15); min-width: 280px; padding: 1rem;">
        
        <div class="mb-3">
            <h6 class="fw-bold mb-1" style="color: #1b1b1b;">Switch Dashboard</h6>
            <p class="text-muted mb-0" style="font-size: 0.85rem;">Choose your dashboard view</p>
        </div>
        
        <div class="d-grid gap-2">
            @foreach($dashboards as $key => $dashboard)
                <button type="button" 
                        class="btn text-start p-3 {{ $key === $currentDashboard ? 'btn-light' : 'btn-outline-light' }}"
                        style="border-radius: 1rem; border: 1px solid {{ $key === $currentDashboard ? $dashboard['color'] : '#e0e6ed' }}; 
                               background: {{ $key === $currentDashboard ? 'rgba('.hexdec(substr($dashboard['color'], 1, 2)).', '.hexdec(substr($dashboard['color'], 3, 2)).', '.hexdec(substr($dashboard['color'], 5, 2)).', 0.1)' : 'transparent' }};"
                        wire:click="switchDashboard('{{ $key }}')"
                        {{ $key === $currentDashboard ? 'disabled' : '' }}>
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="{{ $dashboard['icon'] }}" style="font-size: 1.2rem; color: {{ $dashboard['color'] }};"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-semibold" style="color: #1b1b1b; font-size: 0.95rem;">{{ $dashboard['name'] }}</div>
                            <small class="text-muted">{{ $dashboard['description'] }}</small>
                        </div>
                        @if($key === $currentDashboard)
                            <div class="ms-2">
                                <i class="fas fa-check-circle" style="color: {{ $dashboard['color'] }};"></i>
                            </div>
                        @endif
                    </div>
                </button>
            @endforeach
        </div>
        
        <hr class="my-3" style="border-color: #e0e6ed;">
        
        <div class="text-center">
            <small class="text-muted">
                <i class="fas fa-info-circle me-1"></i>
                Admin-only feature
            </small>
        </div>
    </div>
</div>
@endif
