<?php
/**
 * Cebu City Government Portal - Citizen Login
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/security.php';
require_once __DIR__ . '/includes/helpers.php';

if (is_logged_in()) {
    header('Location: index.php');
    exit();
}

$pageTitle = 'Citizen Portal Login';
$customCss = 'assets/css/authentication.css';
require_once __DIR__ . '/includes/header.php';
?>

<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-header">
            <img src="assets/images/Cebu City Icon.png" alt="Cebu City Seal" class="auth-seal">
            <h3>Citizen Portal Login</h3>
            <p>Access your appointments, feedback, and city services</p>
        </div>

        <div class="auth-body">
            <form method="POST" action="auth/login_action.php" autocomplete="off" class="auth-form">
                <?= csrf_field(); ?>

                <div class="form-group">
                    <label for="username">Username or Email Address</label>
                    <div class="auth-input-group">
                        <i class='bx bx-user input-icon'></i>
                        <input type="text" id="username" name="username" class="form-control" placeholder="Enter username or email" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label for="password" class="mb-0">Password</label>
                        <a href="forgot-password.php" class="text-xs text-primary text-decoration-none">Forgot Password?</a>
                    </div>
                    <div class="auth-input-group">
                        <i class='bx bx-lock-alt input-icon'></i>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                        <button type="button" class="toggle-pwd-btn" onclick="togglePasswordVisibility('password', this)" title="Show/Hide Password">
                            <i class='bx bx-show'></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-auth-submit">
                    <i class='bx bx-log-in me-1'></i> Sign In to Portal
                </button>

                <div class="auth-footer-links">
                    Don't have a citizen account yet? <br>
                    <a href="register.php">Create Citizen Account</a>
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