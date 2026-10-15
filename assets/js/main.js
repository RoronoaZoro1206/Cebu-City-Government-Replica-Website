/**
 * Cebu City Government Portal - Global JavaScript Controller
 * Handles:
 * - Live Philippine Standard Time (PST, UTC+8) Real-Time Clock
 * - Accessibility Toggles (High Contrast & Font Resizing with localStorage persistence)
 * - Global Instant Search Modal (Ctrl + K / Cmd + K) with fuzzy filtering
 * - Floating Back-To-Top button
 */

document.addEventListener('DOMContentLoaded', () => {
    initLivePstClock();
    initAccessibilityToggles();
    initBackToTop();
    initGlobalSearch();
});

/**
 * 1. Live Philippine Standard Time (PST, UTC+8) Clock
 */
function initLivePstClock() {
    const clockEl = document.getElementById('pst-live-clock');
    if (!clockEl) return;

    function updatePst() {
        const now = new Date();
        // Convert to Asia/Manila (UTC+8)
        const options = {
            timeZone: 'Asia/Manila',
            weekday: 'short',
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: 'numeric',
            minute: '2-digit',
            second: '2-digit',
            hour12: true
        };
        try {
            const formatter = new Intl.DateTimeFormat('en-PH', options);
            clockEl.textContent = formatter.format(now);
        } catch (e) {
            clockEl.textContent = now.toLocaleTimeString();
        }
    }

    updatePst();
    setInterval(updatePst, 1000);
}

/**
 * 2. Accessibility Controls
 */
function initAccessibilityToggles() {
    const contrastBtn = document.getElementById('btn-toggle-contrast');
    const fontBtn = document.getElementById('btn-toggle-font');

    // Restore contrast preference
    if (localStorage.getItem('cebu_high_contrast') === 'true') {
        document.body.classList.add('high-contrast');
    }

    // Restore font size preference
    if (localStorage.getItem('cebu_large_font') === 'true') {
        document.body.classList.add('large-font');
    }

    if (contrastBtn) {
        contrastBtn.addEventListener('click', () => {
            const isHigh = document.body.classList.toggle('high-contrast');
            localStorage.setItem('cebu_high_contrast', isHigh ? 'true' : 'false');
        });
    }

    if (fontBtn) {
        fontBtn.addEventListener('click', () => {
            const isLarge = document.body.classList.toggle('large-font');
            localStorage.setItem('cebu_large_font', isLarge ? 'true' : 'false');
        });
    }
}

/**
 * 3. Back to Top Button
 */
