<?php
/**
 * Cebu City Government Portal - Security & Hardening Module
 * Hardened with Codex Security practices:
 * - Secure HTTP headers
 * - Session hijacking & fixation prevention
 * - Cross-Site Request Forgery (CSRF) token generation & verification
 * - XSS defense escaping utilities
 * - In-memory / Session-based rate limiting
 */

declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    // Configure secure session cookie params prior to session_start
    if (!headers_sent()) {
        ini_set('session.cookie_httponly', '1');
        ini_set('session.use_only_cookies', '1');
        ini_set('session.cookie_samesite', 'Lax');
    }
    session_start();
}

/**
 * Apply secure HTTP response headers
 */
function apply_security_headers(): void {
    if (headers_sent()) {
        return;
    }
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('X-XSS-Protection: 1; mode=block');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: geolocation=(), camera=(), microphone=()');
}

// Automatically apply security headers
apply_security_headers();

/**
 * Generate or retrieve CSRF token
 */
function csrf_token(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Render a hidden CSRF input field
 */
function csrf_field(): string {
    $token = csrf_token();
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
}

/**
 * Validate CSRF token from request
 */
function verify_csrf_token(?string $token = null): bool {
    if ($token === null) {
        $token = $_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;
    }
    if (empty($token) || empty($_SESSION['csrf_token'])) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], (string)$token);
}

/**
 * HTML Escape helper (XSS Prevention)
 */
function e(?string $value): string {
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
}

/**
 * Sanitize plain string input
 */
function sanitize_text(string $input): string {
    $clean = trim($input);
    // Strip control characters
    $clean = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $clean);
    return $clean;
}

/**
 * Simple rate limiter to prevent brute-force attacks
 */
function check_rate_limit(string $key, int $maxAttempts = 5, int $windowSeconds = 60): bool {
    $now = time();
    $rateKey = 'rate_limit_' . $key;
    
    if (!isset($_SESSION[$rateKey])) {
        $_SESSION[$rateKey] = [];
    }
    
    // Filter out old attempts
    $_SESSION[$rateKey] = array_filter($_SESSION[$rateKey], function ($timestamp) use ($now, $windowSeconds) {
        return ($now - $timestamp) < $windowSeconds;
    });
    
    if (count($_SESSION[$rateKey]) >= $maxAttempts) {
        return false; // Rate limit exceeded
    }
    
    $_SESSION[$rateKey][] = $now;
    return true;
}
