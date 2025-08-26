/**
 * Modern Modal Helpers for Axtra App
 * Provides consistent modal functionality across the application
 */

// Initialize modal helpers when DOM is ready
document.addEventListener('DOMContentLoaded', function () {
    initializeModals();
});

// Initialize modal functionality
function initializeModals() {
    // Add modern modal classes to existing modals
    document.querySelectorAll('.modal').forEach(function(modal) {
        // Add animation classes if not present
        if (!modal.classList.contains('fade')) {
            modal.classList.add('fade');
        }
        
        // Enhance modal headers that don't have the modern structure
        enhanceModalHeader(modal);
    });

    // Handle Livewire modal events
    if (typeof Livewire !== 'undefined') {
        // Listen for Livewire modal events
        Livewire.on('showModal', function (modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                const bsModal = new bootstrap.Modal(modal);
                bsModal.show();
            }
        });

        Livewire.on('hideModal', function (modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                const bsModal = bootstrap.Modal.getInstance(modal);
                if (bsModal) {
                    bsModal.hide();
                }
            }
        });
    }

    // Add smooth animations to modal elements
    addModalAnimations();
}

// Enhance modal headers to use modern structure
function enhanceModalHeader(modal) {
    const header = modal.querySelector('.modal-header');
    const title = modal.querySelector('.modal-title');
    
    if (header && title && !header.querySelector('.modal-header-with-icon')) {
        // Check if header already has modern structure
        if (header.querySelector('.d-flex.align-items-center')) {
            return; // Already modernized
        }

        // Get the title text
        const titleText = title.textContent.trim();
        
        // Determine appropriate icon based on modal content or class
        let iconClass = 'fas fa-info-circle';
        let iconColor = '#c02425';
        
        // Set icon based on modal context
        if (modal.classList.contains('modal-danger') || titleText.toLowerCase().includes('delete') || titleText.toLowerCase().includes('remove')) {
            iconClass = 'fas fa-exclamation-triangle';
            iconColor = '#dc3545';
        } else if (modal.classList.contains('modal-success') || titleText.toLowerCase().includes('success') || titleText.toLowerCase().includes('complete')) {
            iconClass = 'fas fa-check-circle';
            iconColor = '#28a745';
        } else if (modal.classList.contains('modal-warning') || titleText.toLowerCase().includes('warning') || titleText.toLowerCase().includes('caution')) {
            iconClass = 'fas fa-exclamation-triangle';
            iconColor = '#ffc107';
        } else if (titleText.toLowerCase().includes('create') || titleText.toLowerCase().includes('add')) {
            iconClass = 'fas fa-plus-circle';
        } else if (titleText.toLowerCase().includes('edit') || titleText.toLowerCase().includes('update')) {
            iconClass = 'fas fa-edit';
        } else if (titleText.toLowerCase().includes('booking')) {
            iconClass = 'fas fa-calendar-check';
        } else if (titleText.toLowerCase().includes('user') || titleText.toLowerCase().includes('employee')) {
            iconClass = 'fas fa-user';
        }

        // Create modern header structure (but don't modify if it might break existing functionality)
        // This is a gentle enhancement that preserves existing structure
        title.style.color = '#1a1a1a';
        title.style.fontWeight = '700';
    }
}

