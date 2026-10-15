<?php
/**
 * Cebu City Government Portal - Register Action Handler
 * Hardened with Codex Security Standards:
 * - Anti-CSRF verification
 * - Strong password validation
 * - Input sanitization & uniqueness enforcement
 * - Secure BCrypt hashing (cost 12)
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/security.php';
require_once dirname(__DIR__) . '/includes/helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../register.php');
    exit();
}

// 1. Verify CSRF token
if (!verify_csrf_token()) {
    set_flash('error', 'Security token mismatch. Please try submitting the form again.');
    header('Location: ../register.php');
    exit();
}

// 2. Check rate limit
if (!check_rate_limit('register_attempt', 5, 60)) {
    set_flash('error', 'Too many registration attempts. Please wait 1 minute before trying again.');
    header('Location: ../register.php');
    exit();
}

$username = trim((string)($_POST['username'] ?? ''));
$email = trim((string)($_POST['email'] ?? ''));
$password = (string)($_POST['password'] ?? '');
$confirmPassword = (string)($_POST['confirm_password'] ?? '');
$timezone = trim((string)($_POST['timezone'] ?? 'Asia/Manila'));

if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
    set_flash('error', 'Please complete all required fields.');
    header('Location: ../register.php');
    exit();
}

if (!preg_match('/^[a-zA-Z0-9_]{3,30}$/', $username)) {
    set_flash('error', 'Username must be between 3 and 30 characters and contain only letters, numbers, and underscores.');
    header('Location: ../register.php');
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    set_flash('error', 'Please enter a valid email address.');
    header('Location: ../register.php');
    exit();
}

if (strlen($password) < 6) {
    set_flash('error', 'Password must be at least 6 characters long.');
    header('Location: ../register.php');
    exit();
}

if ($password !== $confirmPassword) {
    set_flash('error', 'Passwords do not match.');
    header('Location: ../register.php');
    exit();
}

// Check uniqueness
$stmt = $pdo->prepare("SELECT user_id FROM users WHERE user_username = ? LIMIT 1");
$stmt->execute([$username]);
if ($stmt->fetch()) {
    set_flash('error', 'The username "' . e($username) . '" is already registered. Please choose another.');
    header('Location: ../register.php');
    exit();
}

$stmt = $pdo->prepare("SELECT user_id FROM users WHERE user_email = ? LIMIT 1");
$stmt->execute([$email]);
if ($stmt->fetch()) {
    set_flash('error', 'That email address is already associated with an existing account. Please sign in or reset your password.');
    header('Location: ../register.php');
    exit();
}

try {
    create_citizen_user($pdo, $username, $email, $password, $timezone);
    set_flash('success', 'Registration successful! You may now sign in with your credentials.');
    header('Location: ../login.php');
    exit();
} catch (Throwable $e) {
    set_flash('error', 'An error occurred during registration. Please try again.');
    header('Location: ../register.php');
    exit();
}
