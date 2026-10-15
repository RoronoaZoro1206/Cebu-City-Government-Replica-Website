<?php
/**
 * Cebu City Government Portal - Citizen Feedback Submission API
 * Native PHP Implementation (Eliminating dependency on external Node.js Express server)
 * Stores citizen inquiries directly into FEEDBACK table
 */

declare(strict_types=1);

header('Content-Type: application/json; charset=UTF-8');

require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/security.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit();
}

// Support both JSON payload and standard POST FormData
$contentType = $_SERVER['CONTENT_TYPE'] ?? '';
if (strpos($contentType, 'application/json') !== false) {
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true) ?? [];
} else {
    $data = $_POST;
}

$name = trim((string)($data['name'] ?? ''));
$email = trim((string)($data['email'] ?? ''));
$message = trim((string)($data['message'] ?? ''));

// Validation
if (empty($name) || empty($email) || empty($message)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Please fill in all required fields (Name, Email, Message).']);
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Please provide a valid email address.']);
    exit();
}

// Sanitization
$cleanName = sanitize_text($name);
$cleanEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
$cleanMessage = sanitize_text($message);

try {
    $stmt = $pdo->prepare("INSERT INTO FEEDBACK (FB_NAME, FB_EMAIL, FB_MESSAGE) VALUES (?, ?, ?)");
    $stmt->execute([$cleanName, $cleanEmail, $cleanMessage]);
    
    echo json_encode([
        'success' => true,
        'message' => 'Daghang Salamat! Your feedback has been received and routed to the Mayor’s Citizen Action Center.'
    ]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to submit feedback. Please try again later.']);
}
