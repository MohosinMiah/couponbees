(function () {
    'use strict';

    function escHtml(str) {
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    function initSearchWidget(wrap) {
        var input    = wrap.querySelector('.nav-search');
        var dropdown = wrap.querySelector('.search-dropdown');
        if (!input || !dropdown) return;

        var searchUrl   = input.dataset.searchUrl;
        var debounceId  = null;
        var activeIndex = -1;
        var results     = [];
        var controller  = null;

        function closeDropdown() {
            dropdown.classList.remove('show');
            dropdown.innerHTML = '';
            results = [];
            activeIndex = -1;
        }

        function renderResults(items, query) {
            results = items;
            activeIndex = -1;

            if (!items.length) {
                dropdown.innerHTML = '<div class="search-item text-muted small">No stores found for "' + escHtml(query) + '"</div>';
                dropdown.classList.add('show');
                return;
            }

            dropdown.innerHTML = items.map(function (store, i) {
                var logo = store.logo
                    ? '<img src="' + escHtml(store.logo) + '" alt="" class="search-item-logo">'
                    : '<span class="search-item-logo search-item-logo-fallback">' + escHtml(store.name.substring(0, 2).toUpperCase()) + '</span>';

                return '' +
                    '<a href="' + escHtml(store.url) + '" class="search-item" data-index="' + i + '">' +
                        logo +
                        '<span class="flex-grow-1 overflow-hidden">' +
                            '<span class="d-block fw-semibold small text-truncate">' + escHtml(store.name) + '</span>' +
                            '<span class="d-block text-muted text-truncate" style="font-size:.72rem">' + escHtml(store.description || '/' + store.slug) + '</span>' +
                        '</span>' +
                        '<i class="bi bi-arrow-right-short text-muted"></i>' +
                    '</a>';
            }).join('');

            dropdown.classList.add('show');
        }

        function setActive(index) {
            var items = dropdown.querySelectorAll('.search-item');
            items.forEach(function (item, i) {
                item.classList.toggle('active', i === index);
            });
            if (items[index]) {
                items[index].scrollIntoView({ block: 'nearest' });
            }
            activeIndex = index;
        }

        function runSearch(query) {
            if (controller) controller.abort();
            controller = new AbortController();

            fetch(searchUrl + '?q=' + encodeURIComponent(query), { signal: controller.signal })
                .then(function (r) { return r.json(); })
                .then(function (data) { renderResults(data, query); })
                .catch(function (err) {
                    if (err.name !== 'AbortError') closeDropdown();
                });
        }

        input.addEventListener('input', function () {
            var query = this.value.trim();
            clearTimeout(debounceId);

            if (query.length < 2) {
                closeDropdown();
                return;
            }

            debounceId = setTimeout(function () { runSearch(query); }, 250);
        });

        input.addEventListener('keydown', function (e) {
            if (!dropdown.classList.contains('show') || !results.length) return;

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                setActive((activeIndex + 1) % results.length);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                setActive((activeIndex - 1 + results.length) % results.length);
            } else if (e.key === 'Enter') {
                e.preventDefault();
                var target = results[activeIndex] || results[0];
                if (target) window.location.href = target.url;
            } else if (e.key === 'Escape') {
                closeDropdown();
            }
        });

        document.addEventListener('click', function (e) {
            if (!wrap.contains(e.target)) closeDropdown();
        });
    }

    document.querySelectorAll('.nav-search-wrap').forEach(initSearchWidget);

})();
