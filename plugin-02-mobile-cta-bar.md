# Masterplan: Mobile CTA Bar — Floating Action Button

> **Plugin Codename:** `mobile-cta-bar`
> **Type:** WordPress Plugin (Free, WP.org)
> **Target Niche:** Aesthetic Clinics, Restaurants, Local Services, Any Mobile-Heavy Business
> **CTAFlow Goal:** Fix the #1 mobile conversion leak → Passive lead generation via "Powered by CTAFlow"

---

## 1. The Problem We're Solving

A typical aesthetic clinic gets 65–75% of its web traffic from mobile devices. Yet the standard WordPress theme is designed around a desktop experience:

- The phone number is buried in the header — impossible to find when scrolling
- The "Book Now" button only exists in the hero section — invisible once the user scrolls down
- Contact forms are at the bottom of a long page

The visitor is ready to act (they've been reading for 90 seconds), but they can't find the CTA quickly. They close the tab. This is a "lead leak."

**This is the single easiest fix that has the highest ROI for any local service business.**

---

## 2. The Solution

A plugin that injects a **permanently visible Floating Action Button (FAB)** at the bottom of the screen on **mobile devices only**. The button stays fixed as the user scrolls and can trigger a phone call, open a booking link, or open a WhatsApp chat — all with a single tap.

No page builder, no theme editing, no code. Install → Configure → Convert.

---

## 3. Core Features (MVP)

| Feature                     | Description                                                                                              |
| --------------------------- | -------------------------------------------------------------------------------------------------------- |
| **Multiple Action Types**   | Button can trigger: Phone Call, Open URL (booking page), WhatsApp Chat, Smooth Scroll to a Section (#id) |
| **Custom Text & Icon**      | Editable button label + choice of preset SVG icons (phone, calendar, WhatsApp, message)                  |
| **Color Customization**     | Background color, text color, icon color — all via the WP Customizer                                     |
| **Mobile-Only Display**     | The button is _never_ shown on tablet or desktop — clean separation of UX                                |
| **Show/Hide Rules (Basic)** | Option to hide on specific pages (e.g., hide on the actual contact page so it's not redundant)           |
| **Entrance Animation**      | Button slides up from the bottom after a configurable delay (e.g., 3 seconds, or on scroll past 50%)     |

---

## 4. Premium Features (Future v2 / Upsell)

- **Multi-Button Dock:** A cluster of 2-3 buttons that fan out on tap (e.g., Call + WhatsApp + Book)
- **A/B Testing:** Test two different CTA labels and automatically promote the winner after 100 sessions
- **Session Frequency Control:** Hide the button for returning visitors who have already clicked it (reduces annoyance, increases click quality)
- **Click Analytics:** A simple dashboard showing total clicks, click rate by page, and device breakdown

---

## 5. Technical Specification

### Stack

- **Language:** PHP (plugin core, settings), Vanilla JS (display logic), CSS (button styles)
- **Settings UI:** WordPress Settings API (simple admin options page) or WP Customizer for live preview
- **No jQuery, No React** — single small JS file, loaded in footer only

### File Structure

```
mobile-cta-bar/
├── mobile-cta-bar.php           # Main file, metadata, settings registration
├── readme.txt
├── assets/
│   ├── css/
│   │   └── mobile-cta-bar.css   # FAB styles + entrance animation
│   └── js/
│       └── mobile-cta-bar.js    # Show/hide logic, scroll trigger, delay
├── includes/
│   ├── class-settings.php       # WordPress Settings API handler
│   └── class-renderer.php       # Outputs the HTML for the FAB
└── admin/
    └── settings-page.php        # Admin UI template
```

### Performance Rules

- CSS/JS only loads on the **frontend** — never in the admin
- Uses CSS media query `@media (max-width: 767px)` as an additional layer of protection so the button is never visible on desktop even if JS fails
- Total asset weight target: **< 5kb combined** (unminified). Minified production build should be < 2kb.

---

## 6. Design Specification

**The Button:**

- Fixed position: `bottom: 20px`, centered horizontally (`left: 50%`, `transform: translateX(-50%)`)
- Shape: Pill/rounded-rectangle (not a circle — gives more room for text label)
- Height: 52px minimum (accessibility — large touch target)
- Shadow: `0 4px 20px rgba(0,0,0,0.25)` — lifted off the page
- Font weight: 600 (Semi-bold) — clear and readable at a glance

**Animation:**

- Default: Slide up from `translateY(100px)` to `translateY(0)` with `ease-out` over 400ms
- Triggered after 3 seconds of page load (configurable)

**WhatsApp Action:**

- Pre-populates a message: `"Hi, I'm interested in a consultation."` (customizable)
- Opens `https://wa.me/{phone_number}?text={message}` — no WhatsApp library needed

---

## 7. Admin Settings UI

The settings page should be extremely simple. Avoid overwhelming the user with options.

```
Mobile CTA Bar Settings
──────────────────────────────────────
Button Label:        [  Book Free Consultation  ]
Action Type:         ○ Phone Call  ● Open URL  ○ WhatsApp
Action Value:        [  https://yourclinic.com/book  ]
Button Color:        [  #C9A96E  ] (color picker)
Text Color:          [  #FFFFFF  ]
Show After (secs):   [  3  ]
──────────────────────────────────────
[ Save Settings ]                   [ Preview on Mobile →]
```

---

## 8. WP.org Listing Strategy

**Plugin Name:** `Mobile CTA Bar – Sticky Floating Button for Call, WhatsApp & Booking`

**Short Description (150 chars):**

> Add a permanent, beautiful floating CTA button to your site on mobile. One tap to call, book, or message. Zero code required.

**Tags:** `mobile`, `cta`, `floating button`, `click to call`, `whatsapp`, `booking`

**Key screenshots:**

1. A phone screen showing the button overlaying a clinic website (real, beautiful screenshot)
2. The admin settings page (clean, simple)
3. A click analytics dashboard (v2 feature — shown as "coming soon" to build anticipation)

---

## 9. The CTAFlow Hook

**Default footer attribution (can be disabled):**

> `Mobile CTA by Mobile CTA Bar · Powered by CTAFlow`

**The referral landing page** at `ctaflow.com/mobile-cta-bar`:

1. Headlines: _"Your mobile visitors can't find your phone number. We fixed that."_
2. Animated demo GIF or short video showing the button appearing
3. A lead capture form: _"Is your website leaking leads? Get a free audit."_

---

## 10. Go-To-Market Plan

1. **Build MVP** (Target: 1 week — this is the simplest plugin of the four)
2. **Test on multiple WP themes** (Astra, GeneratePress, Elementor-based)
3. **Submit to WP.org**
4. **Cold Outreach Asset:** When doing the "Lead Leak" video audit for a clinic, add a slide showing their broken mobile CTA, then say: _"I actually built a free plugin that solves this. I installed it on other clinic sites. Want me to show you?"_

---

## 11. Success Metrics

| Metric                                | Target (3 months) |
| ------------------------------------- | ----------------- |
| Active Installs                       | 100+              |
| WP.org Rating                         | 4.5+ stars        |
| CTAFlow referral traffic              | 50+ visits/month  |
| Audit conversations opened via plugin | 3+                |

---

## 12. readme.txt (Complete WP.org File)

```txt
=== Mobile CTA Bar – Sticky Floating Button for Call, WhatsApp & Booking ===
Contributors: ctaflow
Tags: mobile, cta, floating button, click to call, whatsapp, booking
Requires at least: 5.9
Tested up to: 6.7
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Add a permanent floating CTA button to your site on mobile. One tap to call, book, or message. Zero code required.

== Description ==

65–75% of local business website traffic comes from mobile — yet most WordPress themes bury the phone number in the header and hide the "Book Now" button at the top of the page. Once a visitor scrolls, your most important CTA disappears.

**Mobile CTA Bar** fixes this in minutes.

Install the plugin, set your button label and action, and a beautiful floating button will appear at the bottom of every mobile screen — staying permanently visible as the user scrolls. One tap to call. One tap to book. One tap to start a WhatsApp conversation.

No page builder. No theme editing. No code.

= Who is this for? =

* Aesthetic clinics & medspas
* Restaurants & cafes
* Law firms & consultants
* Real estate agents
* Any local business that gets mobile traffic and wants more leads

= Core Features =

* **Click-to-Call** — Tapping the button instantly dials your phone number
* **Open URL** — Send visitors directly to your booking page, menu, or any link
* **WhatsApp Chat** — Opens WhatsApp with a pre-filled message (fully customizable)
* **Smooth Scroll** — Scrolls the page to a specific section using an anchor ID (#contact)
* **Custom Label & Icon** — Set any button text and choose from preset icons (phone, calendar, WhatsApp, message)
* **Color Customization** — Set background color, text color, and icon color
* **Mobile-Only Display** — The button is never shown on tablets or desktops
* **Page-Level Hide Rules** — Suppress the button on specific pages (e.g., the contact page itself)
* **Entrance Animation** — Button slides up from the bottom after a configurable delay
* **Lightweight** — Total asset size under 2kb minified. No jQuery. No React. No bloat.

= Privacy =

This plugin does not collect, store, or transmit any personal data. No cookies are set. No external services are contacted. Full GDPR compliance out of the box.

= Coming in Pro (v2) =

* Multi-button dock (Call + WhatsApp + Book fan-out on tap)
* A/B testing — test two CTA labels and auto-promote the winner
* Session frequency control — hide for visitors who already clicked
* Click analytics dashboard — clicks, click rate by page, device breakdown

== Installation ==

1. Upload the `mobile-cta-bar` folder to the `/wp-content/plugins/` directory, or install via **Plugins → Add New** in your WordPress dashboard.
2. Activate the plugin through the **Plugins** menu.
3. Go to **Settings → Mobile CTA Bar** to configure your button.
4. Set your button label, choose an action type (Call, URL, WhatsApp, or Scroll), and enter the action value.
5. Customize colors and entrance delay to match your brand.
6. Click **Save Settings** and visit your site on a mobile device to see the button in action.

== Frequently Asked Questions ==

= Will this button show on desktop? =

No. The button is hidden on all screens wider than 767px using both CSS media queries and JavaScript. Desktop visitors will never see it.

= Does it work with Elementor, Divi, or Astra? =

Yes. The plugin injects directly into the page footer and is fully theme-agnostic. It has been tested with Astra, GeneratePress, OceanWP, and Elementor-based themes.

= Can I hide the button on specific pages? =

Yes. In the settings page, you can enter a comma-separated list of page IDs or slugs where the button should be hidden (for example: your contact page or checkout page).

= How do I set up the WhatsApp action? =

Select "WhatsApp" as the action type, then enter your phone number in international format (e.g., `628123456789` for an Indonesian number). You can also customize the pre-filled message text.

= Is this plugin free? =

Yes. The core plugin is 100% free and always will be. A Pro version with advanced features (multi-button, A/B testing, analytics) is planned for a future release.

= Will it slow down my site? =

No. The CSS and JS files combined weigh less than 2kb minified and are only loaded on the frontend (never in the admin). The plugin uses no external dependencies.

= Can I change the button's appearance? =

Yes. You can set the background color, text color, and icon color directly from the settings page. Advanced CSS customization is also possible via your theme's Additional CSS section.

== Screenshots ==

1. The floating CTA button as seen by a mobile visitor on a clinic website
2. The admin settings page — simple, clean, and distraction-free
3. WhatsApp action in use — opens a chat with a pre-filled message

== Changelog ==

= 1.0.0 =
* Initial release
* Support for four action types: Phone Call, Open URL, WhatsApp Chat, Smooth Scroll
* Customizable label, icon, background color, and text color
* Mobile-only display with CSS + JS dual enforcement
* Configurable entrance animation with delay
* Per-page hide rules

== Upgrade Notice ==

= 1.0.0 =
Initial release. No upgrade steps required.
```
