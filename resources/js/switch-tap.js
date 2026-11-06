console.log('product tabs loaded');

document.addEventListener('click', function (e) {
    const tab = e.target.closest('.product-nav-item');

    if (!tab) {
        return;
    }

    console.log('product tab clicked');

    e.preventDefault();
    e.stopPropagation();

    const url = tab.dataset.url;
    const content = document.getElementById('product-content');

    console.log('URL:', url);
    console.log('Content:', content);

    if (!url || !content) {
        return;
    }

    document.querySelectorAll('.product-nav-item').forEach(item => {
        item.classList.remove('active');
    });

    tab.classList.add('active');

    content.innerHTML = `
        <div class="text-center py-5">
            <div class="spinner-border text-secondary" role="status"></div>
        </div>
    `;

    fetch(url, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'text/html'
        }
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}`);
            }

            return response.text();
        })
        .then(html => {
            content.innerHTML = html;
        })
        .catch(error => {
            console.error(error);

            content.innerHTML = `
                <div class="alert alert-danger">
                    ${error.message}
                </div>
            `;
        });
});