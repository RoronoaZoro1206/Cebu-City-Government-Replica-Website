<?php
/**
 * Cebu City Government Portal - Logout Action
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/helpers.php';

logout_user();

set_flash('info', 'You have been logged out securely. Daghang salamat!');
header('Location: index.php');
exit();