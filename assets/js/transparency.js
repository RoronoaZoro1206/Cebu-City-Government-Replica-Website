/**
 * Cebu City Government Portal - Transparency & Full Disclosure Controller
 * Handles:
 * - Live PDF download stats fetching and increment tracking
 * - In-browser PDF modal preview
 * - Category and keyword document filtering
 */

document.addEventListener('DOMContentLoaded', () => {
    initPdfDownloadTracking();
    initDocFiltering();
    initPdfPreviewModal();
});

function initPdfDownloadTracking() {
    const docCards = document.querySelectorAll('.transparency-doc-card');

    docCards.forEach(card => {
        const pdfName = card.getAttribute('data-pdf-name');
        if (!pdfName) return;

        // Fetch current count & last downloaded time
        fetch(`api/track_download.php?pdf=${encodeURIComponent(pdfName)}&_t=${Date.now()}`)
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const countEl = card.querySelector('.download-count-num');
                    const timeEl = card.querySelector('.download-time-val');
                    if (countEl) countEl.textContent = data.count;
                    if (timeEl) timeEl.textContent = data.last_downloaded || 'Never';
                }
            })
            .catch(err => console.error("Error loading PDF stats:", err));

        // Track when user clicks download button
        const dlBtn = card.querySelector('.btn-trigger-download');
        if (dlBtn) {
            dlBtn.addEventListener('click', () => {
                const formData = new FormData();
                formData.append('pdf', pdfName);

                fetch('api/track_download.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success && data.count !== undefined) {
                        const countEl = card.querySelector('.download-count-num');
                        const timeEl = card.querySelector('.download-time-val');
                        if (countEl) countEl.textContent = data.count;
                        if (timeEl) timeEl.textContent = data.last_downloaded || 'Just now';
                    }
                })
                .catch(err => console.error("Error tracking download:", err));
            });
        }
    });
}

function initPdfPreviewModal() {
    const previewModalEl = document.getElementById('pdfPreviewModal');
    const iframe = document.getElementById('pdfModalIframe');
    const modalTitle = document.getElementById('pdfModalTitle');
    const modalDlBtn = document.getElementById('pdfModalDownloadBtn');

    if (!previewModalEl || !iframe) return;

    previewModalEl.addEventListener('show.bs.modal', (e) => {
        const trigger = e.relatedTarget;
        if (!trigger) return;

        const pdfSrc = trigger.getAttribute('data-pdf-src');
        const pdfTitle = trigger.getAttribute('data-pdf-title');
        const pdfName = trigger.getAttribute('data-pdf-name');

        if (modalTitle) modalTitle.textContent = pdfTitle || 'Document Preview';
        if (modalDlBtn) {
            modalDlBtn.setAttribute('href', pdfSrc);
            modalDlBtn.setAttribute('download', pdfName);
        }

        iframe.src = pdfSrc;
    });

    previewModalEl.addEventListener('hidden.bs.modal', () => {
        iframe.src = 'about:blank';
    });
}

function initDocFiltering() {
    const filterBtns = document.querySelectorAll('.doc-filter-btn');
    const searchInput = document.getElementById('transparencySearch');
    const docItems = document.querySelectorAll('.doc-item-wrapper');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            filterBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            const category = btn.getAttribute('data-category');
            applyFilters();
        });
    });

    if (searchInput) {
        searchInput.addEventListener('input', applyFilters);
    }

    function applyFilters() {
        const activeBtn = document.querySelector('.doc-filter-btn.active');
        const activeCategory = activeBtn ? activeBtn.getAttribute('data-category') : 'all';
        const query = searchInput ? searchInput.value.toLowerCase().trim() : '';

        docItems.forEach(item => {
            const itemCategory = item.getAttribute('data-category');
            const itemTitle = (item.querySelector('.doc-title')?.textContent || '').toLowerCase();

            const matchesCategory = (activeCategory === 'all' || itemCategory === activeCategory);
            const matchesQuery = (query === '' || itemTitle.includes(query));

            if (matchesCategory && matchesQuery) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }
}
