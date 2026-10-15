<?php
/**
 * Cebu City Government Portal - Full Disclosure & Transparency Board
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/db.php';

$pageTitle = 'Transparency & Governance - Full Disclosure Board';
$customCss = 'assets/css/transparency.css';
$customJs = 'assets/js/transparency.js';

// Pre-fetch all download counts from PDF_DOWNLOADS table
$statsMap = [];
try {
    $rows = $pdo->query("SELECT * FROM PDF_DOWNLOADS")->fetchAll();
    foreach ($rows as $r) {
        $name = $r['PDF_NAME'] ?? $r['pdf_name'];
        $statsMap[$name] = [
            'count' => (int)($r['PDF_DOWNLOAD_COUNT'] ?? $r['pdf_download_count'] ?? 0),
            'last' => $r['PDF_LAST_DOWNLOADED'] ?? $r['pdf_last_downloaded'] ?? null
        ];
    }
} catch (Throwable $e) {}

$documents = [
    [
        'name' => '2024-Q2 FINANCIAL REPORTS.pdf',
        'title' => '2024 2nd Quarter Audited Financial Statements',
        'category' => 'financial',
        'thumb' => 'assets/images/Financial Report 2024 2nd-quarter.jpg',
        'desc' => 'Quarterly report on city revenue collections, general fund expenditures, and trust fund allocations.'
    ],
    [
        'name' => '2023-2ND QUARTER FINANCIAL REPORTS.pdf',
        'title' => '2023 2nd Quarter Financial Statements',
        'category' => 'financial',
        'thumb' => 'assets/images/Financial Report 2023 2nd-quarter.jpg',
        'desc' => 'Official statement of receipts and expenditures audited under Commission on Audit (COA) guidelines.'
    ],
    [
        'name' => '2022-4th Quarter Financial Reports.pdf',
        'title' => '2022 4th Quarter Annual Financial Report',
        'category' => 'financial',
        'thumb' => 'assets/images/Financial Report 2022 4th-quarter.jpg',
        'desc' => 'Year-end consolidated financial report and balance sheet for the City Government of Cebu.'
    ],
    [
        'name' => '2022 – 2nd Quarter Financial Reports.pdf',
        'title' => '2022 2nd Quarter Financial Report',
        'category' => 'financial',
        'thumb' => 'assets/images/Financial Report 2022 2nd-quarter.jpg',
        'desc' => 'Mid-year financial disclosure detailing barangay project allocations and operational disbursements.'
    ],
    [
        'name' => 'MANPOWER-COMPLEMENT-2024-3RD-QUARTER.pdf',
        'title' => 'Manpower Complement Report - Q3 2024',
        'category' => 'manpower',
        'thumb' => 'assets/images/manpower complement 2024.png',
        'desc' => 'Plantilla of civil service permanent personnel, casual appointments, and contractual job orders.'
    ],
    [
        'name' => 'MANPOWER-COMPLEMENT-2023-2ND-QUARTER.pdf',
        'title' => 'Manpower Complement Report - Q2 2023',
        'category' => 'manpower',
        'thumb' => 'assets/images/manpower complement 2023.png',
        'desc' => 'Civil service personnel budget execution and compensation summary for city departments.'
    ],
    [
        'name' => 'MANPOWER COMPLEMENT BUDGET-2023-1ST QUARTER.pdf',
        'title' => 'Manpower Budget Allocation - Q1 2023',
        'category' => 'manpower',
        'thumb' => 'assets/images/manpower complement 2022.png',
        'desc' => 'Departmental manpower disbursement figures and employee benefits expenditure statement.'
    ],
    [
        'name' => 'MANPOWER-COMPLEMENT-2ND-QUARTER-2022.pdf',
        'title' => 'Manpower Complement Report - Q2 2022',
        'category' => 'manpower',
        'thumb' => 'assets/images/manpower complement 2022 2nd quarter.png',
        'desc' => 'Historical archive of executive and legislative department staffing complements.'
    ],
    [
        'name' => 'Statement of Indebtedness Payments and Balances (SIPB) – Q3.pdf',
        'title' => 'Statement of Indebtedness, Payments & Balances (SIPB)',
        'category' => 'financial',
        'thumb' => 'assets/images/Statement of Indebtedness Payments and Balances (SIPB) – Q3.png',
        'desc' => 'Public debt servicing disclosure, municipal loan amortizations, and balance report.'
    ],
    [
        'name' => 'CCMC – Rate of Services.pdf',
        'title' => 'CCMC Official Schedule of Medical Rates & Services',
        'category' => 'health',
        'thumb' => 'assets/images/Ccmc logo.png',
        'desc' => 'Standardized fee matrix for tertiary hospital inpatient, outpatient, and diagnostic services.'
    ],
    [
        'name' => 'FUN-RIDES-AND-CARNIVAL-VER.4.pdf',
        'title' => 'Carnival & Amusement Bidding Terms (Ver. 4)',
        'category' => 'procurement',
        'thumb' => 'assets/images/Carnival and Circus bidding.png',
        'desc' => 'Bids and Awards Committee (BAC) terms of reference for seasonal city carnival operations.'
    ],
    [
        'name' => 'PERFORMANCIRCUS-VER.-2.pdf',
        'title' => 'Performance Circus Public Procurement (Ver. 2)',
        'category' => 'procurement',
        'thumb' => 'assets/images/SBB for Carnival and Circus Bidding.png',
        'desc' => 'Supplemental Bid Bulletin and compliance guidelines for city public entertainment procurement.'
    ]
];

require_once __DIR__ . '/includes/header.php';
?>

<!-- Hero Section -->
<section class="transparency-hero">
    <div class="container text-center">
        <span class="badge bg-warning text-dark px-3 py-1 fw-bold text-uppercase mb-2">DILG Full Disclosure Policy</span>
        <h1 class="fw-bold text-white mb-2">Transparency &amp; Good Governance</h1>
        <p class="text-white-50 mx-auto mb-4" style="max-width: 680px;">
            In compliance with DILG Memorandum Circulars and Executive Order No. 2 (Freedom of Information), the City Government of Cebu publishes all audited financial records, procurement notices, and manpower complement reports.
        </p>

        <!-- Search input -->
        <div class="mx-auto" style="max-width: 580px;">
            <div class="input-group input-group-lg shadow-sm">
                <span class="input-group-text bg-white border-0"><i class='bx bx-search text-muted'></i></span>
                <input type="text" id="transparencySearch" class="form-control border-0" placeholder="Search official disclosure documents &amp; reports...">
            </div>
        </div>
    </div>
</section>

<div class="container py-5">
    <!-- Interactive Budget Allocation Board -->
    <div class="budget-breakdown-card" id="budget">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
            <div>
                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1">Audited Fiscal Year</span>
                <h3 class="fw-bold text-dark mt-1 mb-0">Cebu City Annual Budget Distribution</h3>
                <small class="text-muted">Total Approved General Appropriation: <strong>₱10,800,000,000.00</strong></small>
            </div>
            <div class="text-end">
                <span class="badge bg-primary px-3 py-2 fs-6">COA Compliant</span>
            </div>
        </div>

        <div class="row g-4">
            <!-- Health & Social Services -->
            <div class="col-md-6">
                <div class="p-3 bg-light rounded-3 border">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="fw-bold text-dark"><i class='bx bx-plus-medical text-danger me-1'></i> Healthcare &amp; Social Services</span>
                        <strong class="text-dark">32% &bull; ₱3.45 Billion</strong>
                    </div>
                    <div class="progress budget-progress-bar">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 32%;" aria-valuenow="32" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <small class="text-muted mt-1 d-block">CCMC Hospital Operations, Barangay Health Centers, Senior Citizen Pensions</small>
                </div>
            </div>

            <!-- Infrastructure & Flood Control -->
            <div class="col-md-6">
                <div class="p-3 bg-light rounded-3 border">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="fw-bold text-dark"><i class='bx bx-building text-primary me-1'></i> Infrastructure &amp; Drainage</span>
                        <strong class="text-dark">28% &bull; ₱3.02 Billion</strong>
                    </div>
                    <div class="progress budget-progress-bar">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 28%;" aria-valuenow="28" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <small class="text-muted mt-1 d-block">River Dredging, Road Concreting, Flood Interceptors, Bridge Upgrades</small>
                </div>
            </div>

            <!-- General Public Administration -->
            <div class="col-md-4">
                <div class="p-3 bg-light rounded-3 border">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="fw-bold text-dark"><i class='bx bx-briefcase text-secondary me-1'></i> General Governance</span>
                        <strong class="text-dark">22% &bull; ₱2.37B</strong>
                    </div>
                    <div class="progress budget-progress-bar">
                        <div class="progress-bar bg-secondary" role="progressbar" style="width: 22%;" aria-valuenow="22" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <small class="text-muted mt-1 d-block">City Hall Operations, Digitization, Tax Admin</small>
                </div>
            </div>

            <!-- Education & Youth -->
            <div class="col-md-4">
                <div class="p-3 bg-light rounded-3 border">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="fw-bold text-dark"><i class='bx bx-book-reader text-warning me-1'></i> Education &amp; Youth</span>
                        <strong class="text-dark">10% &bull; ₱1.08B</strong>
                    </div>
                    <div class="progress budget-progress-bar">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 10%;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <small class="text-muted mt-1 d-block">Scholarships, School Classrooms, Daycare</small>
                </div>
            </div>

            <!-- Disaster Preparedness & Environment -->
            <div class="col-md-4">
                <div class="p-3 bg-light rounded-3 border">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="fw-bold text-dark"><i class='bx bx-shield-quarter text-success me-1'></i> Disaster &amp; Environment</span>
                        <strong class="text-dark">8% &bull; ₱864M</strong>
                    </div>
                    <div class="progress budget-progress-bar">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 8%;" aria-valuenow="8" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <small class="text-muted mt-1 d-block">CCDRRMO Emergency Rescue &amp; CCENRO Clean-up</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Buttons Bar -->
    <div class="d-flex flex-wrap gap-2 justify-content-center mb-4" id="financial">
        <button class="btn btn-outline-dark btn-sm rounded-pill px-3 active doc-filter-btn" data-category="all">All Documents (<?= count($documents); ?>)</button>
        <button class="btn btn-outline-dark btn-sm rounded-pill px-3 doc-filter-btn" data-category="financial">Financial Statements</button>
        <button class="btn btn-outline-dark btn-sm rounded-pill px-3 doc-filter-btn" data-category="manpower">Manpower Complements</button>
        <button class="btn btn-outline-dark btn-sm rounded-pill px-3 doc-filter-btn" data-category="procurement">Procurement &amp; BAC</button>
        <button class="btn btn-outline-dark btn-sm rounded-pill px-3 doc-filter-btn" data-category="health">Hospital Rates</button>
    </div>

    <!-- Document Cards Grid -->
    <div class="row g-4" id="documentsGrid">
        <?php foreach ($documents as $doc): 
            $stat = $statsMap[$doc['name']] ?? ['count' => 0, 'last' => null];
            $count = $stat['count'];
            $lastDownloaded = $stat['last'] ? format_ph_time($stat['last']) : 'Never';
            $pdfPath = 'assets/pdf/' . rawurlencode($doc['name']);
        ?>
            <div class="col-lg-4 col-md-6 doc-item-wrapper" data-category="<?= e($doc['category']); ?>">
                <div class="transparency-doc-card" data-pdf-name="<?= e($doc['name']); ?>">
                    <div>
                        <div class="doc-card-thumb">
                            <img src="<?= e($doc['thumb']); ?>" alt="<?= e($doc['title']); ?>">
                            <span class="doc-badge-pill"><?= strtoupper(e($doc['category'])); ?></span>
                        </div>
                        <div class="doc-body">
                            <h5 class="doc-title"><?= e($doc['title']); ?></h5>
                            <p class="text-muted small mb-0"><?= e($doc['desc']); ?></p>
                        </div>
                    </div>

                    <div class="doc-footer">
                        <div class="download-stats-badge">
                            <div><i class='bx bx-download'></i> Downloads: <strong class="download-count-num"><?= $count; ?></strong></div>
                            <span class="timestamp">Last: <span class="download-time-val"><?= e($lastDownloaded); ?></span></span>
                        </div>
                        <div class="d-flex gap-2">
                            <!-- Preview in Modal -->
                            <button type="button" class="btn btn-sm btn-outline-secondary" 
                                    data-bs-toggle="modal" data-bs-target="#pdfPreviewModal" 
                                    data-pdf-src="<?= $pdfPath; ?>" 
                                    data-pdf-name="<?= e($doc['name']); ?>" 
                                    data-pdf-title="<?= e($doc['title']); ?>" 
                                    title="Preview Document">
                                <i class='bx bx-show'></i>
                            </button>
                            <!-- Direct Download -->
                            <a href="<?= $pdfPath; ?>" download="<?= e($doc['name']); ?>" class="btn btn-sm btn-primary btn-trigger-download" title="Download Official PDF">
                                <i class='bx bx-download'></i> PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- PDF Preview Modal -->
<div class="modal fade" id="pdfPreviewModal" tabindex="-1" aria-labelledby="pdfModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered pdf-modal-dialog modal-xl">
        <div class="modal-content civic-modal">
            <div class="modal-header bg-dark text-white py-3">
                <div class="d-flex align-items-center gap-2">
                    <i class='bx bxs-file-pdf fs-4 text-danger'></i>
                    <h5 class="modal-title fw-bold mb-0 text-white" id="pdfModalTitle">Document Preview</h5>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="#" id="pdfModalDownloadBtn" class="btn btn-sm btn-warning fw-bold" download>
                        <i class='bx bx-download me-1'></i> Download PDF
                    </a>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body p-0" style="background: #2b2b2b;">
                <iframe id="pdfModalIframe" class="pdf-modal-frame" src="about:blank"></iframe>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>