(function () {
    'use strict';

    /** RTL tables in LTR scroll containers — show the right (reading start) first */
    function scrollToReadingStart(body, top) {
        if (!body) {
            return;
        }

        const maxScroll = Math.max(0, body.scrollWidth - body.clientWidth);

        if (maxScroll <= 0) {
            return;
        }

        body.scrollLeft = maxScroll;
        if (top) {
            top.scrollLeft = maxScroll;
        }
    }

    function initAdminTableScrollSync(wrap) {
        if (wrap.dataset.scrollSyncInit === '1') {
            return;
        }

        const top = wrap.querySelector('.admin-table-scroll-top');
        const topInner = wrap.querySelector('.admin-table-scroll-top-inner');
        const body = wrap.querySelector('.admin-table-scroll-body');
        const table = body ? body.querySelector('table') : null;

        if (!top || !topInner || !body || !table) {
            return;
        }

        wrap.dataset.scrollSyncInit = '1';

        let syncing = false;
        let readingStartApplied = false;

        function syncWidth() {
            topInner.style.width = table.scrollWidth + 'px';
            const needsScroll = table.scrollWidth > body.clientWidth + 1;
            wrap.classList.toggle('admin-table-scroll-active', needsScroll);

            if (needsScroll && !readingStartApplied) {
                scrollToReadingStart(body, top);
                readingStartApplied = true;
            }
        }

        function linkScroll(source, target) {
            source.addEventListener('scroll', function () {
                if (syncing) {
                    return;
                }
                syncing = true;
                target.scrollLeft = source.scrollLeft;
                syncing = false;
            });
        }

        linkScroll(top, body);
        linkScroll(body, top);

        syncWidth();

        requestAnimationFrame(function () {
            if (!readingStartApplied) {
                syncWidth();
            } else {
                scrollToReadingStart(body, top);
            }
        });

        if (typeof ResizeObserver !== 'undefined') {
            const observer = new ResizeObserver(syncWidth);
            observer.observe(table);
            observer.observe(body);
        }

        window.addEventListener('resize', syncWidth);
        window.addEventListener('load', function () {
            scrollToReadingStart(body, top);
        });
    }

    function initAllAdminTableScrollSync() {
        document.querySelectorAll('.admin-table-scroll-wrap').forEach(initAdminTableScrollSync);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAllAdminTableScrollSync);
    } else {
        initAllAdminTableScrollSync();
    }
})();
