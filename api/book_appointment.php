<?php
/**
 * Cebu City Government Portal - Book Citizen Service Appointment API
 * Creates confirmed appointment slots with tracking reference codes
 */

declare(strict_types=1);

header('Content-Type: application/json; charset=UTF-8');

require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/security.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit();
}

$contentType = $_SERVER['CONTENT_TYPE'] ?? '';
if (strpos($contentType, 'application/json') !== false) {
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true) ?? [];
} else {
    $data = $_POST;
}

$name = trim((string)($data['citizen_name'] ?? ''));
$email = trim((string)($data['email'] ?? ''));
$phone = trim((string)($data['phone'] ?? ''));
$service = trim((string)($data['service'] ?? ''));
$date = trim((string)($data['date'] ?? ''));
$time = trim((string)($data['time'] ?? ''));
$notes = trim((string)($data['notes'] ?? ''));

// Validate required fields
if (empty($name) || empty($email) || empty($phone) || empty($service) || empty($date) || empty($time)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Please provide all required appointment details.']);
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Please provide a valid email address.']);
    exit();
}

// Generate unique reference code: CEBU-YYYY-XXXXX
$refCode = 'CEBU-' . date('Y') . '-' . strtoupper(bin2hex(random_bytes(3)));
$userId = is_logged_in() ? ((int)current_user()['user_id']) : null;
$cleanName = sanitize_text($name);
$cleanPhone = sanitize_text($phone);
$cleanService = sanitize_text($service);
$cleanNotes = sanitize_text($notes);
$now = date('Y-m-d H:i:s');

try {
    $stmt = $pdo->prepare("
        INSERT INTO APPOINTMENTS (APT_USER_ID, APT_CITIZEN_NAME, APT_EMAIL, APT_PHONE, APT_SERVICE, APT_DATE, APT_TIME, APT_NOTES, APT_STATUS, APT_REFERENCE_CODE, APT_CREATED_AT)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Confirmed', ?, ?)
    ");
    $stmt->execute([$userId, $cleanName, $email, $cleanPhone, $cleanService, $date, $time, $cleanNotes, $refCode, $now]);

    echo json_encode([
        'success' => true,
        'reference_code' => $refCode,
        'service' => $cleanService,
        'date' => $date,
        'time' => $time,
        'message' => 'Your appointment has been successfully scheduled!'
    ]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to save appointment. Please try again.']);
}
