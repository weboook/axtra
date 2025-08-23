import './bootstrap';
import Alpine from 'alpinejs';
import Dropzone from 'dropzone';
import Swal from 'sweetalert2';

// Initialize Alpine.js
window.Alpine = Alpine;
Alpine.start();

// Initialize Dropzone
window.Dropzone = Dropzone;
Dropzone.autoDiscover = false;

// Initialize SweetAlert2
window.Swal = Swal;

// Global SweetAlert2 configurations
window.showAlert = function(type, title, text = '') {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    return Toast.fire({
        icon: type,
        title: title,
        text: text
    });
};

// Confirmation dialog helper
window.confirmAction = function(title, text, confirmText = 'Yes, do it!') {
    return Swal.fire({
        title: title,
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: confirmText,
        cancelButtonText: 'Cancel'
    });
};
