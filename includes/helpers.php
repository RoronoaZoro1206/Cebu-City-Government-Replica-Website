<?php
/**
 * Cebu City Government Portal - Helpers & Utilities
 * Provides Philippine Standard Time (PST), date formatting, navigation helpers, and flash messages
 */

declare(strict_types=1);

/**
 * Format timestamp into Philippine Standard Time (PST, UTC+8)
 */
function format_ph_time(?string $timestamp, string $format = 'F j, Y - g:i A'): string {
    if (empty($timestamp)) {
        return 'N/A';
    }
    try {
        $dt = new DateTime($timestamp);
        $dt->setTimezone(new DateTimeZone('Asia/Manila'));
        return $dt->format($format);
    } catch (Exception $e) {
        return (string)$timestamp;
    }
}

/**
 * Format Philippine Peso Currency
 */
function format_peso(float $amount): string {
    return '₱' . number_format($amount, 2);
}

/**
 * Set flash alert in session
 */
function set_flash(string $type, string $message): void {
    if (session_status() === PHP_SESSION_ACTIVE) {
        $_SESSION['flash_' . $type] = $message;
    }
}

/**
 * Render and consume flash alert
 */
function render_flash(): string {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        return '';
    }
    $html = '';
    $types = ['success' => 'alert-success', 'error' => 'alert-danger', 'info' => 'alert-info', 'warning' => 'alert-warning'];
    
    foreach ($types as $key => $cssClass) {
        $sessionKey = 'flash_' . $key;
        if (!empty($_SESSION[$sessionKey])) {
            $msg = htmlspecialchars((string)$_SESSION[$sessionKey], ENT_QUOTES, 'UTF-8');
            $html .= "<div class='alert {$cssClass} alert-dismissible fade show civic-alert' role='alert'>
                        <span>{$msg}</span>
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                      </div>";
            unset($_SESSION[$sessionKey]);
        }
    }
    return $html;
}

/**
 * Check if the current page matches the given navigation link
 */
function is_active_nav(string $path): string {
    $current = basename($_SERVER['PHP_SELF'] ?? '');
    return ($current === $path) ? 'active' : '';
}
