<?php
/**
 * Cebu City Government Portal - Load Citizen Comments API
 * Secure threaded comment tree with anti-XSS escaping and modern card UI
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/helpers.php';
require_once dirname(__DIR__) . '/includes/security.php';

$eventId = filter_input(INPUT_GET, 'event_id', FILTER_VALIDATE_INT) ?: 1;

function renderCivicComments(PDO $pdo, int $eventId, ?int $parentId = null, int $level = 0): void {
    if ($level > 5) return; // Prevent excessive nesting

    $sql = $parentId === null
        ? "SELECT * FROM COMMENTS WHERE COMS_EVENT_ID = ? AND (COMS_PARENT_ID IS NULL OR COMS_PARENT_ID = 0) ORDER BY COMS_CREATED_AT ASC"
        : "SELECT * FROM COMMENTS WHERE COMS_EVENT_ID = ? AND COMS_PARENT_ID = ? ORDER BY COMS_CREATED_AT ASC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($parentId === null ? [$eventId] : [$eventId, $parentId]);
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($comments) && $level === 0) {
        echo '<div class="text-center py-4 text-muted civic-empty-comments">
                <i class="bx bx-message-rounded-dots fs-1 d-block mb-2 text-muted"></i>
                <p class="mb-0">No public comments yet for this announcement. Be the first citizen to comment!</p>
              </div>';
        return;
    }

    foreach ($comments as $comment) {
        $comId = (int)($comment['COMS_ID'] ?? $comment['coms_id']);
        $rawUsername = (string)($comment['COMS_USERNAME'] ?? $comment['coms_username']);
        $rawComment = (string)($comment['COMS_COMMENT'] ?? $comment['coms_comment']);
        $rawTime = (string)($comment['COMS_CREATED_AT'] ?? $comment['coms_created_at'] ?? '');
        $parentIdVal = $comment['COMS_PARENT_ID'] ?? $comment['coms_parent_id'] ?? null;

        $replyTo = '';
        if (!empty($parentIdVal)) {
            $stmtP = $pdo->prepare("SELECT COMS_USERNAME FROM COMMENTS WHERE COMS_ID = ?");
            $stmtP->execute([$parentIdVal]);
            $parentRow = $stmtP->fetch(PDO::FETCH_ASSOC);
            if ($parentRow) {
                $replyTo = $parentRow['COMS_USERNAME'] ?? $parentRow['coms_username'] ?? '';
            }
        }

        $formattedTime = format_ph_time($rawTime);
        $avatarLetter = strtoupper(substr($rawUsername, 0, 1));
        $indentStyle = $level > 0 ? "style='margin-left: " . min($level * 24, 96) . "px;'" : "";
        ?>
        <div class="civic-comment-node mb-3 <?= $level > 0 ? 'is-reply' : ''; ?>" <?= $indentStyle; ?>>
            <div class="d-flex gap-3 align-items-start">
                <div class="civic-comment-avatar">
                    <?= e($avatarLetter); ?>
                </div>
                <div class="civic-comment-bubble flex-grow-1">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <div>
                            <span class="fw-bold text-dark"><?= e($rawUsername); ?></span>
                            <?php if ($rawUsername === 'City Admin'): ?>
                                <span class="badge bg-primary text-white ms-1 text-xs"><i class='bx bx-check-shield'></i> Official</span>
                            <?php endif; ?>
                            <?php if ($replyTo): ?>
                                <small class="text-muted ms-2">
                                    <i class='bx bx-share'></i> reply to <strong class="text-primary">@<?= e($replyTo); ?></strong>
                                </small>
                            <?php endif; ?>
                        </div>
                        <small class="text-muted"><i class='bx bx-time'></i> <?= e($formattedTime); ?></small>
                    </div>
                    <div class="civic-comment-body">
                        <?= nl2br(e($rawComment)); ?>
                    </div>
                    <div class="mt-2">
                        <button type="button" class="btn btn-sm btn-link text-decoration-none p-0 text-primary reply-btn" data-id="<?= $comId; ?>" data-user="<?= e($rawUsername); ?>">
                            <i class='bx bx-reply'></i> Reply to this
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php
        // Recurse for replies
        renderCivicComments($pdo, $eventId, $comId, $level + 1);
    }
}

renderCivicComments($pdo, $eventId);
