<?php
/**
 * Cebu City Government Portal - Global Header Component
 * Incorporates:
 * - Official GovPH Philippine Standard Time (PST) Topbar
 * - Bagong Pilipinas & City of Cebu Brand Identity
 * - Modern Responsive Navigation with Citizen Portal state
 * - Quick Search Modal trigger
 * - Accessibility controls (contrast & text scale)
 */

declare(strict_types=1);

require_once __DIR__ . '/security.php';
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/helpers.php';

$pageTitle = $pageTitle ?? 'Cebu City Government Portal';
$activePage = basename($_SERVER['PHP_SELF'] ?? '');
$citizen = current_user();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Official Portal of the City Government of Cebu - Serbisyong Tinud-anay, Katungod sa Katawhan. Access public services, transparency reports, and civic updates.">
    <meta name="theme-color" content="#0B2545">

    <!-- Open Graph / Meta -->
    <meta property="og:title" content="<?= e($pageTitle); ?> - Cebu City Government">
    <meta property="og:description" content="Access online services, full disclosure transparency documents, and city announcements.">
    <meta property="og:image" content="assets/images/Cebu City Icon.png">
    <meta property="og:type" content="website">

    <title><?= e($pageTitle); ?> - Cebu City Government</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/images/Cebu City Icon.png">

    <!-- Google Fonts: Inter & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- Boxicons CSS -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Core Custom Design System CSS -->
    <link rel="stylesheet" href="assets/css/main.css?v=<?= file_exists(__DIR__ . '/../assets/css/main.css') ? filemtime(__DIR__ . '/../assets/css/main.css') : time(); ?>">
    
    <!-- Leaflet.js Mapping Library (loaded on pages with maps) -->
    <?php if (!empty($includeLeaflet)): ?>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
    <?php endif; ?>

    <!-- Page Specific Stylesheet (if provided) -->
    <?php if (!empty($customCss)): ?>
        <link rel="stylesheet" href="<?= e($customCss); ?>?v=<?= file_exists(__DIR__ . '/../' . $customCss) ? filemtime(__DIR__ . '/../' . $customCss) : time(); ?>">
    <?php endif; ?>
