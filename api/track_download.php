<?php
/**
 * Cebu City Government Portal - PDF Download Tracker API
 * Universal cross-database support (SQLite, PostgreSQL, MySQL)
 * Atomically increments download counts and logs Philippine Standard Time
 */

declare(strict_types=1);

header('Content-Type: application/json; charset=UTF-8');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/helpers.php';

$method = $_SERVER['REQUEST_METHOD'];

// 1. GET: Retrieve download count and last downloaded timestamp
if ($method === 'GET' && isset($_GET['pdf'])) {
    $pdf = trim((string)$_GET['pdf']);
    
    // Security check: ensure string doesn't contain directory traversal
    $pdf = basename($pdf);
    
    try {
        $stmt = $pdo->prepare("SELECT PDF_DOWNLOAD_COUNT, PDF_LAST_DOWNLOADED FROM PDF_DOWNLOADS WHERE PDF_NAME = ?");
        $stmt->execute([$pdf]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $count = (int)($row['PDF_DOWNLOAD_COUNT'] ?? $row['pdf_download_count'] ?? 0);
            $lastRaw = $row['PDF_LAST_DOWNLOADED'] ?? $row['pdf_last_downloaded'] ?? null;
            $formattedTime = $lastRaw ? format_ph_time($lastRaw) : 'Never';

            echo json_encode([
                'success' => true,
                'count' => $count,
                'last_downloaded' => $formattedTime
            ]);
        } else {
            echo json_encode([
                'success' => true,
                'count' => 0,
                'last_downloaded' => 'Never'
            ]);
        }
    } catch (Throwable $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Database query failed']);
    }
    exit();
}

// 2. POST: Increment download count
if ($method === 'POST' && isset($_POST['pdf'])) {
    $pdf = basename(trim((string)$_POST['pdf']));
    
    if (empty($pdf)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid PDF identifier']);
        exit();
    }

    try {
        $now = date('Y-m-d H:i:s');
        
        // Check for record
        $checkStmt = $pdo->prepare("SELECT PDF_DOWNLOAD_COUNT, PDF_LAST_DOWNLOADED FROM PDF_DOWNLOADS WHERE PDF_NAME = ?");
        $checkStmt->execute([$pdf]);
        $existing = $checkStmt->fetch(PDO::FETCH_ASSOC);

        if ($existing) {
            $lastRaw = $existing['PDF_LAST_DOWNLOADED'] ?? $existing['pdf_last_downloaded'] ?? null;
            if ($lastRaw) {
                $lastTime = strtotime((string)$lastRaw);
                // Debounce rapid clicks within 2 seconds
                if ($lastTime && (time() - $lastTime) < 2) {
                    echo json_encode(['success' => true, 'message' => 'Increment skipped (rate limited)']);
                    exit();
                }
            }

            $updateStmt = $pdo->prepare("UPDATE PDF_DOWNLOADS SET PDF_DOWNLOAD_COUNT = PDF_DOWNLOAD_COUNT + 1, PDF_LAST_DOWNLOADED = ? WHERE PDF_NAME = ?");
            $updateStmt->execute([$now, $pdf]);
        } else {
            $insertStmt = $pdo->prepare("INSERT INTO PDF_DOWNLOADS (PDF_NAME, PDF_DOWNLOAD_COUNT, PDF_LAST_DOWNLOADED) VALUES (?, 1, ?)");
            $insertStmt->execute([$pdf, $now]);
        }

        // Return updated stats
        $stmt = $pdo->prepare("SELECT PDF_DOWNLOAD_COUNT, PDF_LAST_DOWNLOADED FROM PDF_DOWNLOADS WHERE PDF_NAME = ?");
        $stmt->execute([$pdf]);
        $updated = $stmt->fetch(PDO::FETCH_ASSOC);
        $newCount = (int)($updated['PDF_DOWNLOAD_COUNT'] ?? $updated['pdf_download_count'] ?? 1);

        echo json_encode([
            'success' => true,
            'count' => $newCount,
            'last_downloaded' => format_ph_time($now)
        ]);
    } catch (Throwable $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Failed to increment download counter']);
    }
    exit();
}

http_response_code(405);
echo json_encode(['success' => false, 'message' => 'Method not allowed']);
