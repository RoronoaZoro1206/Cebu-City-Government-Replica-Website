<?php
/**
 * Cebu City Government Portal - Events & Announcements
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/db.php';

$pageTitle = 'Events & City Announcements';
$customCss = 'assets/css/events.css';
$customJs = 'assets/js/events.js';

$citizen = current_user();

$events = [
    [
        'id' => 1,
        'title' => 'Sinulog Festival 2026: Grand Parade & Cultural Festivities',
        'category' => 'Cultural Heritage',
        'date' => 'Third Sunday of January 2026',
        'location' => 'SRP Grandstand & Cebu City Sports Center',
        'image' => 'assets/images/charter day city hall.jpg',
        'preview' => 'Pit Senyor! The City Government of Cebu, together with the Sinulog Foundation Inc. (SFI), officially unveils the route and security staging for the world-renowned Sinulog Festival 2026.',
        'full' => 'Pit Senyor! The City Government of Cebu, together with the Sinulog Foundation Inc. (SFI), officially unveils the route and security staging for the world-renowned Sinulog Festival 2026. Over 3 million pilgrims, devotees, and tourists are expected to witness the Grand Ritual Dance Competition at the South Road Properties (SRP) and the historic street parade passing through Osmeña Boulevard. Comprehensive crowd management, medical stations by CCMC and CCDRRMO, and free public shuttle services will be active 24/7.'
    ],
    [
        'id' => 2,
        'title' => '89th Cebu City Charter Day Celebration & Citywide Medical Mission',
        'category' => 'Civic Commemoration',
        'date' => 'February 24, 2026 &bull; 8:00 AM',
        'location' => 'Plaza Sugbo & Cebu City Hall Grounds',
        'image' => 'assets/images/cebala.jpg',
        'preview' => 'Commemorating the Commonwealth Act signed by Don Vicente Rama establishing Cebu as a chartered city on February 24, 1937 with free public medical and dental services.',
        'full' => 'Commemorating the Commonwealth Act signed by Don Vicente Rama establishing Cebu as a chartered city on February 24, 1937 with free public medical and dental services. City Hall offices will join the civic parade and testimonial dinner honoring outstanding institutions and individuals. Free eye checks, dental extractions, and pediatric medicines will be distributed by CCMC and the City Health Department throughout the day.'
    ],
    [
        'id' => 3,
        'title' => '₱45.7M Infrastructure Package for Flood Interceptors & Drainage',
        'category' => 'Public Works',
        'date' => 'March 2026 Advisory',
        'location' => 'Bulacao, Lahug, and Tejero River Basins',
        'image' => 'assets/images/Cebu City acts on them with P45.7M projects.png',
        'preview' => 'The Department of Engineering and Public Works (DEPW) launches major civil works to widen drainage outlets and dredge low-lying flood channels.',
        'full' => 'The Department of Engineering and Public Works (DEPW) launches major civil works to widen drainage outlets and dredge low-lying flood channels. This comprehensive package includes desilting Lahug River, upgrading box culverts along Colon and Sanciangko streets, and installing smart water level monitoring sensors connected to the CCDRRMO Command Center.'
    ],
    [
        'id' => 4,
        'title' => 'City Hall Activates Cashless Payment Kiosks for Tax & Permits',
        'category' => 'E-Governance',
        'date' => 'Active Now',
        'location' => 'Legislative Building & Online Portal',
        'image' => 'assets/images/Cashless payment at City Hall soon.png',
        'preview' => 'Sugboanons can now pay real property taxes, business license renewals, and traffic violation citations digitally via GCash, Maya, and online bank transfer.',
        'full' => 'Sugboanons can now pay real property taxes, business license renewals, and traffic violation citations digitally via GCash, Maya, and online bank transfer. In line with the Anti-Red Tape Authority (ARTA) Ease of Doing Business mandates, self-service automated kiosks are deployed at the City Hall lobby to reduce queuing time to under 5 minutes.'
    ],
    [
        'id' => 5,
        'title' => 'Dry Season Water Relief Measures for Upland Farming Communities',
        'category' => 'Disaster Preparedness',
        'date' => 'Ongoing Operation',
        'location' => 'Transcentral Highway & Mountain Barangays',
        'image' => 'assets/images/City Hall starts implementing contingencies for dry season.png',
        'preview' => 'CCDRRMO deploys 10,000-liter water tankers and distributes durable high-density polyethylene (HDPE) water containers to agricultural households.',
        'full' => 'CCDRRMO deploys 10,000-liter water tankers and distributes durable high-density polyethylene (HDPE) water containers to agricultural households. The City Agriculture Department has allocated drought-resistant crop seeds and biological irrigation equipment to safeguard vegetable producers in Sirao, Busay, Malubog, and Adlaon.'
    ]
];

require_once __DIR__ . '/includes/header.php';
?>

<!-- Hero Header -->
<section class="events-hero">
    <div class="container text-center">
        <span class="badge bg-warning text-dark px-3 py-1 fw-bold text-uppercase mb-2">Public Information Office</span>
        <h1 class="fw-bold text-white mb-2">City Events &amp; Official Announcements</h1>
        <p class="text-white-50 mx-auto" style="max-width: 650px;">
            Stay informed on city government programs, civic holidays, public advisories, and participate in open citizen discussions.
        </p>
    </div>
</section>

<div class="container py-5" id="announcements">
    <div class="row g-4">
        <!-- Left: Events Feed -->
        <div class="col-lg-7">
            <h3 class="fw-bold text-dark mb-4"><i class='bx bx-news text-primary me-2'></i> Latest City Advisories</h3>

            <?php foreach ($events as $ev): ?>
                <div class="event-card">
                    <img src="<?= e($ev['image']); ?>" alt="<?= e($ev['title']); ?>" class="event-card-img">
                    <div class="event-card-body">
                        <div class="event-meta-strip">
                            <span class="event-badge-category"><?= e($ev['category']); ?></span>
                            <span><i class='bx bx-calendar text-muted me-1'></i> <?= e($ev['date']); ?></span>
                            <span><i class='bx bx-map-pin text-muted me-1'></i> <?= e($ev['location']); ?></span>
                        </div>
                        <h4 class="event-title"><?= e($ev['title']); ?></h4>
                        
                        <div class="event-text event-preview-text">
                            <?= e($ev['preview']); ?>
                        </div>
                        <div class="event-text event-full-text" style="display: none;">
                            <?= e($ev['full']); ?>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                            <button type="button" class="btn btn-sm btn-link text-primary text-decoration-none p-0 fw-semibold btn-read-more-toggle">
                                Read More <i class='bx bx-chevron-down'></i>
                            </button>

                            <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 btn-open-discussion" 
                                    data-event-id="<?= $ev['id']; ?>" 
                                    data-event-title="<?= e($ev['title']); ?>">
                                <i class='bx bx-chat me-1'></i> Citizen Discussion
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Right: Threaded Comments & Citizen Discussion -->
        <div class="col-lg-5" id="citizenDiscussionSection">
            <div class="comments-container-box sticky-top" style="top: 90px;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class='bx bx-conversation text-primary me-2'></i> Citizen Forum
                    </h5>
                    <span class="badge bg-light text-dark border">Public Forum</span>
                </div>

                <div class="alert alert-light border small text-muted mb-3 py-2">
                    Discussing: <strong class="text-dark" id="discussionEventTitle">Sinulog Festival 2026: Grand Parade &amp; Cultural Festivities</strong>
                </div>

                <!-- Live Threaded Comments List -->
                <div id="commentList" class="mb-4" style="max-height: 480px; overflow-y: auto; padding-right: 6px;">
                    <!-- Injected dynamically via api/load_comments.php -->
                </div>

                <!-- Replying indicator -->
                <div id="replyingToNotice" class="alert alert-warning py-1 px-3 small mb-2 d-flex justify-content-between align-items-center" style="display: none;">
                    <span>Replying to <strong id="replyUsernameText">User</strong></span>
                    <button type="button" class="btn-close btn-sm p-0" id="btnCancelReply" aria-label="Cancel reply"></button>
                </div>

                <!-- Submit Comment Form -->
                <form id="commentForm" class="comment-input-card">
                    <input type="hidden" name="event_id" id="event_id" value="1">
                    <input type="hidden" name="parent_id" id="parent_id" value="">

                    <div class="mb-2">
                        <label class="form-label small fw-bold text-dark mb-1">Your Name</label>
                        <input type="text" name="username" id="username" class="form-control form-control-sm" 
                               placeholder="e.g. Maria Santos" 
                               value="<?= e($citizen['user_username'] ?? ''); ?>" 
                               <?= $citizen ? 'readonly' : ''; ?> required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label small fw-bold text-dark mb-1">Citizen Comment / Inquiries</label>
                        <textarea name="comment" id="comment" class="form-control form-control-sm" rows="3" placeholder="Share your constructive thoughts on this announcement..." maxlength="1000" required></textarea>
                        <div class="form-text text-end" style="font-size: 0.7rem;">Max 1,000 characters &bull; Moderated forum</div>
                    </div>

                    <button type="submit" class="btn btn-gold btn-sm w-100 fw-bold">
                        <i class='bx bx-send me-1'></i> Post Comment
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>