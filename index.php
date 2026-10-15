<?php
/**
 * Cebu City Government Portal - Civic Homepage
 * Serbisyong Tinud-anay, Katungod sa Katawhan
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/db.php';

$pageTitle = 'Home - Official Portal';
$customCss = 'assets/css/index.css';

require_once __DIR__ . '/includes/header.php';
?>

<!-- Live Civic Advisory Ticker -->
<div class="civic-ticker-bar">
    <div class="container d-flex align-items-center gap-3">
        <span class="ticker-label"><i class='bx bxs-megaphone me-1'></i> ADVISORY</span>
        <div class="ticker-viewport" role="region" aria-label="City Advisories">
            <div class="ticker-track">
                <span class="ticker-item"><i class='bx bx-bell text-warning me-1'></i> Cebu City Government launches unified digital citizen appointments.</span>
                <span class="ticker-separator">&bull;</span>
                <span class="ticker-item"><i class='bx bx-droplet text-info me-1'></i> CCDRRMO implements dry season contingency water container distribution in upland barangays.</span>
                <span class="ticker-separator">&bull;</span>
                <span class="ticker-item"><i class='bx bx-credit-card text-success me-1'></i> Cashless payment kiosks now operational at Cebu City Hall legislative lobby.</span>
                <span class="ticker-separator">&bull;</span>
                <span class="ticker-item"><i class='bx bx-plus-medical text-danger me-1'></i> CCMC 24/7 Outpatient &amp; Emergency Department open to all residents.</span>
            </div>
        </div>
    </div>
</div>

<!-- Hero Banner Section -->
<section class="civic-hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="hero-badge-pill">
                    <i class='bx bxs-badge-check'></i> Queen City of the South &bull; Founded 1565
                </div>
                <h1 class="hero-title">
                    Serbisyong Tinud-anay, <br>
                    <span class="text-gold">Katungod sa Katawhan.</span>
                </h1>
                <p class="hero-subtitle">
                    Welcome to the official digital portal of the City Government of Cebu. Transact with city departments, view full transparency audits, schedule appointments, and access vital citizen services online.
                </p>
                <div class="hero-cta-group">
                    <a href="services.php" class="btn btn-gold btn-lg px-4 shadow">
                        <i class='bx bx-grid-alt me-1'></i> Browse City Services
                    </a>
                    <a href="services.php#appointment" class="btn btn-outline-portal btn-lg px-4">
                        <i class='bx bx-calendar-check me-1'></i> Book Appointment
                    </a>
                    <a href="transparency.php" class="btn btn-outline-light btn-lg px-3">
                        <i class='bx bx-file me-1'></i> Full Disclosure Board
                    </a>
                </div>
            </div>
            <div class="col-lg-4 d-none d-lg-block text-center">
                <img src="assets/images/header logo mayor and vice mayor.png" alt="Cebu City Leadership Emblem" class="img-fluid" style="max-height: 280px; filter: drop-shadow(0 10px 20px rgba(0,0,0,0.4));">
            </div>
        </div>
    </div>
</section>

<!-- Citizen Quick E-Services Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <span class="text-gold fw-bold text-uppercase small letter-spacing-1">City Hall at Your Fingertips</span>
            <h2 class="fw-bold mt-1 text-dark">Most Requested Citizen Services</h2>
            <p class="text-muted mx-auto" style="max-width: 620px;">
                Direct access to Cebu City government departments, permits, clearances, and emergency welfare assistance.
            </p>
        </div>

        <div class="row g-4">
            <!-- Service 1: Business Permits -->
            <div class="col-lg-4 col-md-6">
                <a href="services.php#bplo" class="civic-service-card">
                    <div>
                        <div class="service-icon-box service-icon-blue">
                            <i class='bx bx-briefcase-alt-2'></i>
                        </div>
                        <h4 class="service-card-title">Business Permits (BPLO)</h4>
                        <p class="service-card-desc">
                            Apply for new business registrations, annual renewals, and gross sales assessments with the Business Permit and Licensing Office.
                        </p>
                    </div>
                    <div class="service-card-link">
                        Access BPLO Services <i class='bx bx-right-arrow-alt'></i>
                    </div>
                </a>
            </div>

            <!-- Service 2: Real Property Tax -->
            <div class="col-lg-4 col-md-6">
                <a href="services.php#rpt" class="civic-service-card">
                    <div>
                        <div class="service-icon-box service-icon-gold">
                            <i class='bx bx-home-alt'></i>
                        </div>
                        <h4 class="service-card-title">Real Property Tax (Assessor)</h4>
                        <p class="service-card-desc">
                            Inquire about real property tax declarations, tax clearances, and payment schedules under the City Assessor &amp; City Treasurer.
                        </p>
                    </div>
                    <div class="service-card-link">
                        Calculate Property Tax <i class='bx bx-right-arrow-alt'></i>
                    </div>
                </a>
            </div>

            <!-- Service 3: CCMC Hospital & Health -->
            <div class="col-lg-4 col-md-6">
                <a href="services.php#ccmc" class="civic-service-card">
                    <div>
                        <div class="service-icon-box service-icon-green">
                            <i class='bx bx-plus-medical'></i>
                        </div>
                        <h4 class="service-card-title">Cebu City Medical Center</h4>
                        <p class="service-card-desc">
                            24/7 emergency care, outpatient consultations, diagnostic laboratory schedules, and healthcare subsidy programs for residents.
                        </p>
                    </div>
                    <div class="service-card-link">
                        View Hospital Services <i class='bx bx-right-arrow-alt'></i>
                    </div>
                </a>
            </div>

            <!-- Service 4: Social Assistance -->
            <div class="col-lg-4 col-md-6">
                <a href="services.php#dsws" class="civic-service-card">
                    <div>
                        <div class="service-icon-box service-icon-purple">
                            <i class='bx bx-user-check'></i>
                        </div>
                        <h4 class="service-card-title">Social Welfare &amp; Aid (DSWS)</h4>
                        <p class="service-card-desc">
                            Senior citizen financial assistance, solo parent benefits, medical burial aid, and emergency crisis intervention programs.
                        </p>
                    </div>
                    <div class="service-card-link">
                        Check DSWS Programs <i class='bx bx-right-arrow-alt'></i>
                    </div>
                </a>
            </div>

            <!-- Service 5: Traffic & Transportation -->
            <div class="col-lg-4 col-md-6">
                <a href="services.php#ccto" class="civic-service-card">
                    <div>
                        <div class="service-icon-box service-icon-red">
                            <i class='bx bx-car'></i>
                        </div>
                        <h4 class="service-card-title">Traffic &amp; Impounding (CCTO)</h4>
                        <p class="service-card-desc">
                            Pay traffic violation citations, process impounded vehicle releases, request traffic management, and view road rerouting advisories.
                        </p>
                    </div>
                    <div class="service-card-link">
                        CCTO Traffic Office <i class='bx bx-right-arrow-alt'></i>
                    </div>
                </a>
            </div>

            <!-- Service 6: Engineering & Public Works -->
            <div class="col-lg-4 col-md-6">
                <a href="services.php#depw" class="civic-service-card">
                    <div>
                        <div class="service-icon-box service-icon-teal">
                            <i class='bx bx-hard-hat'></i>
                        </div>
                        <h4 class="service-card-title">Engineering &amp; Works (DEPW)</h4>
                        <p class="service-card-desc">
                            Building permits, drainage unclogging requests, street lighting maintenance, and infrastructure development projects.
                        </p>
                    </div>
                    <div class="service-card-link">
                        Request Public Works <i class='bx bx-right-arrow-alt'></i>
                    </div>
                </a>
            </div>
        </div>

        <div class="text-center mt-5">
            <a href="services.php" class="btn btn-outline-primary px-4 py-2 fw-semibold rounded-pill">
                View Complete Directory of 24+ City Services &rarr;
            </a>
        </div>
    </div>
</section>

<!-- Mayor's Desk & Leadership Spotlight -->
<section class="py-5 bg-white border-top border-bottom">
    <div class="container">
        <div class="mayors-corner-card">
            <div class="row g-0 align-items-center">
                <div class="col-lg-5">
                    <div class="official-portrait-frame">
                        <img src="assets/images/mayor.png" alt="Mayor of Cebu City" class="img-fluid">
                        <div class="official-title-tag">
                            <h4 class="fw-bold mb-0 text-white">Office of the City Mayor</h4>
                            <small class="text-gold">City Government of Cebu &bull; Executive Branch</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 p-4 p-md-5">
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-1 mb-3">
                        <i class='bx bx-crown'></i> Executive Message
                    </span>
                    <h2 class="fw-bold text-dark mb-3">“Padayon sa Kalambuan sa Sugbo”</h2>
                    <p class="text-muted">
                        The City Government of Cebu remains steadfast in its mandate to deliver prompt, honest, and compassionate public service. We are accelerating the digitalization of City Hall transactions, ensuring that every Sugboanon can access government permits, social subsidies, and healthcare without bureaucratic delay.
                    </p>
                    <p class="text-muted">
                        Through total fiscal transparency and responsible stewardship of public funds, we ensure that every peso is accounted for and directly benefits our 80 barangays.
                    </p>
                    <div class="d-flex flex-wrap gap-3 mt-4">
                        <a href="about-us.php" class="btn btn-primary fw-semibold px-4">
                            <i class='bx bx-user me-1'></i> Meet the City Council &amp; Officials
                        </a>
                        <a href="transparency.php" class="btn btn-outline-secondary fw-semibold px-4">
                            <i class='bx bx-check-shield me-1'></i> City Transparency Board
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Civic Impact Statistics -->
<section class="py-5">
    <div class="container">
        <div class="stats-strip">
            <div class="row g-4">
                <div class="col-md-3 col-6 stat-item">
                    <div class="stat-number">₱10.8B</div>
                    <div class="stat-label">Annual City Budget</div>
                </div>
                <div class="col-md-3 col-6 stat-item">
                    <div class="stat-number">80</div>
                    <div class="stat-label">Barangays Served</div>
                </div>
                <div class="col-md-3 col-6 stat-item">
                    <div class="stat-number">100%</div>
                    <div class="stat-label">Full Disclosure Compliant</div>
                </div>
                <div class="col-md-3 col-6 stat-item">
                    <div class="stat-number">24/7</div>
                    <div class="stat-label">Emergency Readiness</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Interactive Map Feature Callout -->
<section class="py-4 bg-light border-top border-bottom">
    <div class="container">
        <div class="row align-items-center justify-content-between g-3">
            <div class="col-lg-8 d-flex align-items-center gap-3">
                <div class="p-3 bg-primary text-white rounded-3 fs-3 flex-shrink-0 shadow-sm">
                    <i class='bx bx-map-pin'></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-1 text-dark">Locate Cebu City Government Offices &amp; Emergency Centers</h5>
                    <p class="text-muted small mb-0">Access our Leaflet interactive GPS map to locate Cebu City Hall, CCMC Emergency Room, CCDRRMO Rescue Command, and CCTO Traffic Office with live driving directions.</p>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="contact-us.php#map-section" class="btn btn-primary px-4 py-2 fw-bold shadow-sm">
                    <i class='bx bx-map-alt me-1'></i> Open Interactive Map &rarr;
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Latest City Announcements & News -->
<section class="py-5 bg-white border-top">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="text-gold fw-bold text-uppercase small">News &amp; Updates</span>
                <h2 class="fw-bold text-dark mb-0">Official City Announcements</h2>
            </div>
            <a href="events.php" class="text-primary fw-bold text-decoration-none">
                View All Announcements &rarr;
            </a>
        </div>

        <div class="row g-4">
            <!-- News Item 1 -->
            <div class="col-lg-4 col-md-6">
                <div class="civic-news-card">
                    <img src="assets/images/Cebu City acts on them with P45.7M projects.png" alt="Cebu City P45.7M projects" class="news-thumb">
                    <div class="news-body">
                        <span class="news-tag">Infrastructure</span>
                        <h4 class="news-title">City Hall Approves ₱45.7M Projects for Drainage and Road Upgrades</h4>
                        <p class="news-summary">
                            Targeted infrastructure programs commence across low-lying barangays to improve stormwater management and mitigate flood risks ahead of the rainy season.
                        </p>
                        <a href="events.php#announcements" class="fw-semibold text-primary text-decoration-none">
                            Read Full Details &amp; Citizen Comments &rarr;
                        </a>
                    </div>
                </div>
            </div>

            <!-- News Item 2 -->
            <div class="col-lg-4 col-md-6">
                <div class="civic-news-card">
                    <img src="assets/images/Cashless payment at City Hall soon.png" alt="Cashless Payment at City Hall" class="news-thumb">
                    <div class="news-body">
                        <span class="news-tag">Digital Governance</span>
                        <h4 class="news-title">City Hall Integrates Cashless Payment Kiosks for Tax &amp; Permits</h4>
                        <p class="news-summary">
                            Sugboanons can now pay real property taxes, business renewals, and traffic citations via GCash, Maya, and online debit/credit portals for faster clearing.
                        </p>
                        <a href="events.php#announcements" class="fw-semibold text-primary text-decoration-none">
                            Read Full Details &amp; Citizen Comments &rarr;
                        </a>
                    </div>
                </div>
            </div>

            <!-- News Item 3 -->
            <div class="col-lg-4 col-md-6">
                <div class="civic-news-card">
                    <img src="assets/images/City Hall starts implementing contingencies for dry season.png" alt="Dry season contingencies" class="news-thumb">
                    <div class="news-body">
                        <span class="news-tag">Public Advisory</span>
                        <h4 class="news-title">Contingency Measures Implemented for Upland Barangay Water Supply</h4>
                        <p class="news-summary">
                            CCDRRMO and the City Agriculture Department deploy mobile water tankers and storage tanks to assist farming communities in the mountain districts.
                        </p>
                        <a href="events.php#announcements" class="fw-semibold text-primary text-decoration-none">
                            Read Full Details &amp; Citizen Comments &rarr;
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
