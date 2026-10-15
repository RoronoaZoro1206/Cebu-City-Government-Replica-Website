# Cebu City Government Portal - PowerShell Server Launcher
# Run without XAMPP: powershell -ExecutionPolicy Bypass -File .\start.ps1

Write-Host "======================================================================" -ForegroundColor Cyan
Write-Host "          CEBU CITY GOVERNMENT OFFICIAL REPLICA PORTAL               " -ForegroundColor Yellow
Write-Host "          Serbisyong Tinud-anay, Katungod sa Katawhan                " -ForegroundColor White
Write-Host "======================================================================" -ForegroundColor Cyan
Write-Host ""

$env:Path = [System.Environment]::GetEnvironmentVariable("Path","Machine") + ";" + [System.Environment]::GetEnvironmentVariable("Path","User")
$phpPkgDir = "C:\Users\$env:USERNAME\AppData\Local\Microsoft\WinGet\Packages\PHP.PHP.8.3_Microsoft.Winget.Source_8wekyb3d8bbwe"
if (Test-Path $phpPkgDir) {
    $env:Path = "$phpPkgDir;$env:Path"
}

if (-not (Get-Command php -ErrorAction SilentlyContinue)) {
    Write-Host "[ERROR] PHP command was not found. Please install PHP via 'winget install PHP.PHP.8.3'" -ForegroundColor Red
    exit 1
}

Write-Host "[OK] PHP is active." -ForegroundColor Green
Write-Host "[PORTAL] Starting portal on http://localhost:8000" -ForegroundColor Cyan
Write-Host "[INFO] Press Ctrl+C in this terminal to stop the server.`n" -ForegroundColor Gray

Start-Process "http://localhost:8000"

php -S localhost:8000 router.php
