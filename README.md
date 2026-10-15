# 🏛️ City Government of Cebu - Official Replica Portal
> **“Ang Kagamhanan sa Dakbayan sa Sugbo — Serbisyong Tinud-anay, Katungod sa Katawhan”**

A modern civic web application and municipal portal replica for the **City Government of Cebu, Philippines**. Built with native PHP and modern responsive CSS/JavaScript. Engineered to run **100% turnkey without requiring XAMPP, Apache, or separate database servers**, while maintaining full support for PostgreSQL and MySQL when configured.

---

## 🚀 Quick Start (Run Without XAMPP)

### Method 1: One-Click Launch (Windows)
Double-click [`serve.bat`](file:///c:/Users/Roronoa%20Zoro/Documents/GitHub/Cebu-City-Government-Replica-Website/serve.bat) in the root directory.  
It will automatically launch the portal at **`http://localhost:8000`** and open your default browser.

### Method 2: PowerShell
Run the included launcher:
```powershell
.\start.ps1
```

### Method 3: PHP Built-in Server CLI
```bash
php -S localhost:8000 router.php
```

---

## 🔑 Demo Citizen Account
For testing authenticated citizen features (citizen dashboard, appointment management, comment posting):

| Field | Demo Credential |
|---|---|
| **Username** | `citizen_cebu` |
| **Email** | `citizen@cebucity.gov.ph` |
| **Password** | `CebuCity2026!` |

---

## 📂 Project Architecture & Folder Organization

```
Cebu-City-Government-Replica-Website/
├── assets/                       # Organized Frontend Assets
│   ├── css/
│   │   ├── main.css              # Core Design System, PST Topbar, Navbar, Footer
│   │   ├── index.css             # Homepage Hero, E-Services, Stats, News Cards
│   │   ├── services.css          # Department Directory & Booking UI
│   │   ├── transparency.css      # Budget Allocation Chart & PDF Cards
│   │   ├── events.css            # Announcements Feed & Threaded Comments
│   │   ├── about-us.css          # History & City Council Directory
│   │   ├── contact-us.css        # 24/7 Hotlines & Feedback Cards
│   │   └── authentication.css    # Citizen Login, Register, Recovery Cards
│   ├── js/
│   │   ├── main.js               # Live PST Clock, A11y Toggles, Instant Search
│   │   ├── services.js           # Category Filters & AJAX Appointment Booking
│   │   ├── transparency.js       # Live Download Tracker & PDF Modal Preview
│   │   ├── events.js             # Read-More Toggles & AJAX Threaded Comments
│   │   └── contact-us.js         # Native PHP Citizen Feedback Submitter
│   ├── images/                   # 107 Official Photos, Seals, Logos, Officials
│   ├── pdf/                      # 12 Official Audited Financial Reports & Plantillas
│   └── fonts/                    # Smooth Fantasy & Web Typography
│
├── includes/                     # Backend Core & Modular Components
│   ├── db.php                    # Multi-Engine DB (SQLite Auto-Fallback + Postgres/MySQL)
│   ├── security.php              # Codex Security: CSRF, XSS Escaping, Headers, Rate Limiter
│   ├── auth.php                  # Session Management, Password Hashing, User Accessors
│   ├── header.php                # Unified Header with PST Bar & Citizen State
│   ├── footer.php                # Unified Footer with Emergency Strip & Hotlines
│   └── helpers.php               # Timezone (Asia/Manila), Flash Alerts, Currency
│
├── api/                          # RESTful JSON & AJAX Endpoints
│   ├── submit_feedback.php       # Native PHP Feedback Handler (Replaced Node.js)
│   ├── book_appointment.php      # Appointment Scheduler with Reference Codes
│   ├── track_download.php        # Atomic PDF Download Counter (Multi-DB)
│   ├── save_comment.php          # Threaded Comment Submitter (Anti-XSS)
│   └── load_comments.php         # Threaded Discussion Tree Renderer
│
├── auth/                         # Authentication Action Handlers
│   ├── login_action.php          # Login with Brute-Force Rate Limiting
│   ├── register_action.php       # Registration with BCrypt Cost 12
│   └── reset_action.php          # Password Reset Token Generator & Updater
│
├── scripts/                      # Maintenance & Utility Scripts
│   ├── maintenance/              # DB token cleanup, counter fixers, PDF initializers
│   └── logs/                     # Cleanup & system execution logs
│
├── data/                         # Local Persistent Storage
│   └── cebu_city.sqlite          # Auto-migrated SQLite Database (Zero-Config)
│
├── index.php                     # Civic Homepage
├── services.php                  # Services Catalog & Online Appointment Desk
├── transparency.php              # Full Disclosure Board & Budget Breakdown
├── events.php                    # Announcements & Citizen Discussion
├── about-us.php                  # City History & Elected Council
├── contact-us.php                # Emergency Hotlines & Feedback Desk
├── citizen-portal.php            # Logged-in Citizen Dashboard
├── login.php                     # Citizen Sign-In
├── register.php                  # Citizen Registration
├── forgot-password.php           # Password Recovery
├── reset-password.php            # New Password Entry
├── logout.php                    # Secure Session Destroyer
├── router.php                    # PHP Built-in Server Router
└── serve.bat                     # Windows Launch Script
```

---

## 🛡️ Codex Security Hardening
This portal was hardened against common OWASP/CWE web vulnerabilities:

1. **Cross-Site Request Forgery (CSRF)**:
   - Synchronizer token pattern with timing-safe `hash_equals()` verification on all POST actions.
2. **Cross-Site Scripting (XSS)**:
   - Strict `htmlspecialchars(..., ENT_QUOTES, 'UTF-8')` on all dynamic outputs.
3. **SQL Injection**:
   - 100% prepared statements via PDO across SQLite, PostgreSQL, and MySQL.
4. **Session Security & Fixation Defense**:
   - `session_regenerate_id(true)` invoked on login; session cookie flags set to `HttpOnly`, `SameSite=Lax`.
5. **Brute-Force & Spam Mitigation**:
   - In-memory rate limiting on login, registration, and feedback forms.
6. **Security Headers**:
   - Automatic emission of `X-Content-Type-Options: nosniff`, `X-Frame-Options: SAMEORIGIN`, and `Referrer-Policy: strict-origin-when-cross-origin`.

---

## 🎨 UI/UX Pro Max Civic Design System
- **Color Identity**: Cebu City Royal Navy (`#0B2545`), Golden Sun (`#FDB813`), Crisp Slate (`#F8FAFC`), Alert Red (`#D90429`).
- **Live PST Clock**: Real-time ticking Philippine Standard Time (UTC+8).
- **Accessibility (A11y)**: Built-in High Contrast toggle and Font Size scaling preserved via `localStorage`.
- **Instant Search**: Global fuzzy search modal triggered with `Ctrl + K` or `⌘K`.
- **Transparency Budget Chart**: Visual breakdown of the ₱10.8B annual city budget across health, infrastructure, and education.
- **24/7 Hotlines Strip**: Click-to-dial emergency directory for CCDRRMO (911), CCMC, CCTO, and CCPO.

---

## ⚙️ Optional Database Configuration (`.env`)
If you wish to connect to an external PostgreSQL or MySQL database instead of the built-in SQLite auto-fallback, create a `.env` file in the root:
```env
DB_DRIVER=pgsql
DB_HOST=localhost
DB_PORT=5432
DB_DATABASE=Integrative_Programming
DB_USERNAME=postgres
DB_PASSWORD=!*Lawrence1206
```
*(If the external database server is unreachable, the portal automatically and seamlessly falls back to SQLite).*
