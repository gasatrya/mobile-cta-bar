# MobiFlow - Project Context

## Project Overview
**MobiFlow** is a lightweight, performance-optimized WordPress plugin designed to add a sticky floating "Call to Action" (CTA) button to websites, specifically for mobile devices. It aims to solve "lead leaks" for local businesses (clinics, restaurants, law firms) by ensuring a primary contact action (Call, WhatsApp, Booking URL, or Smooth Scroll) is always within thumb-reach as a user scrolls.

- **Primary Goal:** Increase mobile conversions by providing a permanent, high-visibility CTA.
- **Key Features:** Click-to-call, WhatsApp integration with pre-filled messages, smooth scroll to anchor IDs, custom styling (colors, sizes, icons), and page-level exclusion rules.
- **Performance:** Sub-5kb total asset size, zero external dependencies, and dual-layer (CSS + JS) mobile-only enforcement.

## Core Tech Stack
- **Language:** PHP 8.0+ (Namespaced, OOP).
- **Platform:** WordPress 6.9+.
- **Coding Standards:** WordPress Coding Standards (WPCS).
- **Dev Tools:** Composer, PHPCS.

## Building and Running
As this is a WordPress plugin, it requires a local WordPress environment (e.g., LocalWP, DevKinsta, or a manual LAMP/LEMP stack).

### Development Setup
```bash
# Install development dependencies (PHPCS, WPCS)
composer install
```

### Linting & Quality Control
```bash
# Run PHP CodeSniffer (WordPress Coding Standards)
composer run phpcs

# Automatically fix linting issues
composer run phpcbf
```

## Development Conventions
- **WordPress Coding Standards (WPCS):** Strictly followed for PHP (indentation with tabs, spacing, naming).
- **Security:** All outputs must be escaped (`esc_html`, `esc_attr`, `esc_url`). All inputs must be sanitized (`sanitize_text_field`, `absint`). Use nonces for admin actions.
- **No jQuery:** JavaScript must remain dependency-free to ensure maximum performance and compatibility.
- **Namespacing:** All PHP classes are under the `MobiFlow` namespace.
- **Autoloading:** Manual PSR-4 implementation in the main plugin file; avoid manual `require_once` for class files.