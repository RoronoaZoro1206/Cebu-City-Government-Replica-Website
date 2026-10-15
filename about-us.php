<?php
/**
 * Cebu City Government Portal - About Cebu City & Leadership
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/db.php';

$pageTitle = 'About Us - History, Vision & City Leadership';
$customCss = 'assets/css/about-us.css';

require_once __DIR__ . '/includes/header.php';
?>

<!-- Hero Header -->
<section class="about-hero">
    <div class="container text-center">
        <span class="badge bg-warning text-dark px-3 py-1 fw-bold text-uppercase mb-2">Heritage &bull; Leadership &bull; Governance</span>
        <h1 class="fw-bold text-white mb-2">About the City Government of Cebu</h1>
        <p class="text-white-50 mx-auto" style="max-width: 680px;">
            The oldest chartered city and first capital of the Philippines. Discover our rich historical heritage, executive leadership, and mission for modern sustainable civic progress.
        </p>
    </div>
</section>

<div class="container py-5">
    <!-- Mission & Vision Section -->
    <div class="row g-4 mb-5">
        <div class="col-lg-6">
            <div class="mv-card border-top border-4 border-primary">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="p-3 bg-primary-subtle text-primary rounded-circle fs-3">
                        <i class='bx bx-target-lock'></i>
                    </div>
                    <h3 class="fw-bold text-dark mb-0">Our Vision</h3>
                </div>
                <p class="text-muted leading-relaxed mb-0">
                    Cebu City is a vibrant, sustainable, and globally competitive metropolis characterized by god-centered, healthy, and empowered citizens living in safe, flood-resilient communities, driven by an innovative economy and governed by transparent, participatory public servants.
                </p>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="mv-card border-top border-4 border-warning">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="p-3 bg-warning-subtle text-warning-emphasis rounded-circle fs-3">
                        <i class='bx bx-compass'></i>
                    </div>
                    <h3 class="fw-bold text-dark mb-0">Our Mission</h3>
                </div>
                <p class="text-muted leading-relaxed mb-0">
                    To deliver genuine, responsive, and equitable public service (<em>Serbisyong Tinud-anay</em>) by modernizing City Hall infrastructure, guaranteeing accessible healthcare at CCMC, fostering sustainable job creation, maintaining transparent fiscal stewardship, and upholding every citizen’s right to good governance.
                </p>
            </div>
        </div>
    </div>

    <!-- History of Cebu City -->
    <div class="history-timeline-card">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <span class="text-gold fw-bold text-uppercase small letter-spacing-1">Historical Heritage</span>
                <h2 class="fw-bold text-dark mb-3">Queen City of the South</h2>
                <p class="text-muted">
                    Established in 1565 by Spanish explorer Miguel López de Legazpi as <em>Villa del Santísimo Nombre de Jesús</em>, Cebu is the oldest city and the cradle of Christianity in the Philippine archipelago. Located in the heart of Central Visayas, it rapidly blossomed into the economic, maritime, and educational powerhouse of the southern Philippines.
                </p>
                <p class="text-muted">
                    On February 24, 1937, through the legislative advocacy of Don Vicente Rama (Father of the Cebu City Charter), Commonwealth Act No. 58 was enacted, officially conferring cityhood upon Cebu. Today, Cebu City encompasses 80 diverse barangays spanning from urban coastal commercial centers to rolling upland agricultural districts.
                </p>
                <div class="d-flex gap-3">
                    <div class="border-start border-3 border-primary ps-3">
                        <h4 class="fw-bold text-dark mb-0">1565</h4>
                        <small class="text-muted">Founding Year</small>
                    </div>
                    <div class="border-start border-3 border-warning ps-3">
                        <h4 class="fw-bold text-dark mb-0">1937</h4>
                        <small class="text-muted">Charter Day Enactment</small>
                    </div>
                    <div class="border-start border-3 border-success ps-3">
                        <h4 class="fw-bold text-dark mb-0">80</h4>
                        <small class="text-muted">Dynamic Barangays</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <img src="assets/images/Cebu_City_Hall_Cebu_Philippines.jpg" alt="Cebu City Hall Building" class="img-fluid rounded-4 shadow">
            </div>
        </div>
    </div>

    <!-- Executive Leadership Section -->
    <div class="text-center mb-5">
        <span class="text-gold fw-bold text-uppercase small letter-spacing-1">Executive &amp; Legislative</span>
        <h2 class="fw-bold text-dark mt-1">Elected City Government Officials</h2>
        <p class="text-muted mx-auto" style="max-width: 600px;">
            The leadership steering policy, public welfare, and urban development in the City of Cebu.
        </p>
    </div>

    <!-- Mayor and Vice Mayor Row -->
    <div class="row g-4 justify-content-center mb-5">
        <!-- City Mayor -->
        <div class="col-md-5 col-lg-4">
            <div class="leadership-card">
                <img src="assets/images/mayor.png" alt="Mayor of Cebu City" class="leader-portrait">
                <div class="leader-body">
                    <h4 class="leader-name">Hon. Raymond Alvin Garcia</h4>
                    <div class="leader-position">City Mayor</div>
                    <p class="leader-desc">
                        Chief Executive of Cebu City. Leading comprehensive administrative reform, flood infrastructure modernization, and participatory governance.
                    </p>
                </div>
            </div>
        </div>

        <!-- Vice Mayor -->
        <div class="col-md-5 col-lg-4">
            <div class="leadership-card">
                <img src="assets/images/v-mayor.png" alt="Vice Mayor of Cebu City" class="leader-portrait">
                <div class="leader-body">
                    <h4 class="leader-name">Hon. Donaldo Hontiveros</h4>
                    <div class="leader-position">City Vice Mayor</div>
                    <p class="leader-desc">
                        Presiding Officer of the 16th Sangguniang Panlungsod. Championing youth development, sports initiatives, and civic legislation.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Sangguniang Panlungsod / City Council -->
    <h3 class="fw-bold text-dark mb-4 text-center">Sangguniang Panlungsod (City Council)</h3>

    <!-- North District -->
    <h5 class="fw-bold text-primary mb-3"><i class='bx bx-compass'></i> North District Councilors</h5>
    <div class="row g-4 mb-5">
        <div class="col-lg-3 col-md-6 col-6">
            <div class="leadership-card">
                <img src="assets/images/nd-1.png" alt="Councilor North District 1" class="leader-portrait">
                <div class="leader-body">
                    <h5 class="leader-name">Hon. Nestor Archival</h5>
                    <div class="leader-position">North District</div>
                    <p class="leader-desc">Committee on Energy &amp; Transportation</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-6">
            <div class="leadership-card">
                <img src="assets/images/nd-2.png" alt="Councilor North District 2" class="leader-portrait">
                <div class="leader-body">
                    <h5 class="leader-name">Hon. Edgardo Labella II</h5>
                    <div class="leader-position">North District</div>
                    <p class="leader-desc">Committee on Social Services</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-6">
            <div class="leadership-card">
                <img src="assets/images/nd-3.png" alt="Councilor North District 3" class="leader-portrait">
                <div class="leader-body">
                    <h5 class="leader-name">Hon. Joel Garganera</h5>
                    <div class="leader-position">North District</div>
                    <p class="leader-desc">Committee on Environment &amp; CCENRO</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-6">
            <div class="leadership-card">
                <img src="assets/images/nd-4.png" alt="Councilor North District 4" class="leader-portrait">
                <div class="leader-body">
                    <h5 class="leader-name">Hon. Jerry Guardo</h5>
                    <div class="leader-position">North District</div>
                    <p class="leader-desc">Committee on Infrastructure &amp; DEPW</p>
                </div>
            </div>
        </div>
    </div>

    <!-- South District -->
    <h5 class="fw-bold text-warning-emphasis mb-3"><i class='bx bx-compass'></i> South District Councilors</h5>
    <div class="row g-4 mb-5">
        <div class="col-lg-3 col-md-6 col-6">
            <div class="leadership-card">
                <img src="assets/images/sd-1.png" alt="Councilor South District 1" class="leader-portrait">
                <div class="leader-body">
                    <h5 class="leader-name">Hon. Jocelyn Pesquera</h5>
                    <div class="leader-position">South District</div>
                    <p class="leader-desc">Majority Floor Leader &amp; Health</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-6">
            <div class="leadership-card">
                <img src="assets/images/sd-2.png" alt="Councilor South District 2" class="leader-portrait">
                <div class="leader-body">
                    <h5 class="leader-name">Hon. Phillip Zafra</h5>
                    <div class="leader-position">South District</div>
                    <p class="leader-desc">Committee on Public Order &amp; Safety</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-6">
            <div class="leadership-card">
                <img src="assets/images/sd-3.png" alt="Councilor South District 3" class="leader-portrait">
                <div class="leader-body">
                    <h5 class="leader-name">Hon. Francis Esparis</h5>
                    <div class="leader-position">South District</div>
                    <p class="leader-desc">Committee on Barangay Affairs</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-6">
            <div class="leadership-card">
                <img src="assets/images/sd-4.png" alt="Councilor South District 4" class="leader-portrait">
                <div class="leader-body">
                    <h5 class="leader-name">Hon. Renato Osmeña Jr.</h5>
                    <div class="leader-position">South District</div>
                    <p class="leader-desc">Committee on Markets &amp; Trade</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>