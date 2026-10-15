<?php
/**
 * Cebu City Government Portal - Forgot Password
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/security.php';
require_once __DIR__ . '/includes/helpers.php';

$pageTitle = 'Forgot Password Recovery';
$customCss = 'assets/css/authentication.css';
require_once __DIR__ . '/includes/header.php';

$devResetLink = $_SESSION['dev_reset_link'] ?? null;
unset($_SESSION['dev_reset_link']);
?>

<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-header">
            <img src="assets/images/Cebu City Icon.png" alt="Cebu City Seal" class="auth-seal">
            <h3>Password Recovery</h3>
            <p>Enter your email to receive recovery instructions</p>
        </div>

        <div class="auth-body">
            <?php if ($devResetLink): ?>
                <div class="alert alert-info border border-info shadow-sm mb-3">
                    <div class="fw-bold mb-1"><i class='bx bx-laptop'></i> Development Mode Auto-Link:</div>
                    <small>SMTP is not configured locally. Click below to test password reset directly:</small>
                    <div class="mt-2">
                        <a href="<?= e($devResetLink); ?>" class="btn btn-sm btn-primary w-100 fw-bold">Proceed to Reset Password &rarr;</a>
                    </div>
                </div>
            <?php endif; ?>

            <form method="POST" action="auth/reset_action.php" autocomplete="off" class="auth-form">
                <?= csrf_field(); ?>
                <input type="hidden" name="action" value="request">

                <div class="form-group">
                    <label for="email">Account Email Address</label>
                    <div class="auth-input-group">
                        <i class='bx bx-envelope input-icon'></i>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Enter your registered email" required autofocus>
                    </div>
                </div>

                <button type="submit" class="btn btn-auth-submit">
                    <i class='bx bx-paper-plane me-1'></i> Request Reset Link
                </button>

                <div class="auth-footer-links">
                    Remember your password? <br>
                    <a href="login.php">Back to Sign In</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
