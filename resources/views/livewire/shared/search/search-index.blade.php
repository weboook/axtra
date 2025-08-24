<div class="position-relative" style="width: 320px;">
    <div class="input-group">
        <span class="input-group-text" style="background: transparent; 
                                              border: none; 
                                              color: rgba(255, 255, 255, 0.7); 
                                              border-radius: 25px 0 0 25px;
                                              border-right: 1px solid rgba(255, 255, 255, 0.2);">
            <i class="fas fa-search"></i>
        </span>
        <input type="search" 
               class="form-control" 
               placeholder="Search anything..." 
               wire:model.live.debounce.300ms="query"
               wire:focus="$set('showResults', true)"
               wire:blur="hideResults"
               autocomplete="off"
               style="background: transparent; 
                      border: none; 
                      color: white; 
                      border-radius: 0 25px 25px 0;
                      padding-left: 10px;"
               onfocus="this.style.background='rgba(255, 255, 255, 0.1)'; this.previousElementSibling.style.background='rgba(255, 255, 255, 0.1)';"
               onblur="this.style.background='transparent'; this.previousElementSibling.style.background='transparent';">
    </div>

    @if($showResults && !empty($results))
        <div class="position-absolute w-100 mt-2" style="z-index: 9999;">
            <div class="card border-0" style="background: rgba(17, 17, 17, 0.98); 
                                            backdrop-filter: blur(40px);
                                            border-radius: 1rem;
                                            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.8), 0 0 0 1px rgba(255, 255, 255, 0.05);
                                            overflow: hidden;">
                <div class="card-header" style="background: transparent; border-bottom: 1px solid rgba(255, 255, 255, 0.08); padding: 1rem;">
                    <h6 class="mb-0 fw-bold text-white">Search Results</h6>
                </div>
                <div class="card-body p-0" style="max-height: 300px; overflow-y: auto;">
                    @foreach($results as $result)
                        <a href="{{ $result['url'] }}" 
                           class="d-flex align-items-center p-3 text-decoration-none border-bottom"
                           style="color: white; border-bottom-color: rgba(255, 255, 255, 0.05) !important; transition: background 0.2s ease;"
                           onmouseover="this.style.background='rgba(255, 255, 255, 0.05)'"
                           onmouseout="this.style.background='transparent'">
                            <div class="me-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 35px; height: 35px; background: {{ $result['color'] }}15; color: {{ $result['color'] }};">
                                    <i class="{{ $result['icon'] }}"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold" style="font-size: 0.9rem;">{{ $result['title'] }}</div>
                                <small style="color: rgba(255, 255, 255, 0.6);">{{ $result['subtitle'] }}</small>
                            </div>
                            <div>
                                <span class="badge" style="background: {{ $result['color'] }}20; color: {{ $result['color'] }}; font-size: 0.7rem; padding: 4px 8px; border-radius: 10px;">
                                    {{ ucfirst($result['type']) }}
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @elseif($showResults && strlen($query) >= 2 && empty($results))
        <div class="position-absolute w-100 mt-2" style="z-index: 9999;">
            <div class="card border-0" style="background: rgba(17, 17, 17, 0.98); 
                                            backdrop-filter: blur(40px);
                                            border-radius: 1rem;
                                            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.8), 0 0 0 1px rgba(255, 255, 255, 0.05);">
                <div class="card-body p-4 text-center">
                    <i class="fas fa-search text-muted mb-2" style="font-size: 1.5rem; opacity: 0.5;"></i>
                    <div class="text-white fw-semibold">No results found</div>
                    <small style="color: rgba(255, 255, 255, 0.6);">Try searching with different keywords</small>
                </div>
            </div>
        </div>
    @endif
</div>