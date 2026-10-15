@echo off
title Cebu City Government Replica Portal
echo ======================================================================
echo           CEBU CITY GOVERNMENT OFFICIAL REPLICA PORTAL
echo           Serbisyong Tinud-anay, Katungod sa Katawhan
echo ======================================================================
echo.
echo Starting standalone PHP built-in web server (No XAMPP required)...
echo.

:: Refresh PATH to include winget PHP if needed
set "PATH=%PATH%;C:\Users\%USERNAME%\AppData\Local\Microsoft\WinGet\Packages\PHP.PHP.8.3_Microsoft.Winget.Source_8wekyb3d8bbwe"

:: Test if php is accessible
where php >nul 2>nul
if %ERRORLEVEL% neq 0 (
    echo [ERROR] PHP executable was not found in PATH!
    echo Please install PHP or run 'winget install PHP.PHP.8.3'
    pause
    exit /b 1
)

echo [OK] PHP is ready.
echo [PORTAL] Opening Cebu City Government Portal at http://localhost:8000
echo [INFO] Press Ctrl+C at any time to stop the server.
echo.

:: Open default browser after 1 second delay
start "" http://localhost:8000

:: Start PHP built-in server with router.php
php -S localhost:8000 router.php
pause
