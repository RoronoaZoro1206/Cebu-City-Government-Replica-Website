<?php
/**
 * Cebu City Government Portal - Reset Password Form
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/security.php';
require_once __DIR__ . '/includes/helpers.php';

$token = trim((string)($_GET['token'] ?? ''));

$isValid = false;
$username = '';

if (!empty($token)) {
    $now = date('Y-m-d H:i:s');
    $stmt = $pdo->prepare("SELECT user_id, user_username FROM users WHERE user_reset_token = ? AND user_token_expiry > ? LIMIT 1");
    $stmt->execute([$token, $now]);
    $user = $stmt->fetch();
    if ($user) {
        $isValid = true;
        $username = $user['user_username'];
    }
}

$pageTitle = 'Reset Account Password';
$customCss = 'assets/css/authentication.css';
require_once __DIR__ . '/includes/header.php';
?>

<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-header">
            <img src="assets/images/Cebu City Icon.png" alt="Cebu City Seal" class="auth-seal">
            <h3>Reset Password</h3>
            <p>Create a secure new password for your account</p>
        </div>

        <div class="auth-body">
            <?php if (!$isValid): ?>
                <div class="alert alert-danger">
                    <i class='bx bx-error-circle me-1'></i>
                    This password reset link is invalid or has expired. Please request a new recovery link.
                </div>
                <div class="text-center mt-3">
                    <a href="forgot-password.php" class="btn btn-outline-primary btn-sm">Request New Link</a>
                </div>
            <?php else: ?>
                <div class="mb-3 text-center">
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2">
                        Citizen: <strong><?= e($username); ?></strong>
                    </span>
                </div>

                <form method="POST" action="auth/reset_action.php" autocomplete="off" class="auth-form">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="action" value="reset">
                    <input type="hidden" name="token" value="<?= e($token); ?>">

                    <div class="form-group">
                        <label for="password">New Password</label>
                        <div class="auth-input-group">
                            <i class='bx bx-lock-alt input-icon'></i>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Minimum 6 characters" minlength="6" required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Confirm New Password</label>
                        <div class="auth-input-group">
                            <i class='bx bx-check-shield input-icon'></i>
                            <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Re-enter new password" minlength="6" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-auth-submit">
                        <i class='bx bx-save me-1'></i> Update Password
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>