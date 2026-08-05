(function () {
    'use strict';

    var grid = document.getElementById('storeGrid');
    var sentinel = document.getElementById('storeGridSentinel');
    var spinner = document.getElementById('storeGridSpinner');
    var endMsg = document.getElementById('storeGridEnd');
    if (!grid || !sentinel) return;

    var type = grid.dataset.type;
    var loadMoreUrl = grid.dataset.loadMoreUrl;
    var nextPage = parseInt(grid.dataset.nextPage, 10);
    var hasMore = grid.dataset.hasMore === '1';
    var loading = false;

    function loadNextPage() {
        if (loading || !hasMore) return;
        loading = true;
        spinner.classList.remove('d-none');

        fetch(loadMoreUrl + '?type=' + encodeURIComponent(type) + '&page=' + nextPage)
            .then(function (r) { return r.json(); })
            .then(function (data) {
                grid.insertAdjacentHTML('beforeend', data.html);
                hasMore = data.hasMore;
                nextPage = data.nextPage;
                spinner.classList.add('d-none');
                loading = false;

                if (!hasMore) {
                    endMsg.classList.remove('d-none');
                    observer.disconnect();
                }
            })
            .catch(function () {
                spinner.classList.add('d-none');
                loading = false;
            });
    }

    var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) loadNextPage();
        });
    }, { rootMargin: '400px' });

    if (hasMore) {
        observer.observe(sentinel);
    } else {
        endMsg.classList.remove('d-none');
    }
})();
