/**
 * Cebu City Government Portal - Contact & Citizen Feedback Controller
 * Replaced external Node.js Express localhost:3000 dependency with native PHP endpoint api/submit_feedback.php
 */

document.addEventListener('DOMContentLoaded', () => {
    initFeedbackForm();
});

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
