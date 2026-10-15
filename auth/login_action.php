<?php
/**
 * Cebu City Government Portal - Login Action Handler
 * Hardened with Codex Security Standards:
 * - Anti-CSRF verification
 * - Rate limiting against brute-force attacks
 * - Timing-safe password verification
 * - Session fixation defense via session_regenerate_id
 * - Generic error messages to prevent username harvesting
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/security.php';
require_once dirname(__DIR__) . '/includes/helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../login.php');
    exit();
}

// 1. Verify CSRF token
if (!verify_csrf_token()) {
    set_flash('error', 'Security token mismatch. Please try submitting the form again.');
    header('Location: ../login.php');
    exit();
}

// 2. Check rate limit (10 attempts per minute)
if (!check_rate_limit('login_attempt', 10, 60)) {
    set_flash('error', 'Too many login attempts. Please wait 1 minute before trying again.');
    header('Location: ../login.php');
    exit();
}

$username = trim((string)($_POST['username'] ?? ''));
$password = (string)($_POST['password'] ?? '');

if (empty($username) || empty($password)) {
    set_flash('error', 'Please enter both your username/email and password.');
    header('Location: ../login.php');
    exit();
}

// Lookup by username or email
$stmt = $pdo->prepare("SELECT * FROM users WHERE user_username = ? OR user_email = ? LIMIT 1");
$stmt->execute([$username, $username]);
$user = $stmt->fetch();

if (!$user || !password_verify($password, $user['user_pwd'])) {
    // Generic message prevents username harvesting
    set_flash('error', 'Invalid login credentials. Please check your username/email and password.');
    header('Location: ../login.php');
    exit();
}

// Authentication successful - login user with session regeneration
login_user($user);

set_flash('success', 'Maayong pag-abot, ' . e($user['user_username']) . '! You have successfully signed in.');

$redirect = $_SESSION['login_redirect'] ?? '../index.php';
unset($_SESSION['login_redirect']);
header("Location: {$redirect}");
exit();
