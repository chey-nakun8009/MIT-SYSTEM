console.log('load live-table.js');

window.initLiveTable = function (config) {
    const searchInput = document.getElementById(config.searchInputId);
    const tableBody = document.getElementById(config.tableBodyId);
    const paginationContainer = document.getElementById(config.paginationId);

    if (!tableBody || !paginationContainer) return;

    let searchTimer = null;
    let currentUrl = config.url;

    function fetchTableData(url, search = '', retryPreviousPage = true) {
        const fetchUrl = new URL(url, window.location.origin);

        if (search) {
            fetchUrl.searchParams.set('search', search);
        } else {
            fetchUrl.searchParams.delete('search');
        }

        currentUrl = fetchUrl.toString();

        fetch(currentUrl, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response error');
                }

                return response.json();
            })
            .then(data => {
                if (window.Alpine && typeof window.Alpine.mutateDom === 'function') {
                    window.Alpine.mutateDom(() => {
                        if (data.html !== undefined) {
                            tableBody.innerHTML = data.html;
                        }

                        if (data.pagination !== undefined) {
                            paginationContainer.innerHTML = data.pagination;
                        }
                    });
                } else {
                    if (data.html !== undefined) {
                        tableBody.innerHTML = data.html;
                    }

                    if (data.pagination !== undefined) {
                        paginationContainer.innerHTML = data.pagination;
                    }
                }

                window.LiveTableCurrentUrl = currentUrl;

                const currentPage = parseInt(
                    fetchUrl.searchParams.get('page') || '1',
                    10
                );

                const hasRows = tableBody.querySelector('tr[data-id]');

                if (!hasRows && currentPage > 1 && retryPreviousPage) {
                    const previousUrl = new URL(
                        currentUrl,
                        window.location.origin
                    );

                    previousUrl.searchParams.set(
                        'page',
                        currentPage - 1
                    );

                    fetchTableData(
                        previousUrl.toString(),
                        search,
                        false
                    );
                }
            })
            .catch(error => {
                console.error('LiveTable Fetch Error:', error);
            });
    }

    window.LiveTableCurrentUrl = currentUrl;

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            clearTimeout(searchTimer);

            const query = this.value.trim();

            searchTimer = setTimeout(() => {
                fetchTableData(config.url, query);
            }, config.debounceMs || 300);
        });
    }

    paginationContainer.addEventListener('click', function (e) {
        const link = e.target.closest('a.page-link');

        if (!link || !link.href) {
            return;
        }

        e.preventDefault();

        const searchVal = searchInput
            ? searchInput.value.trim()
            : '';

        fetchTableData(link.href, searchVal);
    });

    window.reloadLiveTable = function () {
        const searchVal = searchInput
            ? searchInput.value.trim()
            : '';

        const url = window.LiveTableCurrentUrl || config.url;

        fetchTableData(url, searchVal);
    };

    window.getLiveTableCurrentPage = function () {
        const url = window.LiveTableCurrentUrl || config.url;

        const fetchUrl = new URL(
            url,
            window.location.origin
        );

        return parseInt(
            fetchUrl.searchParams.get('page') || '1',
            10
        );
    };
};