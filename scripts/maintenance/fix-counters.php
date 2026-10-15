<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: Thu, 01 Jan 1970 00:00:00 GMT");
require_once 'db.php';

try {
    // Option 1: Reset all counters to specific values
    if (isset($_GET['action']) && $_GET['action'] === 'reset') {
        $stmt = $pdo->prepare("UPDATE PDF_DOWNLOADS SET PDF_DOWNLOAD_COUNT = 0");
        $stmt->execute();
        echo "All download counters have been reset to zero!";
    }
    
    // Option 2: Fix the specific PDF counter value
    if (isset($_GET['pdf']) && isset($_GET['count'])) {
        $pdf = $_GET['pdf'];
        $count = (int)$_GET['count'];
        
        $stmt = $pdo->prepare("UPDATE PDF_DOWNLOADS SET PDF_DOWNLOAD_COUNT = :count WHERE PDF_NAME = :name");
        $stmt->bindParam(':count', $count);
        $stmt->bindParam(':name', $pdf);
        $stmt->execute();
        
        echo "Counter for $pdf set to $count!";
    }
    
    // List all current counters
    echo "<h2>Current Download Counts:</h2>";
    $stmt = $pdo->query("SELECT PDF_NAME, PDF_DOWNLOAD_COUNT, PDF_LAST_DOWNLOADED FROM PDF_DOWNLOADS ORDER BY PDF_DOWNLOAD_COUNT DESC");
    echo "<table border='1'><tr><th>PDF Name</th><th>Count</th><th>Last Downloaded</th></tr>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $row['pdf_name'] . "</td>";
        echo "<td>" . $row['pdf_download_count'] . "</td>";
        echo "<td>" . $row['pdf_last_downloaded'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "<p><a href='fix-counters.php?action=reset'>Reset All Counters to Zero</a></p>";
    echo "<p><a href='transparency.php'>Return to Transparency Page</a></p>";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>