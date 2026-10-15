<?php
/**
 * Cebu City Government Portal - Citizen Services Directory & Online Booking
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/db.php';

$pageTitle = 'City Services & Departments Directory';
$customCss = 'assets/css/services.css';
$customJs = 'assets/js/services.js';

$citizen = current_user();

require_once __DIR__ . '/includes/header.php';
?>

<!-- Hero Header -->
<section class="services-hero-header">
    <div class="container text-center">
        <span class="badge bg-warning text-dark px-3 py-1 fw-bold text-uppercase mb-2">City Services Catalog</span>
        <h1 class="fw-bold text-white mb-2">Cebu City Government Services</h1>
        <p class="text-white-50 mx-auto mb-4" style="max-width: 650px;">
            Comprehensive guide to municipal permits, health services, social assistance, taxation, and engineering requests across all City Hall departments.
        </p>

        <!-- Search Bar -->
        <div class="mx-auto" style="max-width: 580px;">
            <div class="input-group input-group-lg shadow-sm">
                <span class="input-group-text bg-white border-0"><i class='bx bx-search text-muted'></i></span>
                <input type="text" id="serviceFilterSearch" class="form-control border-0" placeholder="Filter services by keyword (e.g. BPLO, Tax, Medical, Permit)...">
            </div>
            <div class="d-flex justify-content-center gap-2 mt-3">
                <a href="#departmentsList" class="btn btn-sm btn-outline-light rounded-pill px-3"><i class='bx bx-grid-alt me-1'></i> Browse 8 Departments</a>
                <a href="#appointment" class="btn btn-sm btn-gold rounded-pill px-3 fw-bold"><i class='bx bx-calendar-check me-1'></i> Book Appointment Desk</a>
            </div>
        </div>
    </div>
</section>

<!-- Filter Navigation Tabs (In-flow, clean and non-sticky to avoid scroll clutter) -->
<div class="services-filter-nav py-3 bg-white border-bottom shadow-xs mb-3" id="departmentsList">
    <div class="container">
        <div class="d-flex flex-wrap gap-2 justify-content-center">
            <button class="nav-link active service-filter-btn" data-category="all">All Departments (8)</button>
            <button class="nav-link service-filter-btn" data-category="business">Business &amp; Taxes</button>
            <button class="nav-link service-filter-btn" data-category="health">Health &amp; Medical</button>
            <button class="nav-link service-filter-btn" data-category="social">Social Welfare</button>
            <button class="nav-link service-filter-btn" data-category="traffic">Traffic &amp; Transport</button>
            <button class="nav-link service-filter-btn" data-category="infrastructure">Public Works</button>
            <button class="nav-link service-filter-btn" data-category="employment">Skills &amp; Jobs</button>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <!-- 1. BPLO -->
            <div class="department-banner-card" id="bplo" data-category="business">
                <div class="department-header">
                    <img src="assets/images/bplo.jpg" alt="BPLO Logo" class="department-logo">
                    <div>
                        <h4 class="fw-bold mb-1 text-dark">Business Permit and Licensing Office (BPLO)</h4>
                        <small class="text-muted"><i class='bx bx-map-pin'></i> Ground Floor, Executive Building, Cebu City Hall &bull; bplo@cebucity.gov.ph</small>
                    </div>
                </div>
                <div class="department-body">
                    <p class="text-muted small mb-3">
                        Mandated to regulate, evaluate, and issue official permits for commercial entities operating within Cebu City limits under the Local Government Code.
                    </p>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="service-subcard">
                                <h6 class="fw-bold text-dark mb-1"><i class='bx bx-plus-circle text-primary me-1'></i> New Business Application</h6>
                                <p class="small text-muted mb-2">Assessment and issuance of Mayor's Permit for newly established enterprises.</p>
                                <span class="badge bg-light text-dark border">Requirements: DTI/SEC, Barangay Clearance, Zoning</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="service-subcard">
                                <h6 class="fw-bold text-dark mb-1"><i class='bx bx-refresh text-success me-1'></i> Annual Permit Renewal</h6>
                                <p class="small text-muted mb-2">Annual assessment and renewal of business tax licenses every January.</p>
                                <span class="badge bg-light text-dark border">Online processing available</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 pt-2 border-top d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <small class="text-muted"><i class='bx bx-check-shield text-success me-1'></i> Official Front-line Desk</small>
                        <button type="button" class="btn btn-sm btn-outline-primary btn-quick-book" data-service="BPLO - Business Permit Application">
                            <i class='bx bx-calendar-plus me-1'></i> Book Appointment
                        </button>
                    </div>
                </div>
            </div>

            <!-- 2. City Assessor -->
            <div class="department-banner-card" id="rpt" data-category="business">
                <div class="department-header">
                    <img src="assets/images/assessor.jpg" alt="City Assessor Logo" class="department-logo">
                    <div>
                        <h4 class="fw-bold mb-1 text-dark">City Assessor's Office &amp; Treasury (Real Property Tax)</h4>
                        <small class="text-muted"><i class='bx bx-map-pin'></i> 2nd Floor, Legislative Building, Cebu City Hall</small>
                    </div>
                </div>
                <div class="department-body">
                    <p class="text-muted small mb-3">
                        Appraises and assesses real properties (land, buildings, and machinery) for fair market taxation and issues certified tax declarations.
                    </p>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="service-subcard">
                                <h6 class="fw-bold text-dark mb-1"><i class='bx bx-calculator text-warning me-1'></i> Real Property Tax Clearance</h6>
                                <p class="small text-muted mb-2">Certification of updated real property tax payments for property transfers and titling.</p>
                                <span class="badge bg-light text-dark border">Same-day release</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="service-subcard">
                                <h6 class="fw-bold text-dark mb-1"><i class='bx bx-transfer text-info me-1'></i> Transfer of Property Declaration</h6>
                                <p class="small text-muted mb-2">Updating ownership records of declared real properties following purchase or inheritance.</p>
                                <span class="badge bg-light text-dark border">Requires Deed of Sale &amp; Title</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 pt-2 border-top d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <small class="text-muted"><i class='bx bx-check-shield text-success me-1'></i> Official Front-line Desk</small>
                        <button type="button" class="btn btn-sm btn-outline-primary btn-quick-book" data-service="City Assessor - Real Property Tax Assessment">
                            <i class='bx bx-calendar-plus me-1'></i> Book Appointment
                        </button>
                    </div>
                </div>
            </div>

            <!-- 3. CCMC -->
            <div class="department-banner-card" id="ccmc" data-category="health">
                <div class="department-header">
                    <img src="assets/images/Ccmc logo.png" alt="CCMC Logo" class="department-logo">
                    <div>
                        <h4 class="fw-bold mb-1 text-dark">Cebu City Medical Center (CCMC)</h4>
                        <small class="text-muted"><i class='bx bx-map-pin'></i> N. Bacalso Ave, Cebu City &bull; Emergency Hotline: (032) 255-7141</small>
                    </div>
                </div>
                <div class="department-body">
                    <p class="text-muted small mb-3">
                        The premier tertiary hospital operated by the City Government of Cebu, providing subsidized and free medical care to resident Sugboanons.
                    </p>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="service-subcard">
                                <h6 class="fw-bold text-dark mb-1"><i class='bx bx-plus-medical text-danger me-1'></i> 24/7 Emergency &amp; Trauma Care</h6>
                                <p class="small text-muted mb-2">Immediate emergency triage, surgery, and intensive care admissions.</p>
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle">No PhilHealth balance billing</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="service-subcard">
                                <h6 class="fw-bold text-dark mb-1"><i class='bx bx-stethoscope text-primary me-1'></i> Outpatient Consultations (OPD)</h6>
                                <p class="small text-muted mb-2">Pediatrics, Internal Medicine, Obstetrics-Gynecology, and General Surgery clinics.</p>
                                <span class="badge bg-light text-dark border">Mon - Fri: 8:00 AM - 4:00 PM</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 pt-2 border-top d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <a href="assets/pdf/CCMC – Rate of Services.pdf" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class='bx bx-download me-1'></i> Download Rate of Services PDF
                        </a>
                        <button type="button" class="btn btn-sm btn-outline-primary btn-quick-book" data-service="CCMC - Outpatient Medical Consultation">
                            <i class='bx bx-calendar-plus me-1'></i> Book OPD Appointment
                        </button>
                    </div>
                </div>
            </div>

            <!-- 4. City Health Department -->
            <div class="department-banner-card" id="chd" data-category="health">
                <div class="department-header">
                    <img src="assets/images/chd.jpg" alt="CHD Logo" class="department-logo">
                    <div>
                        <h4 class="fw-bold mb-1 text-dark">City Health Department (CHD)</h4>
                        <small class="text-muted"><i class='bx bx-map-pin'></i> General Maxilom Ave. Ext., Cebu City</small>
                    </div>
                </div>
                <div class="department-body">
                    <p class="text-muted small mb-3">
                        Coordinates community primary healthcare, 80 barangay health stations, maternal-child immunizations, and sanitary permits.
                    </p>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="service-subcard">
                                <h6 class="fw-bold text-dark mb-1"><i class='bx bx-id-card text-success me-1'></i> City Health Card &amp; Sanitation</h6>
                                <p class="small text-muted mb-2">Sanitation clearance and food-handler medical cards for commercial workers.</p>
                                <span class="badge bg-light text-dark border">Requires stool/sputum exam</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="service-subcard">
                                <h6 class="fw-bold text-dark mb-1"><i class='bx bx-injection text-info me-1'></i> Free Child &amp; Adult Immunizations</h6>
                                <p class="small text-muted mb-2">EPI vaccines, flu vaccines, and anti-rabies bite clinic post-exposure treatment.</p>
                                <span class="badge bg-light text-dark border">Free at Barangay Centers</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 pt-2 border-top d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <small class="text-muted"><i class='bx bx-check-shield text-success me-1'></i> Official Sanitation Desk</small>
                        <button type="button" class="btn btn-sm btn-outline-primary btn-quick-book" data-service="City Health - Health Card &amp; Sanitation">
                            <i class='bx bx-calendar-plus me-1'></i> Book Sanitation Desk
                        </button>
                    </div>
                </div>
            </div>

            <!-- 5. DSWS -->
            <div class="department-banner-card" id="dsws" data-category="social">
                <div class="department-header">
                    <img src="assets/images/dsws.jpg" alt="DSWS Logo" class="department-logo">
                    <div>
                        <h4 class="fw-bold mb-1 text-dark">Department of Social Welfare and Services (DSWS)</h4>
                        <small class="text-muted"><i class='bx bx-map-pin'></i> Katipunan St., Labangon, Cebu City</small>
                    </div>
                </div>
                <div class="department-body">
                    <p class="text-muted small mb-3">
                        Administers welfare benefits, financial assistance, senior citizen pensions, and disaster relief operations for underprivileged constituents.
                    </p>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="service-subcard">
                                <h6 class="fw-bold text-dark mb-1"><i class='bx bx-heart text-danger me-1'></i> Senior Citizens &amp; Solo Parents Aid</h6>
                                <p class="small text-muted mb-2">Bi-monthly cash subsidy distribution for registered elderly and solo parents.</p>
                                <span class="badge bg-light text-dark border">OSCA registered</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="service-subcard">
                                <h6 class="fw-bold text-dark mb-1"><i class='bx bx-first-aid text-primary me-1'></i> Burial &amp; Crisis Assistance</h6>
                                <p class="small text-muted mb-2">Emergency financial assistance for indigent families facing sudden medical or funeral expenses.</p>
                                <span class="badge bg-light text-dark border">Certificate of Indigency</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 pt-2 border-top d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <small class="text-muted"><i class='bx bx-check-shield text-success me-1'></i> Crisis Assistance Intake</small>
                        <button type="button" class="btn btn-sm btn-outline-primary btn-quick-book" data-service="DSWS - Social Financial Assistance">
                            <i class='bx bx-calendar-plus me-1'></i> Book DSWS Intake
                        </button>
                    </div>
                </div>
            </div>

            <!-- 6. CCTO -->
            <div class="department-banner-card" id="ccto" data-category="traffic">
                <div class="department-header">
                    <img src="assets/images/ccto.jpg" alt="CCTO Logo" class="department-logo">
                    <div>
                        <h4 class="fw-bold mb-1 text-dark">Cebu City Transportation Office (CCTO)</h4>
                        <small class="text-muted"><i class='bx bx-map-pin'></i> Ramos Public Market 2nd Floor, Cebu City &bull; (032) 253-9211</small>
                    </div>
                </div>
                <div class="department-body">
                    <p class="text-muted small mb-3">
                        Manages traffic enforcement, vehicle impounding, traffic light synchronization, and special road-use permits across the metropolitan network.
                    </p>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="service-subcard">
                                <h6 class="fw-bold text-dark mb-1"><i class='bx bx-receipt text-warning me-1'></i> Citation Ticket Settlement</h6>
                                <p class="small text-muted mb-2">Payment and adjudication of municipal traffic violations and clamping fees.</p>
                                <span class="badge bg-light text-dark border">Cashless kiosks accepted</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="service-subcard">
                                <h6 class="fw-bold text-dark mb-1"><i class='bx bx-car text-danger me-1'></i> Impounded Vehicle Release</h6>
                                <p class="small text-muted mb-2">Processing of clearances, proof of ownership, and towing fees for vehicle retrieval.</p>
                                <span class="badge bg-light text-dark border">BRT / Plaza Independencia Yard</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 pt-2 border-top d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <small class="text-muted"><i class='bx bx-check-shield text-success me-1'></i> Traffic Adjudication Window</small>
                        <button type="button" class="btn btn-sm btn-outline-primary btn-quick-book" data-service="CCTO - Traffic Violation Clearance">
                            <i class='bx bx-calendar-plus me-1'></i> Book Traffic Clearance
                        </button>
                    </div>
                </div>
            </div>

            <!-- 7. DEPW -->
            <div class="department-banner-card" id="depw" data-category="infrastructure">
                <div class="department-header">
                    <img src="assets/images/depw.jpg" alt="DEPW Logo" class="department-logo">
                    <div>
                        <h4 class="fw-bold mb-1 text-dark">Department of Engineering and Public Works (DEPW)</h4>
                        <small class="text-muted"><i class='bx bx-map-pin'></i> South Road Properties (SRP), Cebu City</small>
                    </div>
                </div>
                <div class="department-body">
                    <p class="text-muted small mb-3">
                        Responsible for city roads, drainage systems, river dredging, flood control infrastructure, and building safety compliance.
                    </p>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="service-subcard">
                                <h6 class="fw-bold text-dark mb-1"><i class='bx bx-wrench text-secondary me-1'></i> Drainage &amp; Road Repair Request</h6>
                                <p class="small text-muted mb-2">Barangay-level unclogging, pothole patching, and culvert installation requests.</p>
                                <span class="badge bg-light text-dark border">Action within 72 hours</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="service-subcard">
                                <h6 class="fw-bold text-dark mb-1"><i class='bx bx-bulb text-warning me-1'></i> Street Lighting Maintenance</h6>
                                <p class="small text-muted mb-2">Repair and LED conversion of public streetlights along municipal thoroughfares.</p>
                                <span class="badge bg-light text-dark border">Public Hotline 911</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 pt-2 border-top d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <small class="text-muted"><i class='bx bx-check-shield text-success me-1'></i> Engineering &amp; Works Desk</small>
                        <button type="button" class="btn btn-sm btn-outline-primary btn-quick-book" data-service="DEPW - Building &amp; Infrastructure Clearance">
                            <i class='bx bx-calendar-plus me-1'></i> Book Clearance Window
                        </button>
                    </div>
                </div>
            </div>

            <!-- 8. DMDP -->
            <div class="department-banner-card" id="dmdp" data-category="employment">
                <div class="department-header">
                    <img src="assets/images/dmdp.jpg" alt="DMDP Logo" class="department-logo">
                    <div>
                        <h4 class="fw-bold mb-1 text-dark">Department of Manpower Development and Placement (DMDP)</h4>
                        <small class="text-muted"><i class='bx bx-map-pin'></i> Ramos St., Cebu City</small>
                    </div>
                </div>
                <div class="department-body">
                    <p class="text-muted small mb-3">
                        Provides TESDA-accredited vocational livelihood trainings, job placement fairs, and public employment matching for Cebuanos.
                    </p>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="service-subcard">
                                <h6 class="fw-bold text-dark mb-1"><i class='bx bx-book-open text-primary me-1'></i> Free Technical &amp; Vocational Courses</h6>
                                <p class="small text-muted mb-2">Shielded Metal Arc Welding (SMAW), Automotive, Culinary, and Housekeeping courses.</p>
                                <span class="badge bg-light text-dark border">TESDA NC II Certified</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="service-subcard">
                                <h6 class="fw-bold text-dark mb-1"><i class='bx bx-briefcase text-success me-1'></i> PESO Job Fairs &amp; Referrals</h6>
                                <p class="small text-muted mb-2">Connecting local jobseekers with registered employers and international agencies.</p>
                                <span class="badge bg-light text-dark border">Monthly Job Fairs</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 pt-2 border-top d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <small class="text-muted"><i class='bx bx-check-shield text-success me-1'></i> Livelihood &amp; Training Desk</small>
                        <button type="button" class="btn btn-sm btn-outline-primary btn-quick-book" data-service="BPLO - Business Permit Application">
                            <i class='bx bx-calendar-plus me-1'></i> Book Livelihood Inquiries
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Online Appointment Booking Box -->
        <div class="col-lg-4" id="appointment">
            <div class="appointment-booking-box sticky-sidebar">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <div class="p-2 bg-warning text-dark rounded-circle fs-4 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class='bx bx-calendar-check'></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0 text-white">Book Appointment</h5>
                        <small class="text-white-50">Skip the queue at City Hall</small>
                    </div>
                </div>

                <p class="small text-white-50 mb-3" style="font-size: 0.775rem; line-height: 1.35;">
                    Select your preferred department and timeslot to receive an instant official reference code.
                </p>

                <form id="appointmentForm">
                    <div class="mb-2">
                        <label class="form-label" for="aptCitizenName">Full Citizen Name</label>
                        <input type="text" id="aptCitizenName" name="citizen_name" class="form-control" placeholder="e.g. Maria Santos" value="<?= e($citizen['user_username'] ?? ''); ?>" required>
                    </div>

                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <label class="form-label" for="aptEmail">Email Address</label>
                            <input type="email" id="aptEmail" name="email" class="form-control" placeholder="name@email.com" value="<?= e($citizen['user_email'] ?? ''); ?>" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="aptPhone">Mobile Phone</label>
                            <input type="tel" id="aptPhone" name="phone" class="form-control" placeholder="0917-000-0000" required>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label" for="aptService">Department / Service</label>
                        <select id="aptService" name="service" class="form-select" required>
                            <option value="">-- Choose City Service --</option>
                            <option value="BPLO - Business Permit Application">BPLO - Business Permit Application</option>
                            <option value="BPLO - Business Permit Renewal">BPLO - Business Permit Renewal</option>
                            <option value="City Assessor - Real Property Tax Assessment">City Assessor - Real Property Tax Assessment</option>
                            <option value="CCMC - Outpatient Medical Consultation">CCMC - Outpatient Medical Consultation</option>
                            <option value="City Health - Health Card &amp; Sanitation">City Health - Health Card &amp; Sanitation</option>
                            <option value="Civil Registrar - Birth / Marriage Certificates">Civil Registrar - Birth / Marriage Certificates</option>
                            <option value="CCTO - Traffic Violation Clearance">CCTO - Traffic Violation Clearance</option>
                            <option value="DSWS - Social Financial Assistance">DSWS - Social Financial Assistance</option>
                            <option value="DEPW - Building &amp; Infrastructure Clearance">DEPW - Building &amp; Infrastructure Clearance</option>
                        </select>
                    </div>

                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <label class="form-label" for="aptDate">Preferred Date</label>
                            <input type="date" id="aptDate" name="date" class="form-control" min="<?= date('Y-m-d'); ?>" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="aptTime">Timeslot</label>
                            <select id="aptTime" name="time" class="form-select" required>
                                <option value="8:30 AM - 10:00 AM">8:30 AM - 10:00 AM</option>
                                <option value="10:00 AM - 11:30 AM">10:00 AM - 11:30 AM</option>
                                <option value="1:00 PM - 2:30 PM">1:00 PM - 2:30 PM</option>
                                <option value="2:30 PM - 4:00 PM">2:30 PM - 4:00 PM</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="aptNotes">Additional Notes (Optional)</label>
                        <textarea id="aptNotes" name="notes" class="form-control" rows="1" placeholder="Specific documents or inquiry details..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-gold w-100 py-2 fw-bold shadow-sm">
                        <i class='bx bx-calendar-check me-1'></i> Confirm Appointment
                    </button>
                    <div class="text-center mt-2">
                        <small class="text-white-50" style="font-size: 0.7rem;"><i class='bx bx-shield-quarter me-1'></i> ARTA Compliant &bull; No Noon Break</small>
                    </div>
                </form>

                <div id="appointmentResult" style="display: none;"></div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>