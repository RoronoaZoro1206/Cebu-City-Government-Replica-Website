/**
 * Cebu City Government Portal - Contact & Interactive Map Controller
 * Features:
 * - Leaflet.js Mapping Engine for Pinning Cebu City Government Facilities
 * - Custom Boxicon DivIcons with category color styling
 * - Smooth flyTo navigation and interactive facility filtering
 * - Native PHP Citizen Feedback Form Controller
 */

document.addEventListener('DOMContentLoaded', () => {
    initFeedbackForm();
    initCebuCityMap();
});

/**
 * 1. Leaflet.js Interactive Civic Map & Facility Locator
 */
function initCebuCityMap() {
    const mapElement = document.getElementById('cebuCityMap');
    if (!mapElement) return;

    if (typeof L === 'undefined') {
        console.warn('Leaflet.js library is not loaded. Map cannot be initialized.');
        mapElement.innerHTML = `
            <div class="d-flex flex-column align-items-center justify-content-center h-100 p-4 text-center text-muted">
                <i class='bx bx-map-pin fs-1 text-secondary mb-2'></i>
                <div class="fw-bold">Unable to load interactive map</div>
                <small>Please verify internet connectivity to load OpenStreetMap tiles via Leaflet.</small>
            </div>
        `;
        return;
    }

    // Official Cebu City Government Facilities Directory with verified GPS coordinates
    const cebuFacilities = [
        {
            id: 'city-hall',
            name: 'Cebu City Hall (Executive & Legislative Building)',
            category: 'admin',
            badgeText: 'Seat of City Government',
            lat: 10.2934,
            lng: 123.9019,
            address: 'D. Jakosalem St, Cebu City, 6000 Cebu (Adjacent to Magellan\'s Cross & Plaza Sugbo)',
            hours: 'Mon - Fri: 8:00 AM – 5:00 PM (No Noon Break)',
            phone: '(032) 412-2800 / 255-6984',
            email: 'info@cebucity.gov.ph',
            icon: 'bx-building',
            colorClass: 'pin-admin',
            depts: "Office of the Mayor, City Administrator, Sangguniang Panlungsod, City Assessor, City Treasurer, BPLO, Civil Registrar"
        },
        {
            id: 'ccmc',
            name: 'Cebu City Medical Center (CCMC)',
            category: 'emergency',
            badgeText: 'Tertiary Public Hospital',
            lat: 10.2982,
            lng: 123.8913,
            address: 'N. Bacalso Ave cor. Panganiban St, Pahina Central, Cebu City',
            hours: '24/7 Emergency Room & Triage / OPD: Mon - Fri 8:00 AM – 4:00 PM',
            phone: '(032) 255-7141 / 253-1773',
            email: 'ccmc@cebucity.gov.ph',
            icon: 'bx-plus-medical',
            colorClass: 'pin-emergency',
            depts: 'Emergency Trauma Unit, Internal Medicine, Pediatrics, OB-Gynecology, Surgery, 24/7 Pharmacy'
        },
        {
            id: 'ccdrrmo',
            name: 'Disaster Risk Reduction & Management Office (CCDRRMO)',
            category: 'emergency',
            badgeText: '24/7 Rescue & Disaster Command',
            lat: 10.2938,
            lng: 123.9025,
            address: 'City Hall Compound, M.C. Briones St, Cebu City',
            hours: '24 Hours / 7 Days Active Operations Command',
            phone: '(032) 262-1424 / 911',
            email: 'ccdrrmo@cebucity.gov.ph',
            icon: 'bx-shield-quarter',
            colorClass: 'pin-emergency',
            depts: 'Quick Response Team, Ambulance Dispatch, Flood & Weather Monitoring, Calamity Relief Logistics'
        },
        {
            id: 'chd',
            name: 'Cebu City Health Department (CHD)',
            category: 'emergency',
            badgeText: 'Public Health Bureau',
            lat: 10.3115,
            lng: 123.9056,
            address: 'Gen. Maxilom Ave Extension, Carreta, Cebu City',
            hours: 'Mon - Fri: 8:00 AM – 5:00 PM',
            phone: '(032) 232-6862 / 233-1463',
            email: 'health@cebucity.gov.ph',
            icon: 'bx-heart',
            colorClass: 'pin-emergency',
            depts: 'Sanitary Inspection, Yellow Health Cards, Barangay Health Operations, City Epidemiology Surveillance'
        },
        {
            id: 'ccto',
            name: 'Cebu City Transportation Office (CCTO)',
            category: 'traffic',
            badgeText: 'Traffic Operations & Mobility',
            lat: 10.3060,
            lng: 123.8967,
            address: 'Ramos Market Complex, F. Ramos St, Cebu City',
            hours: 'Mon - Fri: 8:00 AM – 5:00 PM / 24/7 Field Traffic Enforcers',
            phone: '(032) 253-9211 / 253-9212',
            email: 'ccto@cebucity.gov.ph',
            icon: 'bx-car',
            colorClass: 'pin-traffic',
            depts: 'Traffic Rerouting, Citation Settlements, Vehicle Impound Clearance, Road Safety Engineering'
        },
        {
            id: 'ccpo',
            name: 'Cebu City Police Office (CCPO) - Camp Sotero Cabahug',
            category: 'traffic',
            badgeText: 'City Police Headquarters',
            lat: 10.3045,
            lng: 123.9022,
            address: 'Gorordo Ave, Cebu City, 6000 Cebu',
            hours: '24 Hours / 7 Days Tactical Command',
            phone: '166 / (032) 254-8635',
            email: 'ccpo@pnp.gov.ph',
            icon: 'bx-shield',
            colorClass: 'pin-traffic',
            depts: 'Tactical Operations Center, Police Clearances, City Mobile Force Company, Investigation & Detective Bureau'
        }
    ];

    // Initialize Map Centered on Cebu City Hall / Downtown Core
    const defaultCenter = [10.2980, 123.8990];
    const defaultZoom = 14;

    const map = L.map('cebuCityMap', {
        center: defaultCenter,
        zoom: defaultZoom,
        scrollWheelZoom: false, // Prevents unintended page scroll capture
        zoomControl: true
    });

    // Add High-Quality OpenStreetMap Cartographic Tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright" target="_blank" rel="noopener">OpenStreetMap</a> contributors &bull; City Government of Cebu'
    }).addTo(map);

    // Marker storage dictionary
    const markers = {};
    const markerLayerGroup = L.layerGroup().addTo(map);

    // Function to render custom HTML popup
    function createPopupContent(facility) {
        const directionsUrl = `https://www.google.com/maps/dir/?api=1&destination=${facility.lat},${facility.lng}`;
        return `
            <div class="civic-popup-header">
                <span class="badge bg-warning text-dark px-2 py-0 fw-bold mb-1" style="font-size: 0.7rem;">${facility.badgeText}</span>
                <div class="fw-bold fs-6 text-white">${facility.name}</div>
            </div>
            <div class="civic-popup-body">
                <div class="mb-2">
                    <i class='bx bx-map text-primary me-1'></i>
                    <strong>Address:</strong> ${facility.address}
                </div>
                <div class="mb-2">
                    <i class='bx bx-time text-success me-1'></i>
                    <strong>Operating Hours:</strong> ${facility.hours}
                </div>
                <div class="mb-2">
                    <i class='bx bx-phone-call text-danger me-1'></i>
                    <strong>Direct Hotline:</strong> <a href="tel:${facility.phone.split('/')[0].replace(/[^0-9]/g, '')}" class="text-decoration-none fw-bold">${facility.phone}</a>
                </div>
                <div class="small text-muted mb-3 border-top pt-2">
                    <strong>Key Offices / Services:</strong><br>${facility.depts}
                </div>
                <div class="d-flex gap-2">
                    <a href="${directionsUrl}" target="_blank" rel="noopener" class="btn btn-sm btn-primary w-100 fw-bold py-1">
                        <i class='bx bx-navigation me-1'></i> Directions
                    </a>
                </div>
            </div>
        `;
    }

    // Plot pins on map
    cebuFacilities.forEach(facility => {
        const pinIcon = L.divIcon({
            html: `<div class="leaflet-civic-pin ${facility.colorClass}" id="pin-${facility.id}" title="${facility.name}"><i class='bx ${facility.icon}'></i></div>`,
            className: 'custom-civic-marker-wrapper',
            iconSize: [36, 36],
            iconAnchor: [18, 36],
            popupAnchor: [0, -36]
        });

        const marker = L.marker([facility.lat, facility.lng], { icon: pinIcon });
        marker.bindPopup(createPopupContent(facility), {
            maxWidth: 320,
            className: 'civic-leaflet-popup'
        });

        marker.on('click', () => {
            highlightCard(facility.id);
        });

        markers[facility.id] = { marker, facility };
        markerLayerGroup.addLayer(marker);
    });

    // Populate Facility Cards in Directory Grid
    const cardsGrid = document.getElementById('facilityCardsGrid');
    function renderFacilityCards(filter = 'all') {
        if (!cardsGrid) return;
        cardsGrid.innerHTML = '';

        const filtered = filter === 'all' 
            ? cebuFacilities 
            : cebuFacilities.filter(f => f.category === filter);

        filtered.forEach(facility => {
            const cardCol = document.createElement('div');
            cardCol.className = 'col-md-6 col-lg-4';
            cardCol.innerHTML = `
                <div class="facility-locator-card" id="card-${facility.id}">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div class="facility-icon-circle ${facility.category === 'emergency' ? 'bg-danger-subtle text-danger' : (facility.category === 'traffic' ? 'bg-primary-subtle text-primary' : 'bg-warning-subtle text-dark')}">
                                <i class='bx ${facility.icon}'></i>
                            </div>
                            <div>
                                <span class="badge ${facility.category === 'emergency' ? 'bg-danger' : (facility.category === 'traffic' ? 'bg-primary' : 'bg-dark')} text-white px-2 py-0" style="font-size: 0.65rem;">
                                    ${facility.badgeText}
                                </span>
                                <h6 class="fw-bold text-dark mb-0 mt-1" style="font-size: 0.95rem; line-height: 1.25;">${facility.name}</h6>
                            </div>
                        </div>
                        <p class="text-muted small mb-2" style="font-size: 0.8rem;">
                            <i class='bx bx-map text-muted me-1'></i>${facility.address}
                        </p>
                        <div class="small text-muted mb-1" style="font-size: 0.75rem;">
                            <i class='bx bx-time text-muted me-1'></i>${facility.hours}
                        </div>
                        <div class="small text-muted mb-3" style="font-size: 0.75rem;">
                            <i class='bx bx-phone text-muted me-1'></i><strong>${facility.phone}</strong>
                        </div>
                    </div>
                    <div class="d-flex gap-2 pt-2 border-top">
                        <button type="button" class="btn btn-sm btn-outline-primary w-50 btn-locate-facility" data-id="${facility.id}">
                            <i class='bx bx-map-pin me-1'></i> Pin on Map
                        </button>
                        <a href="https://www.google.com/maps/dir/?api=1&destination=${facility.lat},${facility.lng}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-secondary w-50">
                            <i class='bx bx-directions me-1'></i> Route
                        </a>
                    </div>
                </div>
            `;
            cardsGrid.appendChild(cardCol);
        });

        // Attach locate button listeners
        document.querySelectorAll('.btn-locate-facility').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const id = btn.getAttribute('data-id');
                focusFacility(id);
            });
        });
    }

    renderFacilityCards('all');

    // Function to smooth fly to facility pin and pop open its window
    function focusFacility(id) {
        const item = markers[id];
        if (!item) return;

        map.flyTo([item.facility.lat, item.facility.lng], 16, {
            animate: true,
            duration: 1.0
        });

        // Ensure marker layer is visible
        if (!markerLayerGroup.hasLayer(item.marker)) {
            markerLayerGroup.addLayer(item.marker);
        }

        setTimeout(() => {
            item.marker.openPopup();
        }, 800);

        highlightCard(id);

        // Smooth scroll to map on mobile
        if (window.innerWidth < 768) {
            mapElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    function highlightCard(id) {
        document.querySelectorAll('.facility-locator-card').forEach(c => c.classList.remove('card-active'));
        const activeCard = document.getElementById(`card-${id}`);
        if (activeCard) {
            activeCard.classList.add('card-active');
            activeCard.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    }

    // Filter Buttons Behavior
    const filterButtons = document.querySelectorAll('#mapFilterButtons .map-filter-btn');
    filterButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            filterButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            const filter = btn.getAttribute('data-filter');
            markerLayerGroup.clearLayers();

            cebuFacilities.forEach(f => {
                if (filter === 'all' || f.category === filter) {
                    markerLayerGroup.addLayer(markers[f.id].marker);
                }
            });

            renderFacilityCards(filter);
            map.invalidateSize();
        });
    });

    // Reset View Button
    const resetBtn = document.getElementById('btnResetMapView');
    if (resetBtn) {
        resetBtn.addEventListener('click', () => {
            focusFacility('city-hall');
        });
    }

    // Auto-open Cebu City Hall pin on initial load
    setTimeout(() => {
        map.invalidateSize();
        if (markers['city-hall']) {
            markers['city-hall'].marker.openPopup();
        }
    }, 400);

    // Glitch fix: Invalidate map size on window resize
    window.addEventListener('resize', () => {
        map.invalidateSize();
    });
}

