/**
 * Cebu City Government Portal - Services Page Logic
 * Handles:
 * - Dynamic Department / Category Filtering
 * - In-Page Live Service Search
 * - AJAX Appointment Booking with Reference Generation
 */

document.addEventListener('DOMContentLoaded', () => {
    initServiceFiltering();
    initServiceSearch();
    initAppointmentBooking();
});

function initServiceFiltering() {
    const filterButtons = document.querySelectorAll('.service-filter-btn');
    const departmentCards = document.querySelectorAll('.department-banner-card');

    filterButtons.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            filterButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            const category = btn.getAttribute('data-category');

            departmentCards.forEach(card => {
                if (category === 'all' || card.getAttribute('data-category') === category) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
}

function initServiceSearch() {
    const searchInput = document.getElementById('serviceFilterSearch');
    const departmentCards = document.querySelectorAll('.department-banner-card');

    if (!searchInput) return;

    searchInput.addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase().trim();

        departmentCards.forEach(card => {
            const text = card.textContent.toLowerCase();
            if (text.includes(query)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
}

function initAppointmentBooking() {
    const form = document.getElementById('appointmentForm');
    const resultBox = document.getElementById('appointmentResult');

    if (!form) return;

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = "<i class='bx bx-loader-alt bx-spin me-1'></i> Processing Appointment...";

        const formData = new FormData(form);
        const payload = Object.fromEntries(formData.entries());

        try {
            const res = await fetch('api/book_appointment.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });

            const data = await res.json();

            if (data.success) {
                resultBox.style.display = 'block';
                resultBox.className = 'alert alert-success border-success shadow-sm mt-3';
                resultBox.innerHTML = `
                    <div class="d-flex align-items-center gap-3">
                        <i class='bx bx-check-circle fs-1 text-success'></i>
                        <div>
                            <h5 class="fw-bold mb-1">Appointment Confirmed!</h5>
                            <p class="mb-1">Your official appointment reference code is: <strong class="badge bg-dark fs-6 font-monospace">${data.reference_code}</strong></p>
                            <small class="text-muted">Service: ${data.service} &bull; Scheduled Date: ${data.date} at ${data.time}. Please bring 1 valid government ID.</small>
                        </div>
                    </div>
                `;
                form.reset();
            } else {
                throw new Error(data.message || 'Failed to book appointment');
            }
        } catch (err) {
            resultBox.style.display = 'block';
            resultBox.className = 'alert alert-danger border-danger shadow-sm mt-3';
            resultBox.innerHTML = `<i class='bx bx-error me-1'></i> ${err.message || 'An error occurred. Please try again.'}`;
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = "<i class='bx bx-calendar-check me-1'></i> Confirm City Hall Appointment";
        }
    });
}
