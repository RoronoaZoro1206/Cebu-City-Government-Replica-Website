<?php
/**
 * Cebu City Government Portal - Contact Us & Emergency Hotlines
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/db.php';

$pageTitle = 'Contact Us & Emergency Hotlines';
$includeLeaflet = true;
$customCss = 'assets/css/contact-us.css';
$customJs = 'assets/js/contact-us.js';

$citizen = current_user();

require_once __DIR__ . '/includes/header.php';
?>

<!-- Hero Header -->
<section class="contact-hero">
    <div class="container text-center">
        <span class="badge bg-danger text-white px-3 py-1 fw-bold text-uppercase mb-2"><i class='bx bx-phone-call'></i> 24/7 Citizen Response</span>
        <h1 class="fw-bold text-white mb-2">Emergency Hotlines &amp; Citizen Inquiries</h1>
        <p class="text-white-50 mx-auto" style="max-width: 650px;">
            Immediate emergency rescue lines, City Hall department directory, and direct public feedback routing to the Mayor’s Citizen Action Center.
        </p>
    </div>
</section>

<div class="container py-5">
    <!-- Top Emergency Hotlines Grid -->
    <div class="hotline-banner-card mb-5" id="hotlines">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <span class="badge bg-danger text-white px-3 py-1 text-uppercase fw-bold">Emergency Dispatch</span>
                <h3 class="fw-bold text-dark mt-1 mb-0">24/7 Cebu City Emergency Numbers</h3>
                <small class="text-muted">Dial directly from mobile or landline for immediate medical, fire, or rescue dispatch</small>
            </div>
            <div class="text-end d-none d-md-block">
                <span class="badge bg-dark text-white px-3 py-2 fs-6"><i class='bx bx-radio-circle-marked text-danger'></i> Lines Active</span>
            </div>
        </div>

        <div class="row g-3">
            <!-- CCDRRMO -->
            <div class="col-lg-6">
                <div class="hotline-big-row">
                    <div class="hotline-big-icon">
                        <i class='bx bx-plus-medical'></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-bold text-dark">Disaster Risk Reduction &amp; Rescue (CCDRRMO)</div>
                        <small class="text-muted d-block">Ambulance, Flood Rescue, Calamity Response</small>
                        <a href="tel:0322621424" class="hotline-big-phone">(032) 262-1424 / 911</a>
                    </div>
                </div>
            </div>

            <!-- CCMC -->
            <div class="col-lg-6">
                <div class="hotline-big-row">
                    <div class="hotline-big-icon">
                        <i class='bx bx-cross'></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-bold text-dark">Cebu City Medical Center (CCMC) Emergency Room</div>
                        <small class="text-muted d-block">24/7 Tertiary Hospital Triage &amp; Trauma Unit</small>
                        <a href="tel:0322557141" class="hotline-big-phone">(032) 255-7141</a>
                    </div>
                </div>
            </div>

            <!-- CCTO -->
            <div class="col-lg-6">
                <div class="hotline-big-row">
                    <div class="hotline-big-icon">
                        <i class='bx bx-car'></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-bold text-dark">Cebu City Transportation Office (CCTO)</div>
                        <small class="text-muted d-block">Traffic Road Obstruction, Accidents, Towing</small>
                        <a href="tel:0322539211" class="hotline-big-phone">(032) 253-9211</a>
                    </div>
                </div>
            </div>

            <!-- CCPO -->
            <div class="col-lg-6">
                <div class="hotline-big-row">
                    <div class="hotline-big-icon">
                        <i class='bx bx-shield'></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-bold text-dark">Cebu City Police Office (CCPO)</div>
                        <small class="text-muted d-block">Law Enforcement, Tactical Operations Center</small>
                        <a href="tel:166" class="hotline-big-phone">166 / (032) 254-8635</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet.js Interactive City Government Map Section -->
    <section class="interactive-map-section mb-5" id="map-section">
        <div class="map-card-wrapper">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-3">
                <div>
                    <span class="badge bg-primary text-white px-3 py-1 text-uppercase fw-bold"><i class='bx bx-map-pin me-1'></i> Civic Geography &amp; Facility Locator</span>
                    <h3 class="fw-bold text-dark mt-2 mb-0">Interactive Cebu City Government Map</h3>
                    <small class="text-muted">Powered by Leaflet.js &bull; Pinning Cebu City Hall, public hospitals, disaster response centers, and traffic commands</small>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="btnResetMapView" title="Reset Map View">
                        <i class='bx bx-reset me-1'></i> Center City Hall
                    </button>
                    <a href="https://www.google.com/maps/dir/?api=1&destination=10.2934,123.9019" target="_blank" rel="noopener" class="btn btn-sm btn-outline-primary">
                        <i class='bx bx-navigation me-1'></i> Open GPS Directions
                    </a>
                </div>
            </div>

            <!-- Facility Category Filter Buttons -->
            <div class="d-flex flex-wrap gap-2 mb-3" id="mapFilterButtons">
                <button type="button" class="map-filter-btn active" data-filter="all">
                    <i class='bx bx-grid-alt me-1'></i> All Facilities (6)
                </button>
                <button type="button" class="map-filter-btn" data-filter="admin">
                    <i class='bx bx-building me-1'></i> City Hall &amp; Administration
                </button>
                <button type="button" class="map-filter-btn" data-filter="emergency">
                    <i class='bx bx-plus-medical me-1'></i> Emergency &amp; Healthcare
                </button>
                <button type="button" class="map-filter-btn" data-filter="traffic">
                    <i class='bx bx-car me-1'></i> Traffic &amp; Police Command
                </button>
            </div>

            <!-- Leaflet Map Container -->
            <div class="map-container-relative position-relative">
                <div id="cebuCityMap" style="height: 460px; width: 100%; border-radius: 14px; z-index: 1;"></div>
                <div class="map-info-badge d-none d-md-flex align-items-center gap-2">
                    <i class='bx bx-info-circle text-primary'></i>
                    <span>Click any pin or directory card to view office details &amp; driving routes</span>
                </div>
            </div>

            <!-- Facility Directory Cards Carousel/Grid -->
            <div class="row g-3 mt-3" id="facilityCardsGrid">
                <!-- Dynamically rendered or pre-rendered facility cards will be populated here -->
            </div>
        </div>
    </section>

    <!-- Main Content: City Hall Office Info + Feedback Form -->
    <div class="row g-4" id="feedback">
        <!-- Left Column: City Hall Info -->
        <div class="col-lg-5">
            <h4 class="fw-bold text-dark mb-3"><i class='bx bx-building text-primary me-2'></i> Cebu City Hall</h4>
            <div class="info-box-pill">
                <h6 class="fw-bold text-dark mb-1"><i class='bx bx-map text-primary me-2'></i> Main Address</h6>
                <p class="text-muted small mb-0">
                    Cebu City Hall, D. Jakosalem St, Cebu City, 6000 Cebu, Philippines. Located adjacent to the historic Basilica Minore del Santo Niño and Magellan's Cross.
                </p>
            </div>

            <div class="info-box-pill">
                <h6 class="fw-bold text-dark mb-1"><i class='bx bx-time text-success me-2'></i> Official Operating Hours</h6>
                <p class="text-muted small mb-0">
                    Monday to Friday: <strong>8:00 AM – 5:00 PM (PST)</strong><br>
                    (No noon break &bull; Continuous public front-line service)
                </p>
            </div>

            <div class="info-box-pill">
                <h6 class="fw-bold text-dark mb-1"><i class='bx bx-envelope text-warning me-2'></i> Electronic Inquiries</h6>
                <p class="text-muted small mb-0">
                    General Inquiries: <a href="mailto:info@cebucity.gov.ph" class="text-decoration-none">info@cebucity.gov.ph</a><br>
                    Mayor’s Action Desk: <a href="mailto:mayorsoffice@cebucity.gov.ph" class="text-decoration-none">mayorsoffice@cebucity.gov.ph</a>
                </p>
            </div>

            <div class="mt-4">
                <img src="assets/images/Cebu_City_Hall_Cebu_Philippines.jpg" alt="Cebu City Hall" class="img-fluid rounded-4 shadow-sm">
            </div>
        </div>

        <!-- Right Column: Native Citizen Feedback Form -->
        <div class="col-lg-7">
            <div class="feedback-form-card">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="p-2 bg-primary-subtle text-primary rounded-3 fs-3">
                        <i class='bx bx-message-dots'></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0 text-dark">Citizen Feedback &amp; Inquiries</h4>
                        <small class="text-muted">Direct submission to the Mayor's Citizen Action Center</small>
                    </div>
                </div>

                <p class="text-muted small mb-4">
                    Have questions about municipal requirements, service commendations, or reports? Submit your message below. We will review and respond promptly.
                </p>

                <!-- Feedback Response Alert Box -->
                <div id="feedbackResponseAlert" style="display: none;"></div>

                <form id="citizenFeedbackForm">
                    <div class="mb-3">
                        <label class="form-label text-dark small fw-bold" for="feedbackName">Citizen Full Name</label>
                        <input type="text" id="feedbackName" name="name" class="form-control" 
                               placeholder="e.g. Maria Santos" 
                               value="<?= e($citizen['user_username'] ?? ''); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-dark small fw-bold" for="feedbackEmail">Email Address</label>
                        <input type="email" id="feedbackEmail" name="email" class="form-control" 
                               placeholder="name@example.com" 
                               value="<?= e($citizen['user_email'] ?? ''); ?>" required>
                        <div class="form-text" style="font-size: 0.75rem;">We will send our official reply to this email address.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-dark small fw-bold" for="feedbackMessage">Your Message / Inquiry / Feedback</label>
                        <textarea id="feedbackMessage" name="message" class="form-control" rows="5" 
                                  placeholder="Please provide details of your inquiry or feedback..." required></textarea>
                    </div>

                    <button type="submit" class="btn btn-gold w-100 py-3 fw-bold shadow-sm">
                        <i class='bx bx-send me-1'></i> Submit Feedback to Mayor's Desk
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>