</head>
<body>

    <!-- GovPH / Official National Bar -->
    <div class="govph-topbar">
        <div class="container d-flex flex-wrap justify-content-between align-items-center py-1">
            <div class="d-flex align-items-center gap-3 topbar-left">
                <svg class="govph-flag-svg" width="22" height="15" viewBox="0 0 24 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Philippine National Flag" role="img" style="border-radius: 2px; vertical-align: middle; box-shadow: 0 0 1px rgba(0,0,0,0.5);">
                    <rect width="24" height="8" fill="#0038A8"/>
                    <rect y="8" width="24" height="8" fill="#CE1126"/>
                    <polygon points="0,0 12,8 0,16" fill="#FFFFFF"/>
                    <circle cx="4.5" cy="8" r="1.8" fill="#FCD116"/>
                </svg>
                <span class="govph-brand">GOVPH &bull; Republic of the Philippines</span>
                <span class="d-none d-md-inline text-muted-ph">|</span>
                <span class="d-none d-md-inline text-gold">Official Civic Portal</span>
            </div>
            <div class="d-flex align-items-center gap-3 topbar-right">
                <div class="pst-clock-wrapper" title="Philippine Standard Time">
                    <i class='bx bx-time-five'></i>
                    <span class="d-none d-sm-inline">Philippine Standard Time:</span>
                    <strong id="pst-live-clock">Loading PST...</strong>
                </div>
                <div class="a11y-toggles d-flex align-items-center">
                    <button id="btn-toggle-contrast" class="btn btn-sm btn-outline-light py-0 px-2 a11y-btn" title="Toggle High Contrast Mode" aria-label="Toggle High Contrast">
                        <i class='bx bx-adjust me-1'></i> Contrast
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- City Brand Header & Seals -->
    <header class="civic-branding-header">
        <div class="container py-2">
            <div class="d-flex justify-content-between align-items-center">
                <!-- Left: Official Logos -->
                <a href="index.php" class="brand-identity-group text-decoration-none d-flex align-items-center gap-3">
                    <img src="assets/images/Cebu City Icon.png" alt="Official Seal of Cebu City" class="brand-seal">
                    <img src="assets/images/Bagong Pilipinas.png" alt="Bagong Pilipinas Seal" class="brand-seal d-none d-sm-block">
                    <div class="brand-titles">
                        <div class="brand-sub">REPUBLIC OF THE PHILIPPINES &bull; REGION VII</div>
                        <h1 class="brand-main">CITY GOVERNMENT OF CEBU</h1>
                        <div class="brand-tagline">“Ang Kagamhanan sa Dakbayan sa Sugbo — Serbisyong Tinud-anay”</div>
                    </div>
                </a>

                <!-- Right: Emergency Hotline pill & Search Trigger -->
                <div class="d-flex align-items-center gap-2">
                    <div class="emergency-badge d-none d-lg-flex align-items-center gap-2">
                        <div class="pulse-dot"></div>
                        <div>
                            <span class="badge-title">24/7 COMMAND CENTER</span>
                            <span class="badge-num">911 &bull; (032) 262-1424</span>
                        </div>
                    </div>

                    <button class="btn btn-search-trigger" id="btn-open-search" title="Search Portal (Ctrl + K)">
                        <i class='bx bx-search'></i>
                        <span class="d-none d-md-inline">Search services...</span>
                        <kbd class="d-none d-md-inline ms-1">⌘K</kbd>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Navigation Bar -->
    <nav class="navbar navbar-expand-lg civic-navbar sticky-top" id="mainNav">
        <div class="container">
            <!-- Mobile Brand Text -->
            <a class="navbar-brand d-lg-none text-white fw-bold d-flex align-items-center gap-2" href="index.php">
                <img src="assets/images/Cebu City Icon.png" alt="Cebu City" width="28" height="28">
                <span>Cebu City Gov</span>
            </a>

            <!-- Mobile Toggler -->
            <button class="navbar-toggler text-white border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
                <i class='bx bx-menu fs-1'></i>
            </button>

            <!-- Navbar Links -->
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-1">
                    <li class="nav-item">
                        <a class="nav-link <?= is_active_nav('index.php'); ?>" href="index.php">
                            <i class='bx bx-home-alt-2'></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= is_active_nav('services.php'); ?>" href="services.php">
                            <i class='bx bx-grid-alt'></i> Services <span class="badge civic-badge-gold">Online</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= is_active_nav('transparency.php'); ?>" href="transparency.php">
                            <i class='bx bx-shield-quarter'></i> Transparency &amp; Governance
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= is_active_nav('events.php'); ?>" href="events.php">
                            <i class='bx bx-calendar-event'></i> Events &amp; News
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= is_active_nav('about-us.php'); ?>" href="about-us.php">
                            <i class='bx bx-buildings'></i> About Cebu City
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= is_active_nav('contact-us.php'); ?>" href="contact-us.php">
                            <i class='bx bx-phone-call'></i> Contact &amp; Hotlines
                        </a>
                    </li>
                </ul>

                <!-- Citizen Account Section -->
                <div class="navbar-nav ms-auto align-items-lg-center gap-2">
                    <?php if ($citizen): ?>
                        <div class="dropdown">
                            <button class="btn btn-citizen-user dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="avatar-circle"><?= strtoupper(substr($citizen['user_username'], 0, 1)); ?></span>
                                <span class="user-name"><?= e($citizen['user_username']); ?></span>
                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill text-xs">Citizen</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 civic-dropdown">
                                <li class="dropdown-header">
                                    <small class="text-muted">Signed in as</small>
                                    <div class="fw-bold text-dark"><?= e($citizen['user_email']); ?></div>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2" href="citizen-portal.php">
                                        <i class='bx bx-id-card text-primary'></i> Citizen Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2" href="services.php#appointment">
                                        <i class='bx bx-calendar-check text-info'></i> Book Appointment
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger d-flex align-items-center gap-2" href="logout.php">
                                        <i class='bx bx-log-out'></i> Log Out
                                    </a>
                                </li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-outline-portal btn-sm px-3">
                            <i class='bx bx-log-in'></i> Citizen Login
                        </a>
                        <a href="register.php" class="btn btn-gold btn-sm px-3 shadow-sm">
                            <i class='bx bx-user-plus'></i> Register
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Global Flash Alerts Container -->
    <div class="container mt-3">
        <?= render_flash(); ?>
    </div>

    <!-- Quick Search Modal -->
    <div class="modal fade" id="quickSearchModal" tabindex="-1" aria-labelledby="quickSearchModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content civic-modal">
                <div class="modal-header border-0 pb-0">
                    <div class="input-group input-group-lg search-bar-modal">
                        <span class="input-group-text bg-white border-0"><i class='bx bx-search text-muted fs-4'></i></span>
                        <input type="text" class="form-control border-0 shadow-none" id="portalSearchInput" placeholder="Type to search services, forms, departments, hotlines..." autocomplete="off">
                        <button type="button" class="btn-close me-2" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
                <div class="modal-body pt-2">
                    <div class="search-suggestions" id="searchSuggestions">
                        <div class="text-xs text-uppercase fw-bold text-muted mb-2">Popular Inquiries</div>
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            <a href="services.php#bplo" class="badge bg-light text-dark text-decoration-none py-2 px-3 border"><i class='bx bx-briefcase-alt-2'></i> Business Permits (BPLO)</a>
                            <a href="services.php#rpt" class="badge bg-light text-dark text-decoration-none py-2 px-3 border"><i class='bx bx-home'></i> Real Property Tax (Assessor)</a>
                            <a href="services.php#ccmc" class="badge bg-light text-dark text-decoration-none py-2 px-3 border"><i class='bx bx-plus-medical'></i> Cebu City Medical Center (CCMC)</a>
                            <a href="transparency.php#financial" class="badge bg-light text-dark text-decoration-none py-2 px-3 border"><i class='bx bx-file'></i> Q2 Financial Reports</a>
                            <a href="contact-us.php#hotlines" class="badge bg-light text-dark text-decoration-none py-2 px-3 border"><i class='bx bx-phone'></i> Emergency Hotlines 911</a>
                        </div>
                        <div id="searchResultsList" class="search-results-list"></div>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light py-2 px-3 justify-content-between">
                    <small class="text-muted"><kbd>ESC</kbd> to close &bull; <kbd>↑</kbd><kbd>↓</kbd> to navigate</small>
                    <small class="text-gold fw-semibold">City of Cebu Direct Access</small>
                </div>
            </div>
        </div>
    </div>