function initBackToTop() {
    const btn = document.getElementById('btnBackToTop');
    if (!btn) return;

    window.addEventListener('scroll', () => {
        if (window.scrollY > 200) {
            btn.style.display = 'flex';
        } else {
            btn.style.display = 'none';
        }
    });

    btn.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

/**
 * 4. Global Search Modal (Ctrl + K)
 */
function initGlobalSearch() {
    const searchTrigger = document.getElementById('btn-open-search');
    const searchModalEl = document.getElementById('quickSearchModal');
    const searchInput = document.getElementById('portalSearchInput');
    const resultsContainer = document.getElementById('searchResultsList');

    if (!searchModalEl) return;

    let bootstrapModal = null;
    if (window.bootstrap && window.bootstrap.Modal) {
        bootstrapModal = new bootstrap.Modal(searchModalEl);
    }

    if (searchTrigger && bootstrapModal) {
        searchTrigger.addEventListener('click', () => {
            bootstrapModal.show();
        });
    }

    // Keyboard shortcut (Ctrl + K / Cmd + K)
    document.addEventListener('keydown', (e) => {
        if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
            e.preventDefault();
            if (bootstrapModal) {
                bootstrapModal.show();
            }
        }
    });

    searchModalEl.addEventListener('shown.bs.modal', () => {
        if (searchInput) searchInput.focus();
    });

    // Directory of searchable civic items
    const civicCatalog = [
        { title: 'Business Permits & Licensing (BPLO)', desc: 'New business registration, renewals, and business tax assessment', url: 'services.php#bplo', icon: 'bx-briefcase' },
        { title: 'Real Property Tax (City Assessor & Treasurer)', desc: 'Land declaration, assessment, tax clearances, and payment', url: 'services.php#rpt', icon: 'bx-home' },
        { title: 'Cebu City Medical Center (CCMC)', desc: 'Outpatient consultation, emergency health services, hospital admissions', url: 'services.php#ccmc', icon: 'bx-plus-medical' },
        { title: 'City Health Department (CHD)', desc: 'Barangay health centers, vaccinations, health cards, sanitation permits', url: 'services.php#chd', icon: 'bx-heart' },
        { title: 'Department of Social Welfare & Services (DSWS)', desc: 'Senior citizen aid, solo parents support, burial assistance, crisis intervention', url: 'services.php#dsws', icon: 'bx-user-check' },
        { title: 'Cebu City Transportation Office (CCTO)', desc: 'Traffic violation settlements, vehicle impound release, traffic rerouting', url: 'services.php#ccto', icon: 'bx-car' },
        { title: 'Department of Engineering and Public Works (DEPW)', desc: 'Building permits, road maintenance, drainage requests, public works', url: 'services.php#depw', icon: 'bx-wrench' },
        { title: 'Disaster Risk Reduction Management (CCDRRMO)', desc: '24/7 emergency rescue, flood monitoring, disaster preparedness', url: 'contact-us.php#hotlines', icon: 'bx-shield-quarter' },
        { title: 'Audited Financial Reports (Full Disclosure)', desc: '2024, 2023, and 2022 quarterly budget execution and audit statements', url: 'transparency.php#financial', icon: 'bx-file' },
        { title: 'Manpower Complement & Personnel Budget', desc: 'Civil service plantilla and job order employee complement reports', url: 'transparency.php#manpower', icon: 'bx-group' },
        { title: 'Book an Online City Hall Appointment', desc: 'Schedule an appointment for BPLO, Assessor, CCMC, or Civil Registrar', url: 'services.php#appointment', icon: 'bx-calendar-check' },
        { title: 'Citizen Inquiries & Direct Feedback', desc: 'Submit inquiries, service commendations, or reports to City Hall', url: 'contact-us.php#feedback', icon: 'bx-message-square-detail' }
    ];

    if (searchInput && resultsContainer) {
        searchInput.addEventListener('input', (e) => {
            const query = e.target.value.trim().toLowerCase();
            if (query.length === 0) {
                resultsContainer.innerHTML = '';
                return;
            }

            const matches = civicCatalog.filter(item => 
                item.title.toLowerCase().includes(query) || 
                item.desc.toLowerCase().includes(query)
            );

            if (matches.length === 0) {
                resultsContainer.innerHTML = `
                    <div class="text-center py-4 text-muted">
                        <i class='bx bx-search-alt fs-1 d-block mb-2'></i>
                        No services or documents found matching "<strong>${escapeHtml(query)}</strong>".
                    </div>
                `;
                return;
            }

            let html = '<div class="text-xs text-uppercase fw-bold text-muted mb-2">Matching Services &amp; Documents</div>';
            matches.forEach(item => {
                html += `
                    <a href="${item.url}" class="search-result-item">
                        <div class="d-flex align-items-center gap-3">
                            <i class='bx ${item.icon} fs-4 text-primary'></i>
                            <div>
                                <div class="fw-bold">${highlightMatch(item.title, query)}</div>
                                <small class="text-muted">${highlightMatch(item.desc, query)}</small>
                            </div>
                        </div>
                    </a>
                `;
            });
            resultsContainer.innerHTML = html;
        });
    }

    function escapeHtml(str) {
        return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
    }

    function highlightMatch(text, query) {
        const regex = new RegExp(`(${query})`, 'gi');
        return escapeHtml(text).replace(regex, '<mark class="bg-warning text-dark p-0">$1</mark>');
    }
}
