// alert.js

export const Toast = {
    show(message, type = 'success') {
        const toastContainer = document.getElementById('alert-toast');
        const toastAlert = document.getElementById('ajax-alert');
        const messageSpan = document.getElementById('alert-message');

        if (!toastContainer || !toastAlert || !messageSpan) return;

        // Set message
        messageSpan.textContent = message;

        // Set color based on type (success, danger, warning, etc.)
        toastAlert.className = `alert rounded-0 border-0 mb-0 shadow-lg py-2 px-3 text-white bg-${type}`;

        // Show toast
        toastContainer.classList.remove('d-none');

        // Auto hide after 3 seconds
        setTimeout(() => {
            toastContainer.classList.add('d-none');
        }, 3000);
    },

    success(message) {
        this.show(message, 'success');
    },

    error(message) {
        this.show(message, 'danger');
    },

    warning(message) {
        this.show(message, 'warning');
    }
};

// Global close button event listener
document.addEventListener('click', function (e) {
    if (e.target.closest('#alert-toast .btn-close')) {
        document.getElementById('alert-toast').classList.add('d-none');
    }
});