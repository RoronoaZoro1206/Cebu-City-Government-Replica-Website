<?php
/**
 * Cebu City Government Portal - Save Citizen Comment API
 * Hardened with Codex Security Standards:
 * - Anti-XSS content sanitization
 * - Length validation and parameter binding
 * - Session identity preservation
 */

declare(strict_types=1);

header('Content-Type: application/json; charset=UTF-8');

require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/security.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit();
}

$eventId = filter_input(INPUT_POST, 'event_id', FILTER_VALIDATE_INT);
$parentId = filter_input(INPUT_POST, 'parent_id', FILTER_VALIDATE_INT) ?: null;
$username = trim((string)($_POST['username'] ?? ''));
$comment = trim((string)($_POST['comment'] ?? ''));

// If citizen is logged in, use their verified username
if (is_logged_in()) {
    $citizen = current_user();
    $username = $citizen['user_username'] ?? $username;
}

if (!$eventId || empty($username) || empty($comment)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Please provide event ID, citizen name, and your comment.']);
    exit();
}

if (mb_strlen($comment) > 1000) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Comment cannot exceed 1,000 characters.']);
    exit();
}

$cleanUsername = sanitize_text($username);
$cleanComment = sanitize_text($comment);
$now = date('Y-m-d H:i:s');

try {
    $sql = "INSERT INTO COMMENTS (COMS_EVENT_ID, COMS_PARENT_ID, COMS_USERNAME, COMS_COMMENT, COMS_CREATED_AT) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$eventId, $parentId, $cleanUsername, $cleanComment, $now]);
    
    $commentId = (int)$pdo->lastInsertId();
    echo json_encode([
        'success' => true,
        'comment_id' => $commentId,
        'message' => 'Comment posted successfully'
    ]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Failed to save comment']);
}
