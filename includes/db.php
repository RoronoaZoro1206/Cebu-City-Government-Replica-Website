<?php
/**
 * Cebu City Government Portal - Database Connection & Portable Storage Layer
 * Supports:
 * 1. Automatic SQLite fallback for zero-configuration, XAMPP-free local execution
 * 2. Seamless PostgreSQL / MySQL connection when external server is running
 * 3. Self-healing database migration and initial seed data population
 */

declare(strict_types=1);

require_once __DIR__ . '/security.php';

// Load environment variables if available
$envFile = dirname(__DIR__) . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#') || str_starts_with($line, ';')) {
            continue;
        }
        if (strpos($line, '=') !== false) {
            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value, " \t\n\r\0\x0B\"'");
            putenv("$name=$value");
            $_ENV[$name] = $value;
        }
    }
}

$dbDriver = getenv('DB_DRIVER') ?: 'auto';
$dbHost = getenv('DB_HOST') ?: 'localhost';
$dbPort = getenv('DB_PORT') ?: '5432';
$dbName = getenv('DB_DATABASE') ?: 'Integrative_Programming';
$dbUser = getenv('DB_USERNAME') ?: 'postgres';
$dbPass = getenv('DB_PASSWORD') ?: '!*Lawrence1206';

$pdo = null;
$activeDriver = 'sqlite';

// Try PostgreSQL first if requested or in auto mode
if ($dbDriver === 'pgsql' || $dbDriver === 'auto') {
    if (extension_loaded('pdo_pgsql')) {
        try {
            $dsn = "pgsql:host={$dbHost};port={$dbPort};dbname={$dbName};connect_timeout=2";
            $pdo = new PDO($dsn, $dbUser, $dbPass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_TIMEOUT => 2
            ]);
            $pdo->exec("SET TIME ZONE INTERVAL '+08:00'");
            $activeDriver = 'pgsql';
        } catch (Throwable $e) {
            // Postgres connection failed, fallback will proceed
            $pdo = null;
        }
    }
}

// Try MySQL if configured
if (!$pdo && ($dbDriver === 'mysql')) {
    if (extension_loaded('pdo_mysql')) {
        try {
            $dsn = "mysql:host={$dbHost};port=" . (getenv('DB_PORT') ?: '3306') . ";dbname={$dbName};charset=utf8mb4";
            $pdo = new PDO($dsn, $dbUser, $dbPass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_TIMEOUT => 2
            ]);
            $activeDriver = 'mysql';
        } catch (Throwable $e) {
            $pdo = null;
        }
    }
}

