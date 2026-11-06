console.log('delete helper delete-confirm.js');
document.addEventListener('click', function (e) {
    const button = e.target.closest('.btn-delete');
    if (!button) {
        return;
    }
    e.preventDefault();

    const currentUserId = document
        .querySelector('meta[name="user-id"]')
        ?.getAttribute('content');

    const row = button.closest('tr');
    const id = row ? row.dataset.id : '';

    if (currentUserId && id === currentUserId) {
        if (typeof Toast !== 'undefined') {
            Toast.error('You cannot delete your own account!');
        }

        return;
    }
    const url = button.dataset.url;
    const page = button.dataset.page || 1;

    if (!url) {
        if (typeof Toast !== 'undefined') {
            Toast.error('Delete URL is missing.');
        }

        return;
    }

    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute('content');

    if (!csrfToken) {
        if (typeof Toast !== 'undefined') {
            Toast.error(
                'Security token missing. Please refresh the page.'
            );
        }

        return;
    }

    button.style.pointerEvents = 'none';
    button.style.opacity = '0.5';

    fetch(url, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            page: page
        })
    })
        .then(async response => {
            const data = await response.json();

            if (!response.ok) {
                throw new Error(
                    data.message || 'Failed to delete record.'
                );
            }

            return data;
        })
        .then(data => {
            if (!data.success) {
                throw new Error(
                    data.message || 'Delete operation failed.'
                );
            }
            if (typeof Toast !== 'undefined') {
                Toast.success(
                    data.message || 'Deleted successfully!'
                );
            }
            if (data.redirect) {
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 400);
                return;
            }
            if (typeof window.reloadLiveTable === 'function') {
                setTimeout(() => {
                    window.reloadLiveTable();
                }, 400);
            } else {
                window.location.reload();
            }
        })
        .catch(error => {
            console.error('Delete action failed:', error);

            if (typeof Toast !== 'undefined') {
                Toast.error(
                    error.message ||
                    'Something went wrong. Please try again.'
                );
            }

            button.style.pointerEvents = 'auto';
            button.style.opacity = '1';
        });
});