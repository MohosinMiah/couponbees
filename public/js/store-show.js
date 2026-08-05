(function () {
    'use strict';

    var CSRF    = COUPON_DATA.csrf;
    var gCopies = COUPON_DATA.totalCopies;
    var gWorked = COUPON_DATA.totalSuccess;
    var gFailed = COUPON_DATA.totalFailure;
    var historyCount = COUPON_DATA.historyCount;

    /* ── helpers ── */
    function el(id) { return document.getElementById(id); }
    function setText(id, val) { var e = el(id); if (e) e.textContent = val; }

    function refreshGlobalStats() {
        var total = gWorked + gFailed;
        var rate  = total > 0 ? Math.round((gWorked / total) * 100) : 0;

        setText('stat-copies', gCopies);
        setText('stat-worked', gWorked);
        setText('stat-failed', gFailed);
        setText('stat-rate',   rate + '%');
        setText('hist-copies', gCopies);
        setText('hist-worked', gWorked);
        setText('hist-failed', gFailed);
        setText('rate-bar-label', rate + '% Success Rate');
        setText('rate-bar-votes', (gWorked + gFailed) + ' total votes');

        var bs = el('rate-bar-success');
        var bf = el('rate-bar-fail');
        if (bs) bs.style.width = rate + '%';
        if (bf) bf.style.width = (100 - rate) + '%';
    }

    function incrementHistoryBadge() {
        historyCount++;
        setText('history-count', historyCount + ' Events');
    }

    function escHtml(str) {
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    function copyToClipboard(text) {
        if (!text) return;
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(text).catch(function () { fallbackCopy(text); });
        } else {
            fallbackCopy(text);
        }
    }

    function fallbackCopy(text) {
        var ta = document.createElement('textarea');
        ta.value = text;
        ta.style.cssText = 'position:fixed;top:-9999px;left:-9999px;opacity:0;';
        document.body.appendChild(ta);
        ta.focus();
        ta.select();
        try { document.execCommand('copy'); } catch (e) {}
        document.body.removeChild(ta);
    }

    function addHistoryRow(code, title, action) {
        var tbody = el('historyTableBody');
        if (!tbody) return;

        var placeholder = el('no-history-row');
        if (placeholder) placeholder.remove();

        var badgeClass, icon, label;
        if (action === 'success') {
            badgeClass = 'bg-success'; icon = 'bi-check-lg'; label = 'Worked';
        } else if (action === 'failure') {
            badgeClass = 'bg-danger'; icon = 'bi-x-lg'; label = 'Failed';
        } else {
            badgeClass = 'bg-secondary'; icon = 'bi-clipboard'; label = 'Copied';
        }

        var codeHtml = code
            ? '<code class="small bg-light px-2 py-1 rounded">' + escHtml(code) + '</code>'
            : '<span class="text-muted small">—</span>';

        var row = document.createElement('tr');
        row.classList.add('history-highlight');
        row.innerHTML =
            '<td class="ps-3 small">' + escHtml(title || '—') + '</td>' +
            '<td>' + codeHtml + '</td>' +
            '<td><span class="badge ' + badgeClass + '"><i class="bi ' + icon + ' me-1"></i>' + label + '</span></td>' +
            '<td class="pe-3 small text-muted text-nowrap">Just now</td>';

        tbody.prepend(row);
        incrementHistoryBadge();
        setTimeout(function () { row.classList.remove('history-highlight'); }, 3000);

        // Keep the list capped at the latest 30 rows.
        while (tbody.children.length > 30) {
            tbody.lastElementChild.remove();
        }
    }

    /* ── COPY BUTTONS ── */
    document.querySelectorAll('.copy-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var couponId     = this.dataset.couponId;
            var code         = this.dataset.code;
            var copyUrl      = this.dataset.copyUrl;
            var affiliateUrl = this.dataset.affiliateUrl;
            var label        = this.querySelector('.btn-label');
            var icon         = this.querySelector('i');

            // Open the store in a named tab so repeat clicks reuse the same
            // tab instead of spawning a new one each time (required for Google Ads).
            // Note: nulling window.opener here would detach the tab from this
            // page's browsing context group and break the name-based reuse below.
            // .focus() is required because re-opening the *same* URL in an
            // already-open named tab is a no-op navigation, so browsers won't
            // reliably bring it back to front on their own past the first click.
            if (affiliateUrl) {
                var storeTab = window.open(affiliateUrl, 'storeAffiliateTab');
                if (storeTab) { storeTab.focus(); }
            }

            this.disabled     = true;
            label.textContent = 'Copying...';
            icon.className    = 'bi bi-hourglass-split me-1';

            fetch(copyUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF,
                    'Accept':       'application/json'
                }
            })
            .then(function (r) {
                if (!r.ok) throw new Error('HTTP ' + r.status);
                return r.json();
            })
            .then(function (data) {
                copyToClipboard(code);

                label.textContent = 'Copied!';
                icon.className    = 'bi bi-check-lg me-1';
                btn.classList.replace('btn-success', 'btn-secondary');

                var badge = el('copied-badge-' + couponId);
                if (badge) badge.classList.remove('d-none');

                var feedbackEl = el('feedback-' + couponId);
                if (feedbackEl) feedbackEl.classList.remove('d-none');

                gCopies++;
                var countEl = el('copy-count-' + couponId);
                if (countEl) {
                    var prev = parseInt(countEl.textContent) || 0;
                    countEl.textContent = (prev + 1) + ' used';
                }

                refreshGlobalStats();
                addHistoryRow(code, data.couponTitle || '', 'copy');
            })
            .catch(function (err) {
                console.error('Copy error:', err);
                btn.disabled      = false;
                label.textContent = 'Copy Code';
                icon.className    = 'bi bi-clipboard me-1';
            });
        });
    });

    /* ── FEEDBACK BUTTONS ── */
    document.querySelectorAll('.feedback-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var couponId    = this.dataset.couponId;
            var worked      = this.dataset.worked === '1';
            var feedbackUrl = this.dataset.feedbackUrl;

            document.querySelectorAll('.feedback-btn[data-coupon-id="' + couponId + '"]')
                    .forEach(function (b) { b.disabled = true; });

            fetch(feedbackUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF,
                    'Accept':       'application/json'
                },
                body: JSON.stringify({ worked: worked })
            })
            .then(function (r) {
                if (!r.ok) throw new Error('HTTP ' + r.status);
                return r.json();
            })
            .then(function (data) {
                var msgEl = el('feedback-msg-' + couponId);
                if (msgEl) {
                    msgEl.classList.remove('d-none', 'text-success', 'text-danger');
                    msgEl.classList.add(data.worked ? 'text-success' : 'text-danger');
                    msgEl.innerHTML = (data.worked
                        ? '<i class="bi bi-check-circle-fill me-1"></i>'
                        : '<i class="bi bi-x-circle-fill me-1"></i>') + escHtml(data.message);
                }

                var statsEl = el('live-stats-' + couponId);
                if (statsEl) {
                    statsEl.querySelector('.sc').textContent = data.successCount;
                    statsEl.querySelector('.fc').textContent = data.failureCount;
                }

                if (data.worked) { gWorked++; } else { gFailed++; }
                refreshGlobalStats();

                var codeEl = el('code-display-' + couponId);
                var code   = codeEl ? codeEl.textContent.trim() : '';
                addHistoryRow(code, data.couponTitle || '', data.worked ? 'success' : 'failure');
            })
            .catch(function (err) {
                console.error('Feedback error:', err);
                document.querySelectorAll('.feedback-btn[data-coupon-id="' + couponId + '"]')
                        .forEach(function (b) { b.disabled = false; });
            });
        });
    });

})();
