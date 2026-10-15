<?php
/**
 * Cebu City Government Portal - Built-in PHP Server Router
 * Enables 100% turnkey local execution WITHOUT XAMPP, Apache, or separate database servers.
 * Usage: php -S localhost:8000 router.php
 */

declare(strict_types=1);

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/');

// Default home
if ($uri === '/' || $uri === '') {
    require __DIR__ . '/index.php';
    exit();
}

$filePath = __DIR__ . $uri;

// 1. Direct file match
if (is_file($filePath)) {
    // If it's a PHP file, execute it
    if (pathinfo($filePath, PATHINFO_EXTENSION) === 'php') {
        require $filePath;
        exit();
    }
    // Static asset - let PHP CLI server serve directly
    return false;
}

// 2. Legacy alias mapping: Images/ -> assets/images/
if (str_starts_with($uri, '/Images/')) {
    $alt = __DIR__ . '/assets/images/' . substr($uri, 8);
    if (is_file($alt)) {
        serve_static_file($alt);
        exit();
    }
}

// 3. Legacy alias mapping: PDF/ -> assets/pdf/
if (str_starts_with($uri, '/PDF/')) {
    $alt = __DIR__ . '/assets/pdf/' . substr($uri, 5);
    if (is_file($alt)) {
        serve_static_file($alt);
        exit();
    }
}

// 4. Check if appending .php matches an existing file (clean URLs)
if (is_file($filePath . '.php')) {
    require $filePath . '.php';
    exit();
}

// 5. 404 Handler
http_response_code(404);
$pageTitle = 'Page Not Found - 404';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>404 Not Found - Cebu City Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="text-center p-5 bg-white rounded-4 shadow-sm border" style="max-width: 500px;">
        <img src="assets/images/Cebu City Icon.png" alt="Cebu City" width="80" class="mb-3">
        <h1 class="fw-bold text-dark mb-2">404</h1>
        <h4 class="fw-bold text-dark mb-2">Page Not Found</h4>
        <p class="text-muted small mb-4">The city portal page or document you are looking for does not exist or may have been moved.</p>
        <a href="index.php" class="btn btn-primary px-4 fw-semibold">Return to City Portal Home</a>
    </div>
</body>
</html>
<?php
exit();

function serve_static_file(string $path): void {
    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    $mimes = [
        'css' => 'text/css',
        'js' => 'application/javascript',
        'json' => 'application/json',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'webp' => 'image/webp',
        'gif' => 'image/gif',
        'svg' => 'image/svg+xml',
        'pdf' => 'application/pdf',
        'woff' => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf' => 'font/ttf'
    ];
    $contentType = $mimes[$ext] ?? 'application/octet-stream';
    header("Content-Type: {$contentType}");
    header("Content-Length: " . filesize($path));
    readfile($path);
}
