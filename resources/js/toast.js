export const Toast = {
    show(message, type = 'success') {
        const toastContainer = document.getElementById('alert-toast');
        const toastAlert = document.getElementById('ajax-alert');
        const messageSpan = document.getElementById('alert-message');
        if (!toastContainer || !toastAlert || !messageSpan) return;
        messageSpan.textContent = message;
        toastAlert.className = 'alert rounded-0 border-0 mb-0 shadow-lg py-2 px-3 text-white text-center';
        toastAlert.classList.add(`toast-${type}`);

        toastContainer.classList.remove('d-none');

        if (toastContainer.toastTimer) {
            clearTimeout(toastContainer.toastTimer);
        }
        toastContainer.toastTimer = setTimeout(() => {
            toastContainer.classList.add('d-none');
        }, 6000);
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
window.Toast = Toast;
document.addEventListener('click', function (e) {
    if (e.target.closest('#alert-toast .btn-close')) {
        const container = document.getElementById('alert-toast');
        if (container) {
            container.classList.add('d-none');
        }
    }
});