// Add smooth animations to modal elements
function addModalAnimations() {
    // Add hover effects to modal buttons
    document.querySelectorAll('.modal .btn').forEach(function(btn) {
        btn.addEventListener('mouseenter', function() {
            if (!this.disabled) {
                this.style.transform = 'translateY(-1px)';
            }
        });
        
        btn.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Add focus management
    document.querySelectorAll('.modal').forEach(function(modal) {
        modal.addEventListener('shown.bs.modal', function() {
            // Focus first input or button in modal
            const firstInput = this.querySelector('input:not([type="hidden"]), textarea, select, button:not(.btn-close)');
            if (firstInput) {
                setTimeout(() => firstInput.focus(), 100);
            }
        });
    });
}

// Utility function to create modern modal
function createModernModal(options) {
    const {
        id = 'dynamicModal',
        title = 'Modal',
        body = '',
        size = 'lg',
        icon = 'fas fa-info-circle',
        iconColor = '#c02425',
        buttons = []
    } = options;

    const modalHtml = `
        <div class="modal fade" id="${id}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-${size} modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="d-flex align-items-center">
                            <div class="modal-header-icon">
                                <i class="${icon}" style="color: ${iconColor};"></i>
                            </div>
                            <div>
                                <h5 class="modal-title">${title}</h5>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ${body}
                    </div>
                    ${buttons.length > 0 ? `
                    <div class="modal-footer">
                        ${buttons.map(btn => `
                            <button type="button" class="btn ${btn.class || 'btn-secondary'}" ${btn.dismiss ? 'data-bs-dismiss="modal"' : ''} ${btn.onclick ? `onclick="${btn.onclick}"` : ''}>
                                ${btn.text}
                            </button>
                        `).join('')}
                    </div>
                    ` : ''}
                </div>
            </div>
        </div>
    `;

    // Remove existing modal with same ID
    const existingModal = document.getElementById(id);
    if (existingModal) {
        existingModal.remove();
    }

    // Add modal to body
    document.body.insertAdjacentHTML('beforeend', modalHtml);
    
    // Initialize and show modal
    const modal = document.getElementById(id);
    const bsModal = new bootstrap.Modal(modal);
    
    // Remove modal from DOM when hidden
    modal.addEventListener('hidden.bs.modal', function() {
        this.remove();
    });
    
    return bsModal;
}

// Quick success modal
function showSuccessModal(title, message, callback = null) {
    const modal = createModernModal({
        id: 'successModal',
        title: title,
        body: `<div class="text-center">
                <div class="mb-3">
                    <i class="fas fa-check-circle text-success" style="font-size: 3rem;"></i>
                </div>
                <p class="mb-0">${message}</p>
               </div>`,
        icon: 'fas fa-check-circle',
        iconColor: '#28a745',
        buttons: [{
            text: 'OK',
            class: 'btn-success',
            dismiss: true,
            onclick: callback ? callback.toString() + '()' : null
        }]
    });
    modal.show();
    return modal;
}

// Quick error modal
function showErrorModal(title, message, callback = null) {
    const modal = createModernModal({
        id: 'errorModal',
        title: title,
        body: `<div class="text-center">
                <div class="mb-3">
                    <i class="fas fa-exclamation-triangle text-danger" style="font-size: 3rem;"></i>
                </div>
                <p class="mb-0">${message}</p>
               </div>`,
        icon: 'fas fa-exclamation-triangle',
        iconColor: '#dc3545',
        buttons: [{
            text: 'OK',
            class: 'btn-danger',
            dismiss: true,
            onclick: callback ? callback.toString() + '()' : null
        }]
    });
    modal.show();
    return modal;
}

// Quick confirmation modal
function showConfirmModal(title, message, confirmCallback, cancelCallback = null) {
    const modal = createModernModal({
        id: 'confirmModal',
        title: title,
        body: `<div class="text-center">
                <div class="mb-3">
                    <i class="fas fa-question-circle text-warning" style="font-size: 3rem;"></i>
                </div>
                <p class="mb-0">${message}</p>
               </div>`,
        icon: 'fas fa-question-circle',
        iconColor: '#ffc107',
        buttons: [
            {
                text: 'Cancel',
                class: 'btn-outline-secondary',
                dismiss: true,
                onclick: cancelCallback ? cancelCallback.toString() + '()' : null
            },
            {
                text: 'Confirm',
                class: 'btn-primary',
                onclick: confirmCallback.toString() + '(); bootstrap.Modal.getInstance(document.getElementById("confirmModal")).hide();'
            }
        ]
    });
    modal.show();
    return modal;
}

// Export functions for global use
window.createModernModal = createModernModal;
window.showSuccessModal = showSuccessModal;
window.showErrorModal = showErrorModal;
window.showConfirmModal = showConfirmModal;