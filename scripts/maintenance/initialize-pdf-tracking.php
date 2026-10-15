<?php
require_once 'db.php';

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$pdfs = [
    'MANPOWER-COMPLEMENT-2024-3RD-QUARTER.pdf',
    'MANPOWER-COMPLEMENT-2023-2ND-QUARTER.pdf',
    'MANPOWER COMPLEMENT BUDGET-2023-1ST QUARTER.pdf',
    'MANPOWER-COMPLEMENT-2ND-QUARTER-2022.pdf',
    '2024-Q2 FINANCIAL REPORTS.pdf',
    '2023-2ND QUARTER FINANCIAL REPORTS.pdf',
    '2022-4th Quarter Financial Reports.pdf',
    '2022 – 2nd Quarter Financial Reports.pdf',
    'FUN-RIDES-AND-CARNIVAL-VER.4.pdf',
    'PERFORMANCIRCUS-VER.-2.pdf',
    'Statement of Indebtedness Payments and Balances (SIPB) – Q3.pdf',
    'CCMC – Rate of Services.pdf'
];

foreach ($pdfs as $pdf) {
    try {
        // Check if record exists
        $checkStmt = $pdo->prepare("SELECT * FROM PDF_DOWNLOADS WHERE PDF_NAME = :name");
        $checkStmt->bindParam(':name', $pdf);
        $checkStmt->execute();
        
        if ($checkStmt->rowCount() == 0) {
            // Insert new record
            $insertStmt = $pdo->prepare("INSERT INTO PDF_DOWNLOADS (PDF_NAME, PDF_DOWNLOAD_COUNT) VALUES (:name, 0)");
            $insertStmt->bindParam(':name', $pdf);
            $insertStmt->execute();
            
            echo "Initialized: $pdf<br>";
        } else {
            echo "Already exists: $pdf<br>";
        }
    } catch (PDOException $e) {
        echo "Error with $pdf: " . $e->getMessage() . "<br>";
    }
}

echo "PDF tracking initialization complete.";
?>