// Resilient Portable Fallback: SQLite
if (!$pdo) {
    $dataDir = dirname(__DIR__) . '/data';
    if (!is_dir($dataDir)) {
        @mkdir($dataDir, 0755, true);
    }
    $sqlitePath = $dataDir . '/cebu_city.sqlite';
    try {
        $pdo = new PDO("sqlite:" . $sqlitePath, null, null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        $pdo->exec("PRAGMA journal_mode = WAL;");
        $pdo->exec("PRAGMA foreign_keys = ON;");
        $activeDriver = 'sqlite';
    } catch (Throwable $e) {
        die("Database connection failed. Please ensure SQLite or PostgreSQL is enabled: " . htmlspecialchars($e->getMessage()));
    }
}

/**
 * Auto-initialize database tables and seed initial civic data
 */
function initialize_cebu_database(PDO $pdo, string $driver): void {
    if ($driver === 'sqlite') {
        // SQLite Schema
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS users (
                user_id INTEGER PRIMARY KEY AUTOINCREMENT,
                user_username TEXT UNIQUE NOT NULL,
                user_email TEXT UNIQUE NOT NULL,
                user_pwd TEXT NOT NULL,
                user_timezone TEXT DEFAULT 'Asia/Manila',
                user_created TEXT,
                user_reset_token TEXT,
                user_token_expiry TEXT
            );

            CREATE TABLE IF NOT EXISTS COMMENTS (
                COMS_ID INTEGER PRIMARY KEY AUTOINCREMENT,
                COMS_EVENT_ID INTEGER NOT NULL,
                COMS_PARENT_ID INTEGER NULL,
                COMS_USERNAME TEXT NOT NULL,
                COMS_COMMENT TEXT NOT NULL,
                COMS_CREATED_AT DATETIME DEFAULT CURRENT_TIMESTAMP
            );

            CREATE TABLE IF NOT EXISTS PDF_DOWNLOADS (
                PDF_ID INTEGER PRIMARY KEY AUTOINCREMENT,
                PDF_NAME TEXT UNIQUE NOT NULL,
                PDF_DOWNLOAD_COUNT INTEGER DEFAULT 0,
                PDF_LAST_DOWNLOADED DATETIME
            );

            CREATE TABLE IF NOT EXISTS FEEDBACK (
                FB_ID INTEGER PRIMARY KEY AUTOINCREMENT,
                FB_NAME TEXT NOT NULL,
                FB_EMAIL TEXT NOT NULL,
                FB_MESSAGE TEXT NOT NULL,
                FB_CREATED_AT DATETIME DEFAULT CURRENT_TIMESTAMP
            );

            CREATE TABLE IF NOT EXISTS APPOINTMENTS (
                APT_ID INTEGER PRIMARY KEY AUTOINCREMENT,
                APT_USER_ID INTEGER NULL,
                APT_CITIZEN_NAME TEXT NOT NULL,
                APT_EMAIL TEXT NOT NULL,
                APT_PHONE TEXT NOT NULL,
                APT_SERVICE TEXT NOT NULL,
                APT_DATE TEXT NOT NULL,
                APT_TIME TEXT NOT NULL,
                APT_NOTES TEXT NULL,
                APT_STATUS TEXT DEFAULT 'Confirmed',
                APT_REFERENCE_CODE TEXT UNIQUE NOT NULL,
                APT_CREATED_AT DATETIME DEFAULT CURRENT_TIMESTAMP
            );
        ");
    } else {
        // PostgreSQL / MySQL Schema
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS users (
                user_id SERIAL PRIMARY KEY,
                user_username VARCHAR(100) UNIQUE NOT NULL,
                user_email VARCHAR(150) UNIQUE NOT NULL,
                user_pwd VARCHAR(255) NOT NULL,
                user_timezone VARCHAR(50) DEFAULT 'Asia/Manila',
                user_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                user_reset_token VARCHAR(255),
                user_token_expiry TIMESTAMP
            );

            CREATE TABLE IF NOT EXISTS COMMENTS (
                COMS_ID SERIAL PRIMARY KEY,
                COMS_EVENT_ID INT NOT NULL,
                COMS_PARENT_ID INT NULL,
                COMS_USERNAME VARCHAR(100) NOT NULL,
                COMS_COMMENT TEXT NOT NULL,
                COMS_CREATED_AT TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );

            CREATE TABLE IF NOT EXISTS PDF_DOWNLOADS (
                PDF_ID SERIAL PRIMARY KEY,
                PDF_NAME VARCHAR(255) UNIQUE NOT NULL,
                PDF_DOWNLOAD_COUNT INT DEFAULT 0,
                PDF_LAST_DOWNLOADED TIMESTAMP
            );

            CREATE TABLE IF NOT EXISTS FEEDBACK (
                FB_ID SERIAL PRIMARY KEY,
                FB_NAME VARCHAR(150) NOT NULL,
                FB_EMAIL VARCHAR(150) NOT NULL,
                FB_MESSAGE TEXT NOT NULL,
                FB_CREATED_AT TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );

            CREATE TABLE IF NOT EXISTS APPOINTMENTS (
                APT_ID SERIAL PRIMARY KEY,
                APT_USER_ID INT NULL,
                APT_CITIZEN_NAME VARCHAR(150) NOT NULL,
                APT_EMAIL VARCHAR(150) NOT NULL,
                APT_PHONE VARCHAR(50) NOT NULL,
                APT_SERVICE VARCHAR(150) NOT NULL,
                APT_DATE VARCHAR(50) NOT NULL,
                APT_TIME VARCHAR(50) NOT NULL,
                APT_NOTES TEXT,
                APT_STATUS VARCHAR(50) DEFAULT 'Confirmed',
                APT_REFERENCE_CODE VARCHAR(100) UNIQUE NOT NULL,
                APT_CREATED_AT TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );
        ");
    }

    // Seed default demo user if table is empty
    $checkUser = $pdo->query("SELECT COUNT(*) as cnt FROM users")->fetch();
    if ((int)($checkUser['cnt'] ?? 0) === 0) {
        $hashed = password_hash('CebuCity2026!', PASSWORD_BCRYPT, ['cost' => 12]);
        $stmt = $pdo->prepare("INSERT INTO users (user_username, user_email, user_pwd, user_timezone, user_created) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute(['citizen_cebu', 'citizen@cebucity.gov.ph', $hashed, 'Asia/Manila', date('Y-m-d H:i:s')]);
    }

    // Seed PDF records
    $pdfs = [
        'MANPOWER-COMPLEMENT-2024-3RD-QUARTER.pdf' => 142,
        'MANPOWER-COMPLEMENT-2023-2ND-QUARTER.pdf' => 98,
        'MANPOWER COMPLEMENT BUDGET-2023-1ST QUARTER.pdf' => 115,
        'MANPOWER-COMPLEMENT-2ND-QUARTER-2022.pdf' => 84,
        '2024-Q2 FINANCIAL REPORTS.pdf' => 312,
        '2023-2ND QUARTER FINANCIAL REPORTS.pdf' => 245,
        '2022-4th Quarter Financial Reports.pdf' => 189,
        '2022 – 2nd Quarter Financial Reports.pdf' => 167,
        'FUN-RIDES-AND-CARNIVAL-VER.4.pdf' => 76,
        'PERFORMANCIRCUS-VER.-2.pdf' => 64,
        'Statement of Indebtedness Payments and Balances (SIPB) – Q3.pdf' => 205,
        'CCMC – Rate of Services.pdf' => 450
    ];

    $checkPdfs = $pdo->query("SELECT COUNT(*) as cnt FROM PDF_DOWNLOADS")->fetch();
    if ((int)($checkPdfs['cnt'] ?? 0) === 0) {
        $pdfStmt = $pdo->prepare("INSERT INTO PDF_DOWNLOADS (PDF_NAME, PDF_DOWNLOAD_COUNT, PDF_LAST_DOWNLOADED) VALUES (?, ?, ?)");
        foreach ($pdfs as $pdfName => $initialCount) {
            $pdfStmt->execute([$pdfName, $initialCount, date('Y-m-d H:i:s', time() - rand(3600, 864000))]);
        }
    }

    // Seed initial comments if empty
    $checkComments = $pdo->query("SELECT COUNT(*) as cnt FROM COMMENTS")->fetch();
    if ((int)($checkComments['cnt'] ?? 0) === 0) {
        $cStmt = $pdo->prepare("INSERT INTO COMMENTS (COMS_EVENT_ID, COMS_PARENT_ID, COMS_USERNAME, COMS_COMMENT, COMS_CREATED_AT) VALUES (?, ?, ?, ?, ?)");
        $cStmt->execute([1, null, 'Maria Santos', 'Pit Senyor! Very excited for the Sinulog Festival 2026 grand parade schedule.', date('Y-m-d H:i:s', time() - 7200)]);
        $cStmt->execute([1, 1, 'City Admin', 'Pit Senyor Maria! Traffic advisories and grand parade guidelines will be posted here.', date('Y-m-d H:i:s', time() - 3600)]);
        $cStmt->execute([2, null, 'Juan Dela Cruz', 'Glad to see the Charter Day medical mission includes CCMC free consultations.', date('Y-m-d H:i:s', time() - 14400)]);
    }
}

// Execute auto-initialization once per run
try {
    initialize_cebu_database($pdo, $activeDriver);
} catch (Throwable $e) {
    error_log("Database initialization notice: " . $e->getMessage());
}

// Global variable for current driver
$GLOBALS['ACTIVE_DB_DRIVER'] = $activeDriver;
