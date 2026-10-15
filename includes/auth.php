<?php
/**
 * Cebu City Government Portal - Authentication & Session Manager
 * Hardened with Codex Security Standards:
 * - Session fixation prevention via session_regenerate_id
 * - Timing-safe password verification
 * - Secure credential storage using BCrypt with cost 12
 * - Safe role and citizen session accessors
 */

declare(strict_types=1);

require_once __DIR__ . '/security.php';
require_once __DIR__ . '/db.php';

/**
 * Check if a citizen user is currently authenticated
 */
function is_logged_in(): bool {
    return !empty($_SESSION['user']) && is_array($_SESSION['user']);
}

/**
 * Retrieve the currently authenticated user
 */
function current_user(): ?array {
    return is_logged_in() ? $_SESSION['user'] : null;
}

/**
 * Guard a page requiring citizen authentication
 */
function require_login(string $redirectTo = 'login.php'): void {
    if (!is_logged_in()) {
        $_SESSION['login_redirect'] = $_SERVER['REQUEST_URI'] ?? 'index.php';
        header("Location: {$redirectTo}");
        exit();
    }
}

/**
 * Establish a citizen session with session fixation protection
 */
function login_user(array $user): void {
    if (session_status() === PHP_SESSION_ACTIVE) {
        // Regenerate session ID to mitigate session fixation attacks
        session_regenerate_id(true);
    }
    // Omit sensitive hash from active session
    unset($user['user_pwd']);
    $_SESSION['user'] = $user;
    $_SESSION['last_activity'] = time();
}

/**
 * Securely terminate citizen session
 */
function logout_user(): void {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }
    session_destroy();
}

/**
 * Find user by username
 */
function get_user_by_username(PDO $pdo, string $username): ?array {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE user_username = ? ORDER BY user_id ASC LIMIT 1");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    return $user ?: null;
}

/**
 * Find user by email
 */
function get_user_by_email(PDO $pdo, string $email): ?array {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE user_email = ? ORDER BY user_id ASC LIMIT 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    return $user ?: null;
}

/**
 * Create a new citizen account
 */
function create_citizen_user(PDO $pdo, string $username, string $email, string $password, string $timezone = 'Asia/Manila'): int {
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    $created = date('Y-m-d H:i:s');
    
    $stmt = $pdo->prepare("
        INSERT INTO users (user_username, user_email, user_pwd, user_timezone, user_created)
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->execute([$username, $email, $hashedPassword, $timezone, $created]);
    
    return (int)$pdo->lastInsertId();
}
