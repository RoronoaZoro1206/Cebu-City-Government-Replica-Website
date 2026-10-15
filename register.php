<?php
/**
 * Cebu City Government Portal - Citizen Registration
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/security.php';
require_once __DIR__ . '/includes/helpers.php';

if (is_logged_in()) {
    header('Location: index.php');
    exit();
}

$pageTitle = 'Citizen Registration';
$customCss = 'assets/css/authentication.css';
require_once __DIR__ . '/includes/header.php';
?>

<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-header">
            <img src="assets/images/Cebu City Icon.png" alt="Cebu City Seal" class="auth-seal">
            <h3>Citizen Account Registration</h3>
            <p>Register to book appointments, track documents, and submit inquiries</p>
        </div>

        <div class="auth-body">
            <form method="POST" action="auth/register_action.php" autocomplete="off" class="auth-form">
                <?= csrf_field(); ?>

                <div class="form-group">
                    <label for="username">Preferred Username</label>
                    <div class="auth-input-group">
                        <i class='bx bx-user input-icon'></i>
                        <input type="text" id="username" name="username" class="form-control" placeholder="e.g. juan_delacruz" pattern="^[a-zA-Z0-9_]{3,30}$" title="3-30 alphanumeric characters and underscores" required autofocus>
                    </div>
                    <small class="text-muted" style="font-size: 0.75rem;">3-30 letters, numbers, or underscores</small>
                </div>

                <div class="form-group">
                    <label for="email">Official / Personal Email Address</label>
                    <div class="auth-input-group">
                        <i class='bx bx-envelope input-icon'></i>
                        <input type="email" id="email" name="email" class="form-control" placeholder="juan.delacruz@example.com" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Create Password</label>
                    <div class="auth-input-group">
                        <i class='bx bx-lock-alt input-icon'></i>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Minimum 6 characters" minlength="6" required>
                        <button type="button" class="toggle-pwd-btn" onclick="togglePasswordVisibility('password', this)" title="Show/Hide Password">
                            <i class='bx bx-show'></i>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <div class="auth-input-group">
                        <i class='bx bx-check-shield input-icon'></i>
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Re-enter your password" minlength="6" required>
                        <button type="button" class="toggle-pwd-btn" onclick="togglePasswordVisibility('confirm_password', this)" title="Show/Hide Password">
                            <i class='bx bx-show'></i>
                        </button>
                    </div>
                </div>

                <input type="hidden" name="timezone" value="Asia/Manila">

                <div class="form-check small text-muted mb-3">
                    <input class="form-check-input" type="checkbox" id="termsCheck" required checked>
                    <label class="form-check-label" for="termsCheck">
                        I agree to the Republic of the Philippines Data Privacy Act of 2012 (RA 10173).
                    </label>
                </div>

                <button type="submit" class="btn btn-auth-submit">
                    <i class='bx bx-user-check me-1'></i> Create Citizen Account
                </button>

                <div class="auth-footer-links">
                    Already have a citizen account? <br>
                    <a href="login.php">Sign In Here</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function togglePasswordVisibility(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'bx bx-hide';
    } else {
        input.type = 'password';
        icon.className = 'bx bx-show';
    }
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
