<?php
/**
 * Cebu City Government Portal - Citizen Dashboard
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/security.php';
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/db.php';

require_login('login.php');

$citizen = current_user();
$userId = (int)$citizen['user_id'];

// Fetch user's appointments
$stmtApt = $pdo->prepare("SELECT * FROM APPOINTMENTS WHERE APT_USER_ID = ? OR APT_EMAIL = ? ORDER BY APT_ID DESC");
$stmtApt->execute([$userId, $citizen['user_email']]);
$appointments = $stmtApt->fetchAll();

// Fetch feedback submitted by citizen
$stmtFb = $pdo->prepare("SELECT * FROM FEEDBACK WHERE FB_EMAIL = ? ORDER BY FB_ID DESC LIMIT 5");
$stmtFb->execute([$citizen['user_email']]);
$feedbacks = $stmtFb->fetchAll();

$pageTitle = 'Citizen Portal Dashboard';
require_once __DIR__ . '/includes/header.php';
?>

<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Citizen Portal</li>
        </ol>
    </nav>

    <!-- Welcome Hero -->
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: linear-gradient(135deg, #0B2545 0%, #134074 100%); color: #FFFFFF;">
        <div class="card-body p-4 p-md-5">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-warning text-dark fw-bold d-flex align-items-center justify-content-center shadow" style="width: 64px; height: 64px; font-size: 1.8rem;">
                        <?= strtoupper(substr($citizen['user_username'], 0, 1)); ?>
                    </div>
                    <div>
                        <div class="text-warning small text-uppercase fw-bold letter-spacing-1">Verified Sugboanon Citizen</div>
                        <h2 class="fw-bold mb-1 text-white">Maayong Adlaw, <?= e($citizen['user_username']); ?>!</h2>
                        <div class="text-white-50 small">
                            <i class='bx bx-envelope me-1'></i> <?= e($citizen['user_email']); ?> &bull; 
                            <i class='bx bx-time me-1'></i> Joined <?= format_ph_time($citizen['user_created'] ?? null, 'M d, Y'); ?>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <a href="services.php#appointment" class="btn btn-gold btn-sm px-3 shadow">
                        <i class='bx bx-calendar-plus me-1'></i> Book City Hall Appointment
                    </a>
                    <a href="logout.php" class="btn btn-outline-light btn-sm px-3">
                        <i class='bx bx-log-out me-1'></i> Log Out
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats Grid -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-3 bg-primary-subtle text-primary rounded-3 fs-3">
                        <i class='bx bx-calendar-check'></i>
                    </div>
                    <div>
                        <div class="text-muted small">Active Appointments</div>
                        <h3 class="fw-bold mb-0 text-dark"><?= count($appointments); ?></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-3 bg-success-subtle text-success rounded-3 fs-3">
                        <i class='bx bx-message-square-check'></i>
                    </div>
                    <div>
                        <div class="text-muted small">Inquiries / Feedback Sent</div>
                        <h3 class="fw-bold mb-0 text-dark"><?= count($feedbacks); ?></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-3 bg-warning-subtle text-warning-emphasis rounded-3 fs-3">
                        <i class='bx bx-id-card'></i>
                    </div>
                    <div>
                        <div class="text-muted small">Citizen Verification</div>
                        <h5 class="fw-bold mb-0 text-success"><i class='bx bx-check-circle'></i> Active Level 1</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scheduled Appointments Table -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0 text-dark"><i class='bx bx-calendar text-primary me-2'></i> My City Hall Appointments</h5>
            <a href="services.php#appointment" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                <i class='bx bx-plus'></i> New Appointment
            </a>
        </div>
        <div class="card-body p-0">
            <?php if (empty($appointments)): ?>
                <div class="text-center py-5 text-muted">
                    <i class='bx bx-calendar-x fs-1 d-block mb-2 text-muted'></i>
                    <p class="mb-2">You currently have no scheduled appointments at City Hall.</p>
                    <a href="services.php#appointment" class="btn btn-primary btn-sm">Schedule an Appointment Now</a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light small text-uppercase">
                            <tr>
                                <th class="ps-4">Reference Code</th>
                                <th>Department / Service</th>
                                <th>Date &amp; Time</th>
                                <th>Status</th>
                                <th class="pe-4 text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($appointments as $apt): ?>
                                <tr>
                                    <td class="ps-4">
                                        <span class="badge bg-light text-dark border font-monospace px-2 py-1">
                                            <?= e($apt['APT_REFERENCE_CODE'] ?? $apt['apt_reference_code']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark"><?= e($apt['APT_SERVICE'] ?? $apt['apt_service']); ?></div>
                                        <small class="text-muted"><?= e($apt['APT_NOTES'] ?? $apt['apt_notes'] ?? 'General Consultation'); ?></small>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-dark"><i class='bx bx-calendar text-muted me-1'></i> <?= e($apt['APT_DATE'] ?? $apt['apt_date']); ?></div>
                                        <small class="text-muted"><i class='bx bx-time text-muted me-1'></i> <?= e($apt['APT_TIME'] ?? $apt['apt_time']); ?></small>
                                    </td>
                                    <td>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill">
                                            <i class='bx bx-check'></i> <?= e($apt['APT_STATUS'] ?? $apt['apt_status'] ?? 'Confirmed'); ?>
                                        </span>
                                    </td>
                                    <td class="pe-4 text-end">
                                        <button class="btn btn-sm btn-outline-secondary" onclick="alert('Appointment Reference: <?= e($apt['APT_REFERENCE_CODE'] ?? $apt['apt_reference_code']); ?>\nPlease arrive 15 minutes before your schedule at Cebu City Hall.')">
                                            <i class='bx bx-detail'></i> Details
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Quick Services & Documents Hub -->
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 py-3 px-4">
                    <h5 class="fw-bold mb-0 text-dark"><i class='bx bx-file-blank text-warning me-2'></i> Downloadable Public Documents</h5>
                </div>
                <div class="card-body px-4 pt-0">
                    <p class="text-muted small">Access and download public documents with full disclosure compliance.</p>
                    <div class="list-group list-group-flush">
                        <a href="assets/pdf/MANPOWER-COMPLEMENT-2024-3RD-QUARTER.pdf" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3 border-0 border-bottom" target="_blank">
                            <div>
                                <div class="fw-bold text-dark">Manpower Complement 2024 (Q3)</div>
                                <small class="text-muted">Civil Service Plantilla &amp; Job Order Complement</small>
                            </div>
                            <i class='bx bx-download text-primary fs-4'></i>
                        </a>
                        <a href="assets/pdf/2024-Q2 FINANCIAL REPORTS.pdf" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3 border-0 border-bottom" target="_blank">
                            <div>
                                <div class="fw-bold text-dark">2024 Q2 Audited Financial Reports</div>
                                <small class="text-muted">Official Statement of Receipts &amp; Expenditures</small>
                            </div>
                            <i class='bx bx-download text-primary fs-4'></i>
                        </a>
                        <a href="assets/pdf/CCMC – Rate of Services.pdf" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3 border-0" target="_blank">
                            <div>
                                <div class="fw-bold text-dark">CCMC Schedule of Medical Services &amp; Rates</div>
                                <small class="text-muted">Cebu City Medical Center Hospital Care Rates</small>
                            </div>
                            <i class='bx bx-download text-primary fs-4'></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 py-3 px-4">
                    <h5 class="fw-bold mb-0 text-dark"><i class='bx bx-chat text-info me-2'></i> Recent Inquiries / Feedback</h5>
                </div>
                <div class="card-body px-4 pt-0">
                    <?php if (empty($feedbacks)): ?>
                        <div class="text-center py-4 text-muted">
                            <p class="mb-2">You haven't submitted any inquiries yet.</p>
                            <a href="contact-us.php#feedback" class="btn btn-outline-info btn-sm">Send an Inquiry or Feedback</a>
                        </div>
                    <?php else: ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($feedbacks as $fb): ?>
                                <div class="list-group-item py-3 border-0 border-bottom">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="badge bg-light text-dark border">Cebu City Helpdesk</span>
                                        <small class="text-muted"><?= format_ph_time($fb['FB_CREATED_AT'] ?? $fb['fb_created_at'] ?? null); ?></small>
                                    </div>
                                    <p class="mb-0 text-dark small"><?= e($fb['FB_MESSAGE'] ?? $fb['fb_message']); ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
