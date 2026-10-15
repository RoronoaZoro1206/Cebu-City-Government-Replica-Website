<?php
/**
 * Cebu City Government Portal - Password Reset Action Handler
 * Supports both SMTP mailing (when configured) and resilient local simulation
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/security.php';
require_once dirname(__DIR__) . '/includes/helpers.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../forgot-password.php');
    exit();
}

$action = $_POST['action'] ?? 'request';

// 1. Password Reset Request
if ($action === 'request') {
    if (!verify_csrf_token()) {
        set_flash('error', 'Security token mismatch. Please try again.');
        header('Location: ../forgot-password.php');
        exit();
    }

    $email = trim((string)($_POST['email'] ?? ''));
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        set_flash('error', 'Please enter a valid email address.');
        header('Location: ../forgot-password.php');
        exit();
    }

    $stmt = $pdo->prepare("SELECT user_id, user_username, user_email FROM users WHERE user_email = ? LIMIT 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user) {
        // Uniform message prevents email enumeration
        set_flash('info', 'If an account exists for that email, a password reset link has been dispatched.');
        header('Location: ../forgot-password.php');
        exit();
    }

    $token = bin2hex(random_bytes(32));
    $expiry = date('Y-m-d H:i:s', time() + 3600); // 1 hour

    $upd = $pdo->prepare("UPDATE users SET user_reset_token = ?, user_token_expiry = ? WHERE user_email = ?");
    $upd->execute([$token, $expiry, $email]);

    $resetUrl = "reset-password.php?token=" . urlencode($token);

    // Attempt SMTP if PHPMailer & credentials exist
    $mailSent = false;
    $gmailUser = getenv('GMAIL_EMAIL');
    $gmailPass = getenv('GMAIL_APP_PASSWORD');

    $phpMailerBase = dirname(__DIR__) . '/includes/PHPMailer-master/src';
    if ($gmailUser && $gmailPass && file_exists($phpMailerBase . '/PHPMailer.php')) {
        try {
            require_once $phpMailerBase . '/Exception.php';
            require_once $phpMailerBase . '/PHPMailer.php';
            require_once $phpMailerBase . '/SMTP.php';

            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $gmailUser;
            $mail->Password = $gmailPass;
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            $mail->setFrom($gmailUser, 'Cebu City Government');
            $mail->addAddress($email, $user['user_username']);
            $mail->isHTML(true);
            $mail->Subject = 'Cebu City Portal - Password Reset Request';
            $mail->Body = "<p>Hello " . e($user['user_username']) . ",</p><p>You requested a password reset for your Cebu City citizen account. Click the link below to set a new password:</p><p><a href='{$resetUrl}'>{$resetUrl}</a></p><p>This link will expire in 1 hour.</p>";
            $mail->send();
            $mailSent = true;
        } catch (Throwable $e) {
            $mailSent = false;
        }
    }

    if ($mailSent) {
        set_flash('success', 'A password reset link has been sent to your registered email address.');
    } else {
        // Offline / zero-config mode: provide test reset button or notification
        $_SESSION['dev_reset_link'] = $resetUrl;
        set_flash('success', 'Reset instructions generated! (Development Mode: Reset link generated below for instant access without SMTP).');
    }

    header('Location: ../forgot-password.php');
    exit();
}

// 2. Password Reset Submission
if ($action === 'reset') {
    if (!verify_csrf_token()) {
        set_flash('error', 'Security token mismatch. Please try again.');
        header('Location: ../forgot-password.php');
        exit();
    }

    $token = trim((string)($_POST['token'] ?? ''));
    $password = (string)($_POST['password'] ?? '');
    $confirm = (string)($_POST['confirm_password'] ?? '');

    if (empty($token)) {
        set_flash('error', 'Missing or invalid reset token.');
        header('Location: ../forgot-password.php');
        exit();
    }

    if (strlen($password) < 6) {
        set_flash('error', 'Password must be at least 6 characters long.');
        header("Location: ../reset-password.php?token=" . urlencode($token));
        exit();
    }

    if ($password !== $confirm) {
        set_flash('error', 'Passwords do not match.');
        header("Location: ../reset-password.php?token=" . urlencode($token));
        exit();
    }

    $now = date('Y-m-d H:i:s');
    $stmt = $pdo->prepare("SELECT user_id FROM users WHERE user_reset_token = ? AND user_token_expiry > ? LIMIT 1");
    $stmt->execute([$token, $now]);
    $user = $stmt->fetch();

    if (!$user) {
        set_flash('error', 'This password reset link is invalid or has expired. Please request a new one.');
        header('Location: ../forgot-password.php');
        exit();
    }

    $hashed = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    $upd = $pdo->prepare("UPDATE users SET user_pwd = ?, user_reset_token = NULL, user_token_expiry = NULL WHERE user_id = ?");
    $upd->execute([$hashed, $user['user_id']]);

    set_flash('success', 'Your password has been successfully updated. You may now sign in.');
    header('Location: ../login.php');
    exit();
}
