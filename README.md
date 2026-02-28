# MobiFlow — Sticky Floating Mobile Button for Call, Messaging & Booking

[![WordPress Requirements](https://img.shields.io/badge/WordPress-6.9.1%2B-0073AA.svg?style=flat-square&logo=wordpress)](https://wordpress.org/download/)
[![PHP Requirements](https://img.shields.io/badge/PHP-8.0%2B-777BB4.svg?style=flat-square&logo=php)](https://www.php.net/downloads)
[![License](https://img.shields.io/badge/License-GPL--2.0--or--later-brightgreen.svg?style=flat-square)](LICENSE)

**MobiFlow** is a lightweight, performance-optimized WordPress plugin designed to add a sticky floating "Call to Action" (CTA) button to websites, specifically for mobile devices. It aims to solve "lead leaks" for local businesses by ensuring a primary contact action (Call, WhatsApp, Booking URL, or Smooth Scroll) is always within thumb-reach as a user scrolls.

## 🚀 Key Features

- **Click-to-Call** — Tapping the button instantly dials your phone number.
- **WhatsApp Integration** — Opens WhatsApp with a pre-filled, customizable message.
- **Booking & External URLs** — Send visitors directly to your booking page or any external link.
- **Smooth Scroll** — Scrolls the page to a specific section using an anchor ID (#contact).
- **Live Preview** — See exactly how your button looks in real-time as you edit settings in the admin dashboard.
- **Mobile-Only Display** — Zero desktop bloat. Hidden on screens > 767px via CSS and JS dual-enforcement.
- **Page-Level Exclusion** — Easily hide the button on specific pages using slugs or IDs.
- **Performance Optimized** — Sub-5kb total asset size with zero external dependencies (No jQuery, No React).

## 🛠 Tech Stack

- **PHP:** 8.0+ (Namespaced, Object-Oriented, Manual PSR-4 Autoloading).
- **WordPress:** 6.5+ (Utilizes Settings API and Frontend Footer Injection).
- **JavaScript:** Vanilla ES6 (Dependency-free for maximum performance).
- **CSS:** Vanilla CSS3 (Flexbox for positioning, CSS variables for dynamic styling).
- **Composer:** Used for development dependencies and quality control (PHPCS/WPCS).

## 🏗 Architecture & Directory Structure

The project follows a modular, object-oriented approach for clean separation of concerns.

- `mobiflow.php` — Main plugin entry point and manual PSR-4 autoloader.
- `includes/` — Core logic and classes.
    - `Core.php` — Singleton coordinator that initializes Admin and Frontend components.
    - `Admin/Settings.php` — Handles the WordPress Settings API, sanitization, and the admin UI.
    - `Frontend/Renderer.php` — Manages frontend HTML injection and dynamic asset enqueuing.
- `assets/` — Frontend and Admin assets.
    - `css/` — `mobiflow.css` (Floating button) and `admin-settings.css`.
    - `js/` — `mobiflow.js` (Visibility logic) and `admin-settings.js` (Live preview).
- `languages/` — Translation files (.pot).

## 💻 Development Setup

### Local Environment
Requires a local WordPress installation (e.g., LocalWP, DevKinsta).

```bash
# Clone the repository
git clone https://github.com/gasatrya/mobiflow.git

# Install development dependencies (PHPCS / WordPress Coding Standards)
composer install
```

### Quality Control
This project strictly follows the **WordPress Coding Standards (WPCS)**.

```bash
# Run linting check
composer run phpcs

# Fix auto-fixable errors
composer run phpcbf
```

## 🗺 Roadmap

- [ ] **v1.1:** Multi-button dock (Call + WhatsApp + Book fan-out on tap).
- [ ] **v1.2:** A/B testing for CTA labels with auto-promotion.
- [ ] **v1.3:** Click analytics dashboard within the WordPress admin.

## 📄 License

This project is licensed under the GPL-2.0-or-later License.