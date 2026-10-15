<?php
/**
 * Cebu City Government Portal - Global Footer Component
 * Features:
 * - Official GovPH Philippine Standard Time indicator
 * - 24/7 Cebu City Emergency Hotlines directory
 * - Civic Navigation, Citizen's Charter & Open Data links
 * - Floating Back-To-Top button
 * - Core script loaders
 */

declare(strict_types=1);
?>
    <!-- Emergency Hotlines Quick Bar -->
    <section class="civic-emergency-strip">
        <div class="container">
            <div class="row align-items-center py-3 g-3">
                <div class="col-lg-4 d-flex align-items-center gap-3">
                    <div class="emergency-icon-circle">
                        <i class='bx bx-phone-call fs-2 text-danger'></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold text-white">CEBU CITY EMERGENCY QUICK DIAL</h6>
                        <small class="text-white-50">Dial 911 or local command direct lines</small>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="row g-2 text-center text-md-start">
                        <div class="col-6 col-md-3">
                            <div class="hotline-mini-card">
                                <span class="hotline-dept">CCDRRMO (Rescue)</span>
                                <a href="tel:0322621424" class="hotline-phone">(032) 262-1424</a>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="hotline-mini-card">
                                <span class="hotline-dept">CCMC (Hospital)</span>
                                <a href="tel:0322557141" class="hotline-phone">(032) 255-7141</a>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="hotline-mini-card">
                                <span class="hotline-dept">CCTO (Traffic)</span>
                                <a href="tel:0322539211" class="hotline-phone">(032) 253-9211</a>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="hotline-mini-card">
                                <span class="hotline-dept">CCPO (Police)</span>
                                <a href="tel:166" class="hotline-phone">166 / 254-8635</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Civic Footer -->
    <footer class="civic-footer pt-5 pb-4">
        <div class="container">
            <div class="row g-4 pb-4 border-bottom border-secondary-subtle">
                <!-- Column 1: City Seal and Info -->
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <img src="assets/images/Cebu City Icon.png" alt="Cebu City Seal" width="52" height="52">
                        <img src="assets/images/Bagong Pilipinas.png" alt="Bagong Pilipinas" width="52" height="52">
                        <div>
                            <h5 class="fw-bold mb-0 text-white">City of Cebu</h5>
                            <small class="text-gold">Dakbayan sa Sugbo</small>
                        </div>
                    </div>
                    <p class="text-light-50 small mb-3">
                        The Queen City of the South. Serbisyong Tinud-anay, Katungod sa Katawhan. Empowering citizens through accessible, digital, and transparent local governance.
                    </p>
                    <div class="civic-contact-details small text-light-50">
                        <div class="mb-1"><i class='bx bx-map text-gold me-2'></i> Cebu City Hall, D. Jakosalem St, Cebu City 6000</div>
                        <div class="mb-1"><i class='bx bx-time text-gold me-2'></i> Mon - Fri: 8:00 AM – 5:00 PM (PST)</div>
                        <div class="mb-1"><i class='bx bx-envelope text-gold me-2'></i> info@cebucity.gov.ph</div>
                    </div>
                </div>

                <!-- Column 2: Quick Links -->
                <div class="col-lg-2 col-md-6 col-6">
                    <h6 class="text-gold fw-bold text-uppercase mb-3">Key Portals</h6>
                    <ul class="list-unstyled civic-footer-links small">
                        <li><a href="index.php">Home Portal</a></li>
                        <li><a href="services.php">Online Services</a></li>
                        <li><a href="transparency.php">Full Disclosure</a></li>
                        <li><a href="events.php">Announcements</a></li>
                        <li><a href="about-us.php">City History &amp; Officials</a></li>
                        <li><a href="contact-us.php">Helpdesk &amp; Inquiries</a></li>
                    </ul>
                </div>

                <!-- Column 3: Citizen Services -->
                <div class="col-lg-3 col-md-6 col-6">
                    <h6 class="text-gold fw-bold text-uppercase mb-3">Citizen Services</h6>
                    <ul class="list-unstyled civic-footer-links small">
                        <li><a href="services.php#bplo">Business Permits &amp; Licensing</a></li>
                        <li><a href="services.php#rpt">Real Property Tax (Assessor)</a></li>
                        <li><a href="services.php#ccmc">Cebu City Medical Center</a></li>
                        <li><a href="services.php#dsws">Social Welfare &amp; Assistance</a></li>
                        <li><a href="services.php#depw">Engineering &amp; Public Works</a></li>
                        <li><a href="services.php#appointment">Book Service Appointment</a></li>
                    </ul>
                </div>

                <!-- Column 4: Republic of the Philippines Links -->
                <div class="col-lg-3 col-md-6">
                    <h6 class="text-gold fw-bold text-uppercase mb-3">Republic of the Philippines</h6>
                    <ul class="list-unstyled civic-footer-links small">
                        <li><a href="https://www.gov.ph" target="_blank" rel="noopener">Official Gazette (gov.ph)</a></li>
                        <li><a href="https://dilg.gov.ph" target="_blank" rel="noopener">Department of the Interior (DILG)</a></li>
                        <li><a href="https://cebu.gov.ph" target="_blank" rel="noopener">Province of Cebu</a></li>
                        <li><a href="transparency.php#financial">Audited Financial Statements</a></li>
                    </ul>

                    <h6 class="text-gold fw-bold text-uppercase mt-4 mb-2">Connect With Us</h6>
                    <div class="d-flex gap-2">
                        <a href="https://facebook.com/CityofCebuOfficial" target="_blank" rel="noopener" class="social-btn" title="Facebook"><i class='bx bxl-facebook'></i></a>
                        <a href="https://twitter.com" target="_blank" rel="noopener" class="social-btn" title="Twitter / X"><i class='bx bxl-twitter'></i></a>
                        <a href="https://instagram.com" target="_blank" rel="noopener" class="social-btn" title="Instagram"><i class='bx bxl-instagram'></i></a>
                        <a href="mailto:info@cebucity.gov.ph" class="social-btn" title="Email"><i class='bx bx-envelope'></i></a>
                    </div>
                </div>
            </div>

            <!-- Bottom Copyright & PST Disclaimer -->
            <div class="d-flex flex-wrap justify-content-between align-items-center pt-3 small text-white-50">
                <div>
                    &copy; <?= date('Y'); ?> City Government of Cebu. All Rights Reserved. Public Domain Replica for Civic Engagement.
                </div>
                <div class="d-flex gap-3">
                    <a href="transparency.php" class="text-white-50 text-decoration-none hover-gold">Privacy Policy</a>
                    <span>&bull;</span>
                    <a href="transparency.php" class="text-white-50 text-decoration-none hover-gold">Citizen's Charter</a>
                    <span>&bull;</span>
                    <a href="transparency.php" class="text-white-50 text-decoration-none hover-gold">Open Data</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Floating Back to Top Button -->
    <button type="button" class="btn-back-to-top" id="btnBackToTop" aria-label="Back to Top" title="Back to Top">
        <i class='bx bx-chevron-up'></i>
    </button>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Core Main JS -->
    <script src="assets/js/main.js?v=<?= file_exists(__DIR__ . '/../assets/js/main.js') ? filemtime(__DIR__ . '/../assets/js/main.js') : time(); ?>"></script>

    <!-- Leaflet.js Mapping Library (loaded on pages with maps) -->
    <?php if (!empty($includeLeaflet)): ?>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <?php endif; ?>

    <!-- Page Specific Script (if set) -->
    <?php if (!empty($customJs)): ?>
        <script src="<?= e($customJs); ?>?v=<?= file_exists(__DIR__ . '/../' . $customJs) ? filemtime(__DIR__ . '/../' . $customJs) : time(); ?>"></script>
    <?php endif; ?>
</body>
</html>
