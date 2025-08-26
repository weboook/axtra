{{-- Modern Modal Component with Axtra Styling --}}
@props([
    'id' => 'modal',
    'size' => 'lg',
    'title' => '',
    'icon' => 'fas fa-info-circle',
    'iconColor' => '#c02425',
    'show' => false,
    'livewire' => false
])

<div class="modal fade{{ $show ? ' show' : '' }}" 
     id="{{ $id }}" 
     tabindex="-1" 
     aria-labelledby="{{ $id }}Label" 
     aria-hidden="{{ $show ? 'false' : 'true' }}"
     {{ $livewire ? 'wire:ignore.self' : '' }}
     @if($show) style="display: block; background: rgba(0, 0, 0, 0.5);" @endif>
    <div class="modal-dialog modal-{{ $size }} {{ $size === 'xl' ? '' : 'modal-dialog-centered' }}">
        <div class="modern-modal-content">
            <div class="modern-modal-header">
                <div class="d-flex align-items-center">
                    <div class="modern-modal-icon">
                        <i class="{{ $icon }}" style="color: {{ $iconColor }};"></i>
                    </div>
                    <div>
                        <h5 class="modern-modal-title">{{ $title }}</h5>
                        @if($slot->isNotEmpty() && isset($subtitle))
                            <small class="text-muted">{{ $subtitle }}</small>
                        @endif
                    </div>
                </div>
                <button type="button" class="btn-close modern-modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modern-modal-body">
                {{ $slot }}
            </div>
            
            @if(isset($footer))
                <div class="modern-modal-footer">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* Modern Modal Styling */
    .modern-modal-content {
        border: none;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        background: white;
        overflow: hidden;
    }

    .modern-modal-header {
        border-bottom: 1px solid #f8f9fa;
        padding: 1.5rem;
        background: white;
    }

    .modern-modal-icon {
        width: 48px;
        height: 48px;
        background: rgba(192, 36, 37, 0.1);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .modern-modal-title {
        color: #1a1a1a;
        font-weight: 700;
        margin: 0;
        font-size: 1.25rem;
        line-height: 1.2;
    }

    .modern-modal-close {
        opacity: 0.6;
        transition: opacity 0.15s ease;
    }

    .modern-modal-close:hover {
        opacity: 1;
    }

    .modern-modal-body {
        padding: 1.5rem;
        background: white;
    }

    .modern-modal-footer {
        border-top: 1px solid #f8f9fa;
        padding: 1.5rem;
        background: white;
        display: flex;
        justify-content: flex-end;
        gap: 0.75rem;
    }

    /* Modal backdrop animation */
    .modal.fade {
        transition: opacity 0.15s linear;
    }

    .modal.fade .modern-modal-content {
        transition: transform 0.15s ease-out;
        transform: scale(0.95);
    }

    .modal.show .modern-modal-content {
        transform: scale(1);
    }

    /* Responsive adjustments */
    @media (max-width: 576px) {
        .modern-modal-header,
        .modern-modal-body,
        .modern-modal-footer {
            padding: 1rem;
        }

        .modern-modal-icon {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }

        .modern-modal-title {
            font-size: 1.1rem;
        }
    }

    /* Button styling in modals */
    .modern-modal-footer .btn {
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 500;
        transition: all 0.15s ease;
    }

    .modern-modal-footer .btn:hover {
        transform: translateY(-1px);
    }

    .modern-modal-footer .btn-primary {
        background: #c02425;
        border-color: #c02425;
    }

    .modern-modal-footer .btn-primary:hover {
        background: #a01e1f;
        border-color: #a01e1f;
    }

    /* Custom scrollbar for modal body */
    .modern-modal-body::-webkit-scrollbar {
        width: 6px;
    }

    .modern-modal-body::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }

    .modern-modal-body::-webkit-scrollbar-thumb {
        background: #c02425;
        border-radius: 3px;
    }

    .modern-modal-body::-webkit-scrollbar-thumb:hover {
        background: #a01e1f;
    }
</style>