<?php
/**
 * Root Database Delegation Proxy
 * Delegates to includes/db.php for multi-engine support and auto-migrations
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/db.php';