/**
 * 2. Native PHP Citizen Feedback Form Controller
 */
function initFeedbackForm() {
    const form = document.getElementById('citizenFeedbackForm');
    const responseBox = document.getElementById('feedbackResponseAlert');

    if (!form) return;

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = "<i class='bx bx-loader-alt bx-spin me-1'></i> Sending Message...";

        const name = document.getElementById('feedbackName').value.trim();
        const email = document.getElementById('feedbackEmail').value.trim();
        const message = document.getElementById('feedbackMessage').value.trim();

        try {
            const res = await fetch('api/submit_feedback.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ name, email, message })
            });

            const data = await res.json();

            if (data.success) {
                responseBox.style.display = 'block';
                responseBox.className = 'alert alert-success border border-success shadow-sm mb-4';
                responseBox.innerHTML = `
                    <div class="d-flex align-items-center gap-2">
                        <i class='bx bx-check-circle fs-3 text-success'></i>
                        <div>
                            <strong>Feedback Submitted!</strong>
                            <div>${data.message}</div>
                        </div>
                    </div>
                `;
                form.reset();
            } else {
                throw new Error(data.message || 'Submission failed');
            }
        } catch (err) {
            responseBox.style.display = 'block';
            responseBox.className = 'alert alert-danger border border-danger shadow-sm mb-4';
            responseBox.innerHTML = `<i class='bx bx-error-circle me-1'></i> ${err.message || 'An error occurred while submitting. Please try again.'}`;
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = "<i class='bx bx-send me-1'></i> Submit Feedback to Mayor's Desk";
        }
    });